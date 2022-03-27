<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/banners';

    protected $fillable = [
        'name',
        'link',
        'file_name',
        'kind',
        'mimetype',
        'size',
    ];

    /**
     * Deletes banner file from the disk.
     */
    public function removeFile()
    {
        if (! $this->file_name) {
            return;
        }

        unlinkIfExists(sprintf('%s/%s', AdBanner::STORAGE_DIR, $this->file_name));
    }

    /**
     * Deletes both banner file on disk and database record.
     */
    public function purge()
    {
        $this->removeFile();
        $this->delete();
    }
}
