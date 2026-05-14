<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = [
        'topic_id', 'title', 'description', 'icon', 'icon_bg_class', 'tags',
        'file_path', 'external_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
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
}
