<?php

namespace App\Helpers\Cache;

use Carbon\Carbon;
use Codictive\Cms\Models\SystemLog;
use Codictive\Cms\Models\ProductCategory;
use Illuminate\Support\Facades\Cache;

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
                SystemLog::info('[helpers.Cache.CategoriesCache.get] Categories cache not found. Generating now...');

                return self::generate();
            });
        }

        return Cache::remember(CACHE_KEY_CATEGORIES, self::ttl(), function () {
            SystemLog::info('[helpers.Cache.CategoriesCache.get] Categories cache not found. Generating now...');

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
        $categories = ProductCategory::with(['attrs', 'products', 'products.attrs', 'products.dimensions', 'products.filesConfig'])->where('parent_id', $parent)->orderBy('weight')->orderBy('name')->get();
        foreach ($categories as $c) {
            $data = [
                'id'         => $c->id,
                'name'       => $c->name,
                'slug'       => $c->slug,
                'weight'     => $c->weight,
                'children'   => self::generate($c->id),
                'attributes' => [],
                'products'   => [],
            ];

            foreach ($c->allAttributes() as $attrsArray) {
                foreach ($attrsArray as $cAttr) {
                    $data['attributes'][] = [
                        'id'            => $cAttr->id,
                        'name'          => $cAttr->name,
                        'slug'          => $cAttr->slug,
                        'type'          => $cAttr->type,
                        'label'         => $cAttr->label,
                        'prefix'        => $cAttr->prefix,
                        'suffix'        => $cAttr->suffix,
                        'data'          => $cAttr->getData(),
                        'required'      => (bool) $cAttr->pivot->required,
                        'user_editable' => (bool) $cAttr->pivot->user_editable,
                    ];
                }
            }

            foreach ($c->products->where('is_active', true) as $p) {
                $product = [
                    'id'                      => $p->id,
                    'title'                   => $p->title,
                    'pricing_type'            => $p->pricing_type,
                    'summary'                 => $p->summary,
                    'description'             => $p->description,
                    'order_guide_image'       => $p->order_guide_image ? sprintf('%s/static/products/%s', kv('site.base_url'), $p->order_guide_image) : null,
                    'order_guide_description' => $p->order_guide_description,
                    'attributes'              => [],
                    'dimensions'              => [],
                    'files_config'            => [],
                    'delivery_times'          => [],
                    'post_print_services'     => [],
                ];

                if ($p->delivery_times) {
                    foreach (json_decode($p->delivery_times) as $dt) {
                        $now                = now();
                        $deliveryDate       = now();
                        $workdayStartHour   = (int) kv('work_day.start');
                        $workdayEndHour     = (int) kv('work_day.end');
                        if ($deliveryDate->hour > $workdayStartHour) {
                            $deliveryDate->addDay();
                        }
                        $deliveryDate->addHours((int) $dt->hours);
                        if ($deliveryDate->hour > $workdayEndHour) {
                            $deliveryDate->addDay();
                            $deliveryDate->hour($workdayEndHour);
                            $deliveryDate->minute(0);
                        } elseif ($deliveryDate->hour < $workdayStartHour) {
                            $deliveryDate->hour($workdayEndHour);
                            $deliveryDate->minute(0);
                        }
                        $deliveryDate->addDays(countFridays($now, $deliveryDate));
                        if ($deliveryDate->isFriday()) {
                            $deliveryDate->addDay();
                        }

                        $product['delivery_times'][] = [
                            'name'                    => $dt->name,
                            'hours'                   => (int) $dt->hours,
                            'factor'                  => (float) $dt->factor,
                            'delivery_time_unix'      => $deliveryDate->unix(),
                            'delivery_time_georgian'  => $deliveryDate->toString(),
                            'delivery_time_persian'   => g2j($deliveryDate),
                        ];
                    }
                }

                foreach ($p->dimensions as $d) {
                    $product['dimensions'][] = [
                        'id'            => $d->id,
                        'name'          => $d->name,
                        'width'         => $d->width,
                        'height'        => $d->height,
                        'file_width'    => $d->file_width,
                        'file_height'   => $d->file_height,
                        'price'         => $d->price,
                        'partner_price' => $d->partner_price,
                        'pattern_image' => $d->pattern_image ? sprintf('%s/static/product-patterns/%s', kv('site.base_url'), $d->pattern_image) : null,
                    ];
                }

                foreach ($p->filesConfig as $fc) {
                    $product['files_config'][] = [
                        'id'              => $fc->id,
                        'name'            => $fc->name,
                        'resolution'      => $fc->resolution,
                        'color_mode'      => $fc->color_mode,
                        'max_file_size'   => $fc->max_file_size,
                        'allowed_formats' => $fc->allowed_formats,
                        'is_required'     => $fc->is_required,
                    ];
                }

                foreach ($p->attrs as $pa) {
                    if ('checkbox' == $pa->type) {
                        $product['post_print_services'][] = [
                            'id'           => $pa->id,
                            'name'         => $pa->label ?: $pa->name,
                            'pricing_type' => $pa->pivot->pricing_type,
                            'price'        => (int) $pa->pivot->price,
                        ];
                    }

                    $product['attributes'][] = [
                        'id'    => $pa->id,
                        'name'  => $pa->label ?: $pa->name,
                        'type'  => $pa->type,
                        'data'  => $pa->getData(),
                        'value' => $pa->pivot->value,
                    ];
                }

                $data['products'][] = $product;
            }

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
