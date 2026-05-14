<?php

namespace App\Services;

final class QuizQuestionsExcelImportResult
{
    /**
     * @param  list<string>  $errors
     */
    public function __construct(
        public readonly int $imported,
        public readonly array $errors,
    ) {}

    public function ok(): bool
    {
        return $this->errors === [];
    }
}
