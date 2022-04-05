<?php

namespace Codictive\Cms\Traits;

trait RecursiveCategory
{
    /**
     * Returns an array of all items in hierarchical order.
     *
     * @param int $parent
     *
     * @return array
     */
    public static function hierarchical($parent = null)
    {
        $result = [];

        $items = self::where('parent_id', $parent)->orderBy('weight')->orderBy('name')->get();
        foreach ($items as $i) {
            $result[] = [
                'item'   => $i,
                'childs' => self::hierarchical($i->id),
            ];
        }

        return $result;
    }

    /**
     * Return Category's all parents.
     *
     * @return array
     */
    public function parents()
    {
        $result = [];
        $parent = $this->parent;
        while ($parent) {
            $result[] = $parent;
            $parent   = $parent->parent;
        }

        return $result;
    }
}
