<?php

use Illuminate\Support\Facades\Route;

$cfg = [
    'namespace'  => 'Codictive\\Cms\\Controllers\\Admin',
    'prefix'     => '/admin',
    'middleware' => 'web',
];

Route::group($cfg, function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
});
