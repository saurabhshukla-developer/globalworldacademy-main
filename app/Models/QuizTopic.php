<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class QuizTopic extends Model
{
    protected $fillable = [
        'subject_id', 'name', 'name_hi', 'slug', 'description', 'icon', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'subject_id' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(fn ($m) => $m->slug ??= Str::slug($m->name));
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(QuizSubject::class, 'subject_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'topic_id');
    }

    public function activeQuestions(): HasMany
    {
        return $this->questions()->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getLocalNameAttribute(): string
    {
        return app()->getLocale() === 'hi' && $this->name_hi
            ? $this->name_hi
            : $this->name;
    }
}
