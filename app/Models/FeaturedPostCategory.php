<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedPostCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'position',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public static function getFeaturedSlugsString()
    {
        return self::orderBy('position')->pluck('slug')->implode(',');
    }
}
