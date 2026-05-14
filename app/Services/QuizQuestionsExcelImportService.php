<?php

namespace App\Services;

use App\Models\QuizQuestion;
use App\Models\QuizSubject;
use App\Models\QuizTopic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuizQuestionsExcelImportService
{
    public const MAX_DATA_ROWS = 1000;

    /** @var list<string> */
    private array $errors = [];

    public function createTemplateSpreadsheet(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet;

        $subjects = QuizSubject::active()->orderBy('sort_order')->orderBy('id')->get();
        $topics = QuizTopic::with('subject')->active()->orderBy('subject_id')->orderBy('sort_order')->get();

        $instructions = $spreadsheet->getActiveSheet();
        $instructions->setTitle('Instructions');
        $instructions->setCellValue('A1', 'Quiz questions Excel import — how to use');
        $instructions->mergeCells('A1:F1');
        $instructions->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $lines = [
            '1. Fill in the "Questions" sheet only. Do not rename that sheet. Row 1 must remain the column headers.',
            '2. Each row is one MCQ with exactly four options (A–D). The file is validated first; nothing is saved if any row has errors.',
            '3. Topic linking: every row must include subject_id and topic_id (numeric IDs only). Copy them from "Subjects reference" and "Topics reference". topic_id must belong to that subject_id or the row fails validation.',
            '4. Columns on Questions: subject_id, topic_id, question, question_hi, option_a–d, answer (A/B/C/D or 1–4), explanation, explanation_hi, sort_order, is_active.',
            '5. Maximum '.self::MAX_DATA_ROWS.' question rows per file.',
            '6. Save as .xlsx and upload from Admin → Quiz Questions → Import.',
        ];

        $r = 3;
        foreach ($lines as $line) {
            $instructions->setCellValue('A'.$r, $line);
            $r++;
        }
        $instructions->getColumnDimension('A')->setWidth(108);

        $subjectsSheet = new Worksheet($spreadsheet, 'Subjects reference');
        $spreadsheet->addSheet($subjectsSheet);

        $subjectsSheet->setCellValue('A1', 'subject_id');
        $subjectsSheet->setCellValue('B1', 'subject_name');
        $subjectsSheet->setCellValue('C1', 'subject_name_hi');
        $subjectsSheet->setCellValue('D1', 'slug');
        $subjectsSheet->setCellValue('E1', 'icon');

        $sRow = 2;
        foreach ($subjects as $subject) {
            $subjectsSheet->setCellValue('A'.$sRow, $subject->id);
            $subjectsSheet->setCellValue('B'.$sRow, $subject->name);
            $subjectsSheet->setCellValue('C'.$sRow, $subject->name_hi ?? '');
            $subjectsSheet->setCellValue('D'.$sRow, $subject->slug);
            $subjectsSheet->setCellValue('E'.$sRow, $subject->icon ?? '');
            $sRow++;
        }

        foreach (range('A', 'E') as $col) {
            $subjectsSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $topicsSheet = new Worksheet($spreadsheet, 'Topics reference');
        $spreadsheet->addSheet($topicsSheet);

        $topicsSheet->setCellValue('A1', 'topic_id');
        $topicsSheet->setCellValue('B1', 'subject_id');
        $topicsSheet->setCellValue('C1', 'topic_name');
        $topicsSheet->setCellValue('D1', 'topic_name_hi');

        $row = 2;
        foreach ($topics as $topic) {
            $topicsSheet->setCellValue('A'.$row, $topic->id);
            $topicsSheet->setCellValue('B'.$row, $topic->subject_id);
            $topicsSheet->setCellValue('C'.$row, $topic->name);
            $topicsSheet->setCellValue('D'.$row, $topic->name_hi ?? '');
            $row++;
        }

        foreach (range('A', 'D') as $col) {
            $topicsSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $questionsSheet = new Worksheet($spreadsheet, 'Questions');
        $spreadsheet->addSheet($questionsSheet);

        $headers = [
            'subject_id', 'topic_id', 'question', 'question_hi',
            'option_a', 'option_b', 'option_c', 'option_d', 'answer',
            'explanation', 'explanation_hi', 'sort_order', 'is_active',
        ];
        foreach ($headers as $i => $h) {
            $questionsSheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1).'1', $h);
        }

        $sampleTopic = $topics->first();

        $questionsSheet->setCellValue('A2', $sampleTopic ? $sampleTopic->subject_id : '');
        $questionsSheet->setCellValue('B2', $sampleTopic ? $sampleTopic->id : '');
        $questionsSheet->setCellValue('C2', 'What is 2 + 2?');
        $questionsSheet->setCellValue('D2', '');
        $questionsSheet->setCellValue('E2', '3');
        $questionsSheet->setCellValue('F2', '4');
        $questionsSheet->setCellValue('G2', '5');
        $questionsSheet->setCellValue('H2', '22');
        $questionsSheet->setCellValue('I2', 'B');
        $questionsSheet->setCellValue('J2', 'Sum of two and two is four.');
        $questionsSheet->setCellValue('K2', '');
        $questionsSheet->setCellValue('L2', '0');
        $questionsSheet->setCellValue('M2', 'yes');

        foreach (range(1, count($headers)) as $ci) {
            $questionsSheet->getColumnDimension(Coordinate::stringFromColumnIndex($ci))->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndexByName('Questions');

        return $spreadsheet;
    }

    public function importFromPath(string $absolutePath): QuizQuestionsExcelImportResult
    {
        $this->errors = [];

        try {
            $spreadsheet = IOFactory::load($absolutePath);
        } catch (\Throwable) {
            return new QuizQuestionsExcelImportResult(0, ['Could not read the Excel file. Save as .xlsx and try again.']);
        }

        $sheet = $spreadsheet->getSheetByName('Questions');
        if (! $sheet) {
            return new QuizQuestionsExcelImportResult(0, ['Missing sheet named "Questions". Download the template and keep that sheet name unchanged.']);
        }

        $highestRow = (int) $sheet->getHighestDataRow();
        $highestColumn = $sheet->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        if ($highestRow < 2) {
            return new QuizQuestionsExcelImportResult(0, ['The Questions sheet has no data rows (add questions from row 2 upward).']);
        }

        $headerRow = [];
        for ($c = 1; $c <= $highestColumnIndex; $c++) {
            $coord = Coordinate::stringFromColumnIndex($c).'1';
            $cellVal = $sheet->getCell($coord)->getCalculatedValue();
            $headerRow[$c] = $this->canonicalHeader($cellVal);
        }

        $colIndexes = [];
        foreach ($headerRow as $idx => $key) {
            if ($key !== null) {
                if (isset($colIndexes[$key])) {
                    return new QuizQuestionsExcelImportResult(0, ['Duplicate column "'.$key.'" in row 1.']);
                }
                $colIndexes[$key] = $idx;
            }
        }

        $requiredHeaders = ['subject_id', 'topic_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'answer'];
        foreach ($requiredHeaders as $req) {
            if (! isset($colIndexes[$req])) {
                return new QuizQuestionsExcelImportResult(0, ['Missing required column "'.$req.'" in row 1. Use the latest template (subject_id and topic_id required).']);
            }
        }

        /** @var list<array<string, mixed>> $parsedRows */
        $parsedRows = [];
        $dataRowCount = 0;

        for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
            $cells = [];
            foreach ($colIndexes as $key => $colIdx) {
                $coord = Coordinate::stringFromColumnIndex($colIdx).$rowNum;
                $cells[$key] = $sheet->getCell($coord)->getCalculatedValue();
            }

            if ($this->rowIsEmpty($cells, $requiredHeaders)) {
                continue;
            }

            $dataRowCount++;
            if ($dataRowCount > self::MAX_DATA_ROWS) {
                return new QuizQuestionsExcelImportResult(0, ['Too many question rows. Maximum is '.self::MAX_DATA_ROWS.'.']);
            }

            $rowErrors = $this->validateDataRow($cells);
            if ($rowErrors !== []) {
                foreach ($rowErrors as $e) {
                    $this->errors[] = 'Row '.$rowNum.': '.$e;
                }

                continue;
            }

            $parsedRows[] = $this->cellsToPayload($cells);
        }

        if ($dataRowCount === 0) {
            return new QuizQuestionsExcelImportResult(0, ['No question rows found. Enter data from row 2.']);
        }

        if ($this->errors !== []) {
            return new QuizQuestionsExcelImportResult(0, $this->errors);
        }

        $imported = 0;
        DB::transaction(function () use ($parsedRows, &$imported) {
            foreach ($parsedRows as $payload) {
                QuizQuestion::create($payload);
                $imported++;
            }
        });

        return new QuizQuestionsExcelImportResult($imported, []);
    }

    /**
     * @param  array<string, mixed>  $cells
     * @param  list<string>  $requiredKeys
     */
    private function rowIsEmpty(array $cells, array $requiredKeys): bool
    {
        foreach ($requiredKeys as $k) {
            if ($this->stringifyCell($cells[$k] ?? null) !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array<string, mixed>  $cells
     * @return list<string>
     */
    private function validateDataRow(array $cells): array
    {
        $errs = [];

        $question = $this->stringifyCell($cells['question'] ?? null);
        if ($question === '') {
            $errs[] = 'question is required.';
        }

        foreach (['option_a', 'option_b', 'option_c', 'option_d'] as $ok) {
            $v = $this->stringifyCell($cells[$ok] ?? null);
            if ($v === '') {
                $errs[] = str_replace('_', ' ', $ok).' is required.';
            } elseif (mb_strlen($v) > 255) {
                $errs[] = str_replace('_', ' ', $ok).' exceeds 255 characters.';
            }
        }

        $answerRaw = $this->stringifyCell($cells['answer'] ?? null);
        [, $answerErr] = $this->parseAnswerIndex($answerRaw);
        if ($answerErr !== null) {
            $errs[] = $answerErr;
        }

        $sidStr = $this->stringifyCell($cells['subject_id'] ?? null);
        $tidStr = $this->stringifyCell($cells['topic_id'] ?? null);
        if ($sidStr === '') {
            $errs[] = 'subject_id is required.';
        } elseif (! preg_match('/^\d+$/', $sidStr)) {
            $errs[] = 'subject_id must be a whole number.';
        }
        if ($tidStr === '') {
            $errs[] = 'topic_id is required.';
        } elseif (! preg_match('/^\d+$/', $tidStr)) {
            $errs[] = 'topic_id must be a whole number.';
        }

        if ($errs !== []) {
            return $errs;
        }

        $subjectId = (int) $sidStr;
        $topicId = (int) $tidStr;

        if (! QuizSubject::whereKey($subjectId)->exists()) {
            $errs[] = 'subject_id '.$subjectId.' does not exist.';

            return $errs;
        }

        $topic = QuizTopic::query()->whereKey($topicId)->first();
        if (! $topic) {
            $errs[] = 'topic_id '.$topicId.' does not exist.';

            return $errs;
        }

        if ((int) $topic->subject_id !== $subjectId) {
            $errs[] = 'topic_id '.$topicId.' belongs to subject_id '.$topic->subject_id.', not '.$subjectId.'. Check the Topics reference sheet.';
        }

        if (isset($cells['sort_order']) && $this->stringifyCell($cells['sort_order']) !== '') {
            $so = $this->stringifyCell($cells['sort_order']);
            if (! preg_match('/^\d+$/', $so)) {
                $errs[] = 'sort_order must be a non-negative integer.';
            } elseif ((int) $so > 65535) {
                $errs[] = 'sort_order must be at most 65535.';
            }
        }

        if (isset($cells['is_active']) && $this->stringifyCell($cells['is_active']) !== '') {
            [, $boolErr] = $this->parseBoolCell($this->stringifyCell($cells['is_active']));
            if ($boolErr !== null) {
                $errs[] = $boolErr;
            }
        }

        return $errs;
    }

    /**
     * @param  array<string, mixed>  $cells
     * @return array<string, mixed>
     */
    private function cellsToPayload(array $cells): array
    {
        $topicId = (int) $this->stringifyCell($cells['topic_id'] ?? null);

        [$answerIndex] = $this->parseAnswerIndex($this->stringifyCell($cells['answer'] ?? null));

        $options = [];
        foreach (['option_a', 'option_b', 'option_c', 'option_d'] as $ok) {
            $options[] = $this->stringifyCell($cells[$ok] ?? null);
        }

        $sortOrder = 0;
        if (isset($cells['sort_order']) && $this->stringifyCell($cells['sort_order']) !== '') {
            $sortOrder = min(65535, (int) $this->stringifyCell($cells['sort_order']));
        }

        $isActive = true;
        if (isset($cells['is_active']) && $this->stringifyCell($cells['is_active']) !== '') {
            [$isActive] = $this->parseBoolCell($this->stringifyCell($cells['is_active']));
        }

        return [
            'topic_id' => $topicId,
            'question' => $this->stringifyCell($cells['question'] ?? null),
            'question_hi' => $this->nullableString($cells['question_hi'] ?? null),
            'options' => $options,
            'answer_index' => $answerIndex,
            'explanation' => $this->nullableString($cells['explanation'] ?? null),
            'explanation_hi' => $this->nullableString($cells['explanation_hi'] ?? null),
            'is_active' => $isActive,
            'sort_order' => $sortOrder,
        ];
    }

    /**
     * @return array{0:int,1:?string}
     */
    private function parseAnswerIndex(string $raw): array
    {
        $r = trim($raw);
        if ($r === '') {
            return [0, 'answer is required (A–D or 1–4).'];
        }
        if (preg_match('/^[0-3]$/', $r)) {
            return [(int) $r, null];
        }
        if (preg_match('/^[1-4]$/', $r)) {
            return [(int) $r - 1, null];
        }
        $letter = strtoupper(mb_substr($r, 0, 1));
        $map = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3];

        return isset($map[$letter]) ? [$map[$letter], null] : [0, 'answer must be A, B, C, D or 1–4 (or 0–3).'];
    }

    /**
     * @return array{0:bool,1:?string}
     */
    private function parseBoolCell(string $raw): array
    {
        $l = mb_strtolower(trim($raw));
        if (in_array($l, ['1', 'yes', 'y', 'true', 'on'], true)) {
            return [true, null];
        }
        if (in_array($l, ['0', 'no', 'n', 'false', 'off'], true)) {
            return [false, null];
        }

        return [false, 'is_active must be yes/no, true/false, or 1/0.'];
    }

    private function stringifyCell(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        if (is_float($value) && floor($value) == $value) {
            return (string) (int) $value;
        }
        if (is_int($value)) {
            return (string) $value;
        }

        return trim((string) $value);
    }

    private function nullableString(mixed $value): ?string
    {
        $s = $this->stringifyCell($value);

        return $s === '' ? null : $s;
    }

    private function canonicalHeader(mixed $raw): ?string
    {
        if ($raw === null) {
            return null;
        }
        $t = trim((string) $raw);
        if ($t === '') {
            return null;
        }
        $n = Str::snake(str_replace(['-', ' '], '_', mb_strtolower($t)));
        $alias = [
            'topicid' => 'topic_id',
            'subjectid' => 'subject_id',
            'correct_answer' => 'answer',
            'answer_key' => 'answer',
            'option1' => 'option_a',
            'option_1' => 'option_a',
            'option2' => 'option_b',
            'option_2' => 'option_b',
            'option3' => 'option_c',
            'option_3' => 'option_c',
            'option4' => 'option_d',
            'option_4' => 'option_d',
        ];
        if (isset($alias[$n])) {
            return $alias[$n];
        }

        $allowed = [
            'subject_id', 'topic_id', 'question', 'question_hi',
            'option_a', 'option_b', 'option_c', 'option_d', 'answer',
            'explanation', 'explanation_hi', 'sort_order', 'is_active',
        ];

        return in_array($n, $allowed, true) ? $n : null;
    }
}
