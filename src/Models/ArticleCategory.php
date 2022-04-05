<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Codictive\Cms\Traits\RecursiveCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleCategory extends Model
{
    use RecursiveCategory;

    protected $fillable = ['parent_id', 'name', 'slug', 'description', 'weight'];

    /**
     * Defines relation with ArticleCategory model for it's children.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ArticleCategory::class, 'parent_id');
    }

    /**
     * Defines relation with ArticleCategory model for it's possible parent.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'parent_id');
    }

    /**
     * Defines relation with Article model.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function childIds(?ArticleCategory $category = null)
    {
        if (null == $category) {
            $category = $this;
        }

        $ids = [];
        foreach ($category->children as $ch) {
            $ids = array_merge($ids, [$ch->id], $this->childIds($ch));
        }

        return $ids;
    }
}
