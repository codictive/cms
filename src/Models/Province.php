<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['name', 'weight'];

    /**
     * Defines relation with City model.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
