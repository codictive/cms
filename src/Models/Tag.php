<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Fetches Tag having given name.
     */
    public static function byName(string $name): Tag | null
    {
        return Tag::where('name', $name)->first();
    }

    /**
     * Defines relation with Article model.
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tags')->withTimestamps();
    }
}
