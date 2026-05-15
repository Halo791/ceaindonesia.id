<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUpdate extends Model
{
    protected $fillable = [
        'owner_section_key',
        'owner_item_key',
        'title',
        'slug',
        'category',
        'excerpt',
        'body',
        'image_path',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
