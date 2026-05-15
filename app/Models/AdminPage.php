<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminPage extends Model
{
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'menu_label',
        'subtitle',
        'body',
        'image_path',
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
