<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Defines relation with MenuItem model.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Retrives all MenuItems recursively.
     *
     * @param int $parent
     */
    public function itemsRecursive($parent = null)
    {
        $result = [];
        $path   = '/' . request()->path();
        $items  = $this->items()->where('parent_id', $parent)->orderBy('weight')->get();
        foreach ($items as $item) {
            $d = [
                'id'     => $item->id,
                'title'  => $item->title,
                'path'   => $item->path,
                'active' => $item->path == $path || startsWith($path, $item->prefix),
                'childs' => $this->itemsRecursive($item->id),
            ];
            foreach ($d["childs"] as $c) {
                if ($c['active']) {
                    $d['active'] = true;
                    break;
                }
            }
            $result[] = $d;
        }

        return $result;
    }
}
