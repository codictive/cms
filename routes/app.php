<?php

use Illuminate\Support\Facades\Route;

$cfg = [
    'namespace'  => 'Codictive\\Cms\\Controllers\\App',
    'middleware' => 'web',
];

Route::group($cfg, function () {
    Route::get('/', 'DashboardController@index')->name('app.index');
});
