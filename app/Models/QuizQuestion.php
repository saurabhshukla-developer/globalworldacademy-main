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
