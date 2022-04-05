<?php

namespace Codictive\Cms\Helpers\Cache;

use Carbon\Carbon;
use Codictive\Cms\Models\Province;
use Codictive\Cms\Models\SystemLog;
use Illuminate\Support\Facades\Cache;

class LocationCache
{
    /**
     * Returns locations cache time to live.
     *
     * @return int
     */
    public static function ttl()
    {
        $ttl = (int) kv('cache.locations.ttl');
        if (0 == $ttl) {
            return;
        }

        return Carbon::now()->addMinutes($ttl);
    }

    /**
     * Returns locations cache.
     *
     * @return array
     */
    public static function get()
    {
        if (self::ttl() == null) {
            return Cache::rememberForever(CACHE_KEY_LOCATIONS, function () {
                SystemLog::info('[helpers.Cache.LocationCache.get]', ' Locations cache not found. Generating now...');

                return self::generate();
            });
        }

        return Cache::remember(CACHE_KEY_LOCATIONS, self::ttl(), function () {
            SystemLog::info('[helpers.Cache.LocationCache.get]', 'Locations cache not found. Generating now...');

            return self::generate();
        });
    }

    /**
     * Generates location cache data.
     *
     * @return array
     */
    public static function generate()
    {
        set_time_limit(600);
        $locations = [];
        $provinces = Province::orderBy('weight')->orderBy('name')->get();
        foreach ($provinces as $p) {
            $province = ['id' => $p->id, 'name' => $p->name, 'cities' => []];
            foreach ($p->cities()->orderBy('weight')->orderBy('name')->get() as $c) {
                $city = ['id' => $c->id, 'name' => $c->name, 'districts' => []];

                $province['cities'][] = $city;
            }

            $locations[] = $province;
        }

        return $locations;
    }

    /**
     * Re-generates locations and stores in the cache.
     */
    public static function reload()
    {
        self::delete();
        if (self::ttl() == null) {
            Cache::forever(CACHE_KEY_LOCATIONS, self::generate());

            return;
        }

        Cache::put(CACHE_KEY_LOCATIONS, self::generate(), self::ttl());
    }

    /**
     * Deletes loctions from the cache.
     */
    public static function delete()
    {
        Cache::forget(CACHE_KEY_LOCATIONS);
    }
}
