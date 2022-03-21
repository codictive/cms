<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    /**
     * Fetches Tag having given name.
     */
    public static function byName(string $name): Tag | null
    {
        return Tag::where('name', $name)->first();
    }
}
