<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $fillable = ['name', 'province_id', 'weight'];

    /**
     * Defines relation with Province model.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
