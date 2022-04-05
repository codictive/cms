<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\File;
use Codictive\Cms\Models\Order;
use Codictive\Cms\Controllers\Controller;
use Codictive\Cms\Helpers\Cache\CategoryCache;
use Codictive\Cms\Helpers\Cache\LocationCache;

class PerformanceController extends Controller
{
    public function index()
    {
        $orphans      = File::where('related_type', Order::class)->where('related_id', 0)->get();

        return view('cms::admin.performace', ['orphanFiles' => $orphans]);
    }

    public function deleteLocationsCache()
    {
        LocationCache::delete();

        return redirect()->route('admin.performance.index')->with('warning', 'کش استان‌ها و شهرها حذف شد.');
    }

    public function reloadLocationsCache()
    {
        LocationCache::reload();

        return redirect()->route('admin.performance.index')->with('info', 'کش استان‌ها و شهرها بازسازی شد.');
    }

    public function deleteCategoriesCache()
    {
        CategoryCache::delete();

        return redirect()->route('admin.performance.index')->with('warning', 'کش دسته‌بندی به همراه محصولات حذف شد.');
    }

    public function reloadCategoriesCache()
    {
        CategoryCache::reload();

        return redirect()->route('admin.performance.index')->with('info', 'کش دسته‌بندی به همراه محصولات بازسازی شد.');
    }

    public function deleteOrphanFiles()
    {
        $orphans = File::where('attachable_type', Order::class)->where('attachable_id', 0)->get();
        foreach ($orphans as $o) {
            $o->removeFile();
            $o->delete();
        }

        return redirect()->route('admin.performance.index')->with('info', 'فایل‌های بدون سفارش حذف شد');
    }
}
