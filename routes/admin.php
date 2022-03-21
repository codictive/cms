<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/admin', 'namespace' => 'Codictive\\Cms\\Controllers\\Admin'], function () {
    Route::get('/', 'DashbordController@index')->name('admin.dashboard');
});
