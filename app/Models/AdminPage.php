<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminPage extends Model
{
    protected $fillable = [
        'parent_id',
        'navigation_parent_key',
        'title',
        'title_en',
        'slug',
        'menu_label',
        'menu_label_en',
        'subtitle',
        'subtitle_en',
        'body',
        'body_en',
        'image_path',
        'external_url',
        'status',
        'show_in_navigation',
        'sort_order',
    ];

    protected $casts = [
        'show_in_navigation' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('title');
    }
}
