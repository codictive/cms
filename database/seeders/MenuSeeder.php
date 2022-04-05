<?php

namespace Database\Seeders;

use Codictive\Cms\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // App Navigation Menu.
        $app = Menu::create(['name' => 'پیمایش سایت', 'slug' => 'app_navigation']);
        $app->items()->create(['title' => 'صفحه اصلی', 'path' => '/']);
        $app->items()->create(['title' => 'مقالات', 'path' => '/blog']);
        $app->items()->create(['title' => 'درباره ما', 'path' => '/pages/about']);
        $app->items()->create(['title' => 'سوالات متداول', 'path' => '/faq']);
        $app->items()->create(['title' => 'ارتباط با ما', 'path' => '/contact']);

        // Admin Navigation Menu.
        $admin = Menu::create(['name' => 'پیمایش پنل مدیریت', 'slug' => 'admin_navigation']);

        $content = $admin->items()->create(['title' => 'محتوا', 'path' => '#']);
        $admin->items()->create(['title' => 'مقالات', 'path' => '/admin/articles', 'parent_id' => $content->id, 'prefix' => '/admin/articles']);
        $admin->items()->create(['title' => 'تیکت‌ها', 'path' => '/admin/tickets', 'parent_id' => $content->id, 'prefix' => '/admin/tickets']);
        $admin->items()->create(['title' => 'دیدگاه‌ها', 'path' => '/admin/comments', 'parent_id' => $content->id, 'prefix' => '/admin/comments']);
        $admin->items()->create(['title' => 'صفحات استاتیک', 'path' => '/admin/pages', 'parent_id' => $content->id, 'prefix' => '/admin/pages']);
        $admin->items()->create(['title' => 'کتابخانه فایل‌ها', 'path' => '/admin/files', 'parent_id' => $content->id, 'prefix' => '/admin/files']);

        $structure = $admin->items()->create(['title' => 'ساختار', 'path' => '#', 'prefix' => '/admin/']);
        $admin->items()->create(['title' => 'دسته‌بندی مقالات', 'path' => '/admin/article-categories', 'parent_id' => $structure->id, 'prefix' => '/admin/categories']);
        $admin->items()->create(['title' => 'بنرهای تبلیغاتی', 'path' => '/admin/ad-banners', 'parent_id' => $structure->id, 'prefix' => '/admin/banners']);
        $admin->items()->create(['title' => 'منوها', 'path' => '/admin/menus', 'parent_id' => $structure->id, 'prefix' => '/admin/menus']);
        $admin->items()->create(['title' => 'اسلایدرها', 'path' => '/admin/sliders', 'parent_id' => $structure->id, 'prefix' => '/admin/sliders']);
        $admin->items()->create(['title' => 'برچسب‌ها', 'path' => '/admin/tags', 'parent_id' => $structure->id, 'prefix' => '/admin/tags']);

        $users = $admin->items()->create(['title' => 'کاربران', 'path' => '#']);
        $admin->items()->create(['title' => 'مدیریت کاربران', 'path' => '/admin/users', 'weight' => 0, 'parent_id' => $users->id, 'prefix' => '/admin/users']);
        $admin->items()->create(['title' => 'مدیریت نقش‌ها', 'path' => '/admin/roles', 'weight' => 0, 'parent_id' => $users->id, 'prefix' => '/admin/roles']);
        $admin->items()->create(['title' => 'مدیریت مجوزها', 'path' => '/admin/permissions', 'weight' => 0, 'parent_id' => $users->id, 'prefix' => '/admin/permissions']);
        $admin->items()->create(['title' => 'مشاهده بازخوردها', 'path' => '/admin/feedback', 'weight' => 0, 'parent_id' => $users->id, 'prefix' => '/admin/feedback']);

        $system = $admin->items()->create(['title' => 'سیستم', 'path' => '#']);
        $admin->items()->create(['title' => 'تظیمات', 'path' => '/admin/config', 'weight' => 0, 'parent_id' => $system->id, 'prefix' => '/admin/config']);
        $admin->items()->create(['title' => 'لاگ سیستم', 'path' => '/admin/system-logs', 'weight' => 0, 'parent_id' => $system->id, 'prefix' => '/admin/logs']);
        $admin->items()->create(['title' => 'لاگ فعالیت کاربران', 'path' => '/admin/activity-logs', 'weight' => 0, 'parent_id' => $system->id, 'prefix' => '/admin/logs']);
        $admin->items()->create(['title' => 'کارایی', 'path' => '/admin/performance', 'weight' => 0, 'parent_id' => $system->id, 'prefix' => '/admin/performance']);
    }
}
