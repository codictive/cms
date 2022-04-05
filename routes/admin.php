<?php

use Illuminate\Support\Facades\Route;

$cfg = [
    'namespace'  => 'Codictive\\Cms\\Controllers\\Admin',
    'prefix'     => '/admin',
    'middleware' => 'web',
];

Route::group($cfg, function () {
    Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard');

    // Config.
    Route::get('/config', 'ConfigController@index')->name('admin.config.index');
    Route::post('/config', 'ConfigController@store')->name('admin.config.store');

    // Menu.
    Route::get('/menus', 'MenuController@index')->name('admin.menus.index');
    Route::get('/menus/create', 'MenuController@create')->name('admin.menus.create');
    Route::post('/menus', 'MenuController@store')->name('admin.menus.store');
    Route::get('/menus/{menu}', 'MenuController@show')->name('admin.menus.show');
    Route::get('/menus/{menu}/edit', 'MenuController@edit')->name('admin.menus.edit');
    Route::post('/menus/{menu}', 'MenuController@update')->name('admin.menus.update');
    Route::get('/menus/{menu}/delete', 'MenuController@destroy')->name('admin.menus.delete');

    // MenuItem.
    Route::get('/menus/{menu}/items/create', 'MenuItemController@create')->name('admin.menu_items.create');
    Route::post('/menus/{menu}/items', 'MenuItemController@store')->name('admin.menu_items.store');
    Route::get('/menus/{menu}/items/{item}/edit', 'MenuItemController@edit')->name('admin.menu_items.edit');
    Route::post('/menus/{menu}/items/{item}', 'MenuItemController@update')->name('admin.menu_items.update');
    Route::get('/menus/{menu}/items/{item}/delete', 'MenuItemController@destroy')->name('admin.menu_items.delete');

    // Category.
    Route::get('/article-categories/create/{parent?}', 'ArticleCategoryController@create')->name('admin.article_categories.create');
    Route::post('/article-categories/{parent?}', 'ArticleCategoryController@store')->name('admin.article_categories.store');
    Route::get('/article-categories/{category}/edit', 'ArticleCategoryController@edit')->name('admin.article_categories.edit');
    Route::post('/article-categories/{category}/update', 'ArticleCategoryController@update')->name('admin.article_categories.update');
    Route::get('/article-categories/{category}/delete', 'ArticleCategoryController@destroy')->name('admin.article_categories.delete');
    Route::get('/article-categories/{category?}', 'ArticleCategoryController@index')->name('admin.article_categories.index');

    // Page.
    Route::get('/pages', 'PageController@index')->name('admin.pages.index');
    Route::get('/pages/create', 'PageController@create')->name('admin.pages.create');
    Route::post('/pages', 'PageController@store')->name('admin.pages.store');
    Route::get('/pages/{page}/edit', 'PageController@edit')->name('admin.pages.edit');
    Route::post('/pages/{page}', 'PageController@update')->name('admin.pages.update');
    Route::get('/pages/{page}/delete', 'PageController@destroy')->name('admin.pages.delete');

    // Article.
    Route::post('/articles/batch', 'ArticleController@batch')->name('admin.articles.batch');
    Route::get('/articles', 'ArticleController@index')->name('admin.articles.index');
    Route::get('/articles/create', 'ArticleController@create')->name('admin.articles.create');
    Route::post('/articles', 'ArticleController@store')->name('admin.articles.store');
    Route::get('/articles/{article}/edit', 'ArticleController@edit')->name('admin.articles.edit');
    Route::post('/articles/{article}', 'ArticleController@update')->name('admin.articles.update');
    Route::get('/articles/{article}/delete', 'ArticleController@destroy')->name('admin.articles.delete');

    // Slider.
    Route::get('/sliders', 'SliderController@index')->name('admin.sliders.index');
    Route::get('/sliders/create', 'SliderController@create')->name('admin.sliders.create');
    Route::post('/sliders', 'SliderController@store')->name('admin.sliders.store');
    Route::get('/sliders/{slider}', 'SliderController@show')->name('admin.sliders.show');
    Route::get('/sliders/{slider}/edit', 'SliderController@edit')->name('admin.sliders.edit');
    Route::post('/sliders/{slider}', 'SliderController@update')->name('admin.sliders.update');
    Route::get('/sliders/{slider}/delete', 'SliderController@destroy')->name('admin.sliders.delete');

    // Slider Item.
    Route::get('/sliders/{slider}/items/create', 'SliderItemController@create')->name('admin.sliders.items.create');
    Route::post('/sliders/{slider}/items', 'SliderItemController@store')->name('admin.sliders.items.store');
    Route::get('/sliders/{slider}/items/{item}/edit', 'SliderItemController@edit')->name('admin.sliders.items.edit');
    Route::post('/sliders/{slider}/items/{item}', 'SliderItemController@update')->name('admin.sliders.items.update');
    Route::get('/sliders/{slider}/items/{item}/delete', 'SliderItemController@destroy')->name('admin.sliders.items.delete');

    // SystemLog.
    Route::get('/system-logs', 'SystemLogController@index')->name('admin.system_logs.index');
    Route::get('/system-logs/truncate', 'SystemLogController@truncate')->name('admin.system_logs.truncate');

    // User.
    Route::post('/users/batch', 'UserController@batch')->name('admin.users.batch');
    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::post('/users', 'UserController@store')->name('admin.users.store');
    Route::get('/users/create', 'UserController@create')->name('admin.users.create');
    Route::get('/users/{user}', 'UserController@show')->name('admin.users.show');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('admin.users.edit');
    Route::post('/users/{user}', 'UserController@update')->name('admin.users.update');
    Route::get('/users/{user}/delete', 'UserController@destroy')->name('admin.users.delete');
    Route::get('/users/{user}/notifications', 'UserController@notifications')->name('admin.users.notifications');
    Route::get('/users/{user}/comments', 'UserController@comments')->name('admin.users.comments');

    // Role.
    Route::get('/roles', 'RoleController@index')->name('admin.roles.index');
    Route::post('/roles', 'RoleController@store')->name('admin.roles.store');
    Route::get('/roles/create', 'RoleController@create')->name('admin.roles.create');
    Route::get('/roles/{role}/permissions', 'RoleController@showPermissions')->name('admin.roles.permissions.show');
    Route::post('/roles/{role}/permissions', 'RoleController@storePermissions')->name('admin.roles.permissions.store');
    Route::get('/roles/{role}/edit', 'RoleController@edit')->name('admin.roles.edit');
    Route::post('/roles/{role}', 'RoleController@update')->name('admin.roles.update');
    Route::get('/roles/{role}/delete', 'RoleController@destroy')->name('admin.roles.delete');

    // Permission.
    Route::get('/permissions', 'PermissionController@index')->name('admin.permissions.index');
    Route::post('/permissions', 'PermissionController@store')->name('admin.permissions.store');

    // Feedback.
    Route::get('/feedback', 'FeedbackController@index')->name('admin.feedback.index');
    Route::get('/feedback/{feedback}', 'FeedbackController@show')->name('admin.feedback.show');

    // ActivityLog.
    Route::get('/activity-logs', 'ActivityLogController@index')->name('admin.activity_logs.index');
    Route::get('/activity-logs/{log}', 'ActivityLogController@show')->name('admin.activity_logs.show');

    // Comment.
    Route::get('/comments', 'CommentController@index')->name('admin.comments.index');
    Route::get('/comments/{comment}/edit', 'CommentController@edit')->name('admin.comments.edit');
    Route::post('/comments/{comment}', 'CommentController@update')->name('admin.comments.update');
    Route::get('/comments/{comment}/delete', 'CommentController@destroy')->name('admin.comments.delete');

    // Tag.
    Route::post('/tags/batch', 'TagController@batch')->name('admin.tags.batch');
    Route::get('/tags', 'TagController@index')->name('admin.tags.index');
    Route::get('/tags/create', 'TagController@create')->name('admin.tags.create');
    Route::post('/tags', 'TagController@store')->name('admin.tags.store');
    Route::get('/tags/{tag}/edit', 'TagController@edit')->name('admin.tags.edit');
    Route::post('/tags/{tag}', 'TagController@update')->name('admin.tags.update');
    Route::get('/tags/{tag}/delete', 'TagController@destroy')->name('admin.tags.delete');

    // Media Library.
    Route::get('/files', 'FileController@index')->name('admin.files.index');
    Route::get('/files/create', 'FileController@create')->name('admin.files.create');
    Route::post('/files', 'FileController@store')->name('admin.files.store');
    Route::get('/files/{media}/edit', 'FileController@edit')->name('admin.files.edit');
    Route::post('/files/{media}', 'FileController@update')->name('admin.files.update');
    Route::get('/files/{media}/delete', 'FileController@delete')->name('admin.files.delete');

    // AdBanner.
    Route::get('/ad-banners', 'AdBannerController@index')->name('admin.ad_banners.index');
    Route::get('/ad-banners/create', 'AdBannerController@create')->name('admin.ad_banners.create');
    Route::post('/ad-banners', 'AdBannerController@store')->name('admin.ad_banners.store');
    Route::get('/ad-banners/{banner}/edit', 'AdBannerController@edit')->name('admin.ad_banners.edit');
    Route::post('/ad-banners/{banner}', 'AdBannerController@update')->name('admin.ad_banners.update');
    Route::get('/ad-banners/{banner}/delete', 'AdBannerController@destroy')->name('admin.ad_banners.delete');

    // Performance.
    Route::get('/performance', 'PerformanceController@index')->name('admin.performance.index');
    Route::post('/performance/cache/locations/reload', 'PerformanceController@reloadLocationsCache')->name('admin.performance.cache.locations.reload');
    Route::post('/performance/cache/locations/delete', 'PerformanceController@deleteLocationsCache')->name('admin.performance.cache.locations.delete');
    Route::post('/performance/cache/categories/reload', 'PerformanceController@reloadCategoriesCache')->name('admin.performance.cache.categories.reload');
    Route::post('/performance/cache/categories/delete', 'PerformanceController@deleteCategoriesCache')->name('admin.performance.cache.categories.delete');
    Route::post('/performance/orphan-files/delete', 'PerformanceController@deleteOrphanFiles')->name('admin.performance.orphan_files.delete');

    // Province.
    Route::get('/provinces', 'ProvinceController@index')->name('admin.provinces.index');
    Route::get('/provinces/create', 'ProvinceController@create')->name('admin.provinces.create');
    Route::post('/provinces', 'ProvinceController@store')->name('admin.provinces.store');
    Route::get('/provinces/{province}', 'ProvinceController@show')->name('admin.provinces.show');
    Route::get('/provinces/{province}/edit', 'ProvinceController@edit')->name('admin.provinces.edit');
    Route::post('/provinces/{province}', 'ProvinceController@update')->name('admin.provinces.update');
    Route::get('/provinces/{province}/delete', 'ProvinceController@destroy')->name('admin.provinces.delete');
    // City.
    Route::get('/provinces/{province}/cities/create', 'CityController@create')->name('admin.cities.create');
    Route::post('/provinces/{province}/cities', 'CityController@store')->name('admin.cities.store');
    Route::get('/provinces/{province}/cities/{city}', 'CityController@show')->name('admin.cities.show');
    Route::get('/provinces/{province}/cities/{city}/edit', 'CityController@edit')->name('admin.cities.edit');
    Route::post('/provinces/{province}/cities/{city}', 'CityController@update')->name('admin.cities.update');
    Route::get('/provinces/{province}/cities/{city}/delete', 'CityController@destroy')->name('admin.cities.delete');

    // Ticket.
    Route::post('/tickets/batch', 'TicketController@batch')->name('admin.tickets.batch');
    Route::get('/tickets', 'TicketController@index')->name('admin.tickets.index');
    Route::get('/tickets/create', 'TicketController@create')->name('admin.tickets.create');
    Route::post('/tickets', 'TicketController@store')->name('admin.tickets.store');
    Route::get('/tickets/{ticket}/edit', 'TicketController@edit')->name('admin.tickets.edit');
    Route::post('/tickets/{ticket}', 'TicketController@update')->name('admin.tickets.update');
    Route::get('/tickets/{ticket}/delete', 'TicketController@destroy')->name('admin.tickets.delete');
    // Conversation.
    Route::get('/tickets/{ticket}/conversations', 'ConversationController@index')->name('admin.tickets.conversations.index');
    Route::post('/tickets/{ticket}/conversations', 'ConversationController@store')->name('admin.tickets.conversations.store');
    Route::get('/tickets/{ticket}/conversations/{conversation}/edit', 'ConversationController@edit')->name('admin.tickets.conversations.edit');
    Route::post('/tickets/{ticket}/conversations/{conversation}', 'ConversationController@update')->name('admin.tickets.conversations.update');
    Route::get('/tickets/{ticket}/conversations/{conversation}/delete', 'ConversationController@destroy')->name('admin.tickets.conversations.delete');
});
