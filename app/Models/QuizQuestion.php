<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'topic', 'question', 'options', 'answer_index', 'explanation', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'options'      => 'array',
        'is_active'    => 'boolean',
        'answer_index' => 'integer',
        'sort_order'   => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public static function topicLabel(string $topic): string
    {
        return match($topic) {
            'science'   => '🔬 Science',
            'child_dev' => '👶 Child Development',
            'gk'        => '🌍 General Knowledge',
            'mp'        => '🗺️ MP GK',
            default     => ucfirst($topic),
        };
    }

    public static function topics(): array
    {
        return ['science', 'child_dev', 'gk', 'mp'];
    }
}
