<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/profiles',
    GENDER_MALE              = 'male',
    GENDER_FEMALE            = 'female';

    protected $fillable = [
        'user_id',
        'province_id',
        'city_id',
        'name',
        'gender',
        'national_code',
        'lat',
        'lng',
    ];
    protected $casts = [
        'lat'         => 'float',
        'lng'         => 'float',
        'is_approved' => 'bool',
    ];

    /**
     * Defines relation with User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines relation with Province model.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Defines relation with City model.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Defines relation with District model.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Deletes Profile image file from the disk.
     */
    public function removeImage()
    {
        if (! $this->image) {
            return;
        }

        unlinkIfExists(sprintf('%s/%s', self::STORAGE_DIR, $this->image));
    }

    /**
     * Deletes Profile database record along with it's image from file system.
     */
    public function purge()
    {
        $this->removeImage();

        $this->delete();
    }
}
