<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminContent extends Model
{
    protected $fillable = [
        'section_key',
        'item_key',
        'title',
        'subtitle',
        'body',
        'image_path',
        'source_href',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
