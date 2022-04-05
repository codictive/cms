<?php

namespace Codictive\Cms\Helpers\Cache;

use Carbon\Carbon;
use Codictive\Cms\Models\SystemLog;
use Illuminate\Support\Facades\Cache;
use Codictive\Cms\Models\ArticleCategory;

class CategoryCache
{
    /**
     * Returns categories cache time to live.
     *
     * @return int
     */
    public static function ttl()
    {
        $ttl = (int) kv('cache.categories.ttl');
        if (0 == $ttl) {
            return;
        }

        return Carbon::now()->addMinutes($ttl);
    }

    /**
     * Returns categories cache.
     *
     * @return array
     */
    public static function get()
    {
        if (self::ttl() == null) {
            return Cache::rememberForever(CACHE_KEY_CATEGORIES, function () {
                SystemLog::info('[helpers.Cache.CategoriesCache.get]', 'Categories cache not found. Generating now...');

                return self::generate();
            });
        }

        return Cache::remember(CACHE_KEY_CATEGORIES, self::ttl(), function () {
            SystemLog::info('[helpers.Cache.CategoriesCache.get]', 'Categories cache not found. Generating now...');

            return self::generate();
        });
    }

    /**
     * Generates location cache data.
     *
     * @param mixed|null $parent
     *
     * @return array
     */
    public static function generate($parent = null)
    {
        set_time_limit(600);
        $result     = [];
        $categories = ArticleCategory::with([])->where('parent_id', $parent)->orderBy('weight')->orderBy('name')->get();
        foreach ($categories as $c) {
            $data = [
                'id'         => $c->id,
                'name'       => $c->name,
                'slug'       => $c->slug,
                'weight'     => $c->weight,
                'children'   => self::generate($c->id),
            ];

            $result[] = $data;
        }

        return $result;
    }

    /**
     * Re-generates categories and stores in the cache.
     */
    public static function reload()
    {
        self::delete();
        if (self::ttl() == null) {
            Cache::forever(CACHE_KEY_CATEGORIES, self::generate());

            return;
        }

        Cache::put(CACHE_KEY_CATEGORIES, self::generate(), self::ttl());
    }

    /**
     * Deletes loctions from the cache.
     */
    public static function delete()
    {
        Cache::forget(CACHE_KEY_CATEGORIES);
    }
}
