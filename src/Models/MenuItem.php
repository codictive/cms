<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = ['menu_id', 'parent_id', 'title', 'path', 'weight'];

    /**
     * Defines relation with Menu model.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Defines relation with MenuItem model for it's children.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    /**
     * Defines relation with MenuItem model for it's possible parent.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Returns MenuItem childs ordered by weight.
     */
    public function childs(): Collection
    {
        return $this->children()->orderBy('weight')->get();
    }
}
