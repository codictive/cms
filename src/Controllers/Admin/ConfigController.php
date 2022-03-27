<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Menu;
use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\Slider;
use Codictive\Cms\Models\AdBanner;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Models\ArticleCategory;
use Codictive\Cms\Controllers\Controller;

class ConfigController extends Controller
{
    use RequiresUser;

    public function index()
    {
        $sliders           = Slider::all();
        $roles             = Role::all();
        $adBanners         = AdBanner::orderBy('name')->get();
        $menus             = Menu::all();
        $articleCategories = ArticleCategory::all();

        return view('admin.config', [
            'sliders'           => $sliders,
            'roles'             => $roles,
            'adBanners'         => $adBanners,
            'menus'             => $menus,
            'articleCategories' => $articleCategories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data as $k => $v) {
            if ('_token' == $k) {
                continue;
            }
            if ('site-logo' == $k) {
                $fn = moveFile($request->file('site-logo'), STATIC_DIR . '/img');
                kv('site.logo', $fn);

                continue;
            }

            kv(str_replace('-', '.', $k), $v);
        }

        return redirect()->route('admin.config.index')->with('success', 'تنظیمات سیستم ذخیره شد');
    }
}
