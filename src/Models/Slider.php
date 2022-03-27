<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Defines relatio with SliderItem model.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SliderItem::class);
    }

    /**
     * Deletes slider and it's items both from disk (item images) and database.
     */
    public function purge()
    {
        foreach ($this->items as $item) {
            $item->purge();
        }

        $this->delete();
    }
}
