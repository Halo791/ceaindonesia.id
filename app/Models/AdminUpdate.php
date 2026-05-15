<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUpdate extends Model
{
    protected $fillable = [
        'owner_section_key',
        'owner_item_key',
        'title',
        'title_en',
        'slug',
        'category',
        'category_en',
        'excerpt',
        'excerpt_en',
        'body',
        'body_en',
        'image_path',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
