<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/pages';

    protected $fillable = [
        'title',
        'slug',
        'headline',
        'summary',
        'body',
        'meta_keywords',
        'meta_description',
    ];

    /**
     * Deletes Page image file from the disk.
     */
    public function removeImage()
    {
        if (! $this->image) {
            return;
        }

        unlinkIfExists(sprintf('%s/%s', self::STORAGE_DIR, $this->image));
    }

    /**
     * Deletes Page database record along with it's image from file system.
     */
    public function purge()
    {
        $this->removeImage();
        $this->delete();
    }
}
