<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class QuizCategory extends Model
{
    protected $fillable = [
        'name', 'name_hi', 'slug', 'description', 'description_hi',
        'icon', 'color', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn($m) => $m->slug ??= Str::slug($m->name));
    }

    public function topics(): HasMany
    {
        return $this->hasMany(QuizTopic::class, 'category_id')->orderBy('sort_order');
    }

    public function activeTopics(): HasMany
    {
        return $this->topics()->where('is_active', true);
    }

    /** Total questions count through topics */
    public function questionsCount(): int
    {
        return $this->topics()->withCount('questions')->get()->sum('questions_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    /** Display name respecting locale */
    public function getLocalNameAttribute(): string
    {
        return app()->getLocale() === 'hi' && $this->name_hi
            ? $this->name_hi
            : $this->name;
    }
}
