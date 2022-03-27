<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/articles';

    protected $fillable = [
        'author_id',
        'article_category_id',
        'title',
        'slug',
        'headline',
        'summary',
        'body',
        'meta_keywords',
        'meta_description',
    ];
    protected $casts = [
        'published'           => 'boolean',
        'promote_to_homepage' => 'boolean',
        'stick_to_top'        => 'boolean',
    ];

    /**
     * Defines relation with User model.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Defines relation with ArticleCategory model.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    /**
     * Defines relation with Tag model.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags')->withTimestamps();
    }

    /**
     * Defines relation with File model.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'attachable');
    }

    /**
     * Defines relation with Comment model.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Deletes article image file from the disk.
     */
    public function removeImage()
    {
        if (! $this->image) {
            return;
        }

        unlinkIfExists(sprintf('%s/%s', self::STORAGE_DIR, $this->image));
    }

    /**
     * Deletes article database record along with it's image from file system.
     */
    public function purge()
    {
        $this->removeImage();
        // Purge associated Files.
        foreach ($this->files as $f) {
            $f->purge();
        }

        $this->delete();
    }
}
