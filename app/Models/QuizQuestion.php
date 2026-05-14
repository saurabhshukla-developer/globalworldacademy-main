<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    protected $fillable = [
        'topic_id', 'question', 'question_hi', 'options', 'answer_index',
        'explanation', 'explanation_hi', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
        'answer_index' => 'integer',
        'sort_order' => 'integer',
        'topic_id' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (QuizQuestion $model) {
            $model->content_hash = self::contentHashFrom(
                (string) $model->question,
                $model->options ?? [],
                (int) $model->answer_index
            );
        });
    }

    /** Normalize question text for duplicate detection (English column only). */
    public static function normalizeQuestionText(string $question): string
    {
        $collapsed = preg_replace('/\s+/u', ' ', trim(mb_strtolower($question)));

        return is_string($collapsed) ? $collapsed : '';
    }

    /**
     * @param  list<string>|array<int, string>  $options
     * @return list<string>
     */
    public static function normalizeOptions(array $options): array
    {
        $out = [];
        foreach (array_values($options) as $opt) {
            $c = preg_replace('/\s+/u', ' ', trim(mb_strtolower((string) $opt)));
            $out[] = is_string($c) ? $c : '';
        }

        return $out;
    }

    /**
     * @param  list<string>|array<int, string>  $options
     */
    public static function contentHashFrom(string $question, array $options, int $answerIndex): string
    {
        $normalizedOpts = self::normalizeOptions($options);

        return hash(
            'sha256',
            self::normalizeQuestionText($question).'|'.json_encode($normalizedOpts, JSON_UNESCAPED_UNICODE).'|'.$answerIndex
        );
    }

    public static function fingerprintExists(string $hash, ?int $exceptId = null): bool
    {
        $q = static::query()->where('content_hash', $hash);
        if ($exceptId !== null) {
            $q->where('id', '!=', $exceptId);
        }

        return $q->exists();
    }

    public function quizTopic(): BelongsTo
    {
        return $this->belongsTo(QuizTopic::class, 'topic_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Locale-aware question text */
    public function getLocalQuestionAttribute(): string
    {
        return app()->getLocale() === 'hi' && $this->question_hi
            ? $this->question_hi
            : $this->question;
    }

    /** Locale-aware explanation */
    public function getLocalExplanationAttribute(): string
    {
        return app()->getLocale() === 'hi' && $this->explanation_hi
            ? $this->explanation_hi
            : ($this->explanation ?? '');
    }
}
