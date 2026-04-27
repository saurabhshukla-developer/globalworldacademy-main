<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'exam_tag', 'description', 'thumb_class', 'thumb_icon',
        'badge', 'badge_style', 'features', 'price', 'old_price',
        'buy_url', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'features'   => 'array',
        'is_active'  => 'boolean',
        'price'      => 'decimal:2',
        'old_price'  => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return (int) round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return null;
    }
}
