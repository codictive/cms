<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SliderItem extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/slider';

    protected $fillable = ['slider_id', 'image', 'caption', 'link', 'weight'];

    /**
     * Defines relation to Slider model.
     */
    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class);
    }

    /**
     * Deletes banner file from the disk.
     */
    public function removeFile()
    {
        if (! $this->image) {
            return;
        }

        unlinkIfExists(sprintf('%s/%s', AdBanner::STORAGE_DIR, $this->image));
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
