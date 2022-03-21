<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/auth', 'namespace' => 'Codictive\\Cms\\Controllers\\Auth'], function () {
    Route::get('/login', 'AuthController@showLoginForm')->name('auth.show_login_form');
    Route::post('/login', 'AuthController@login')->name('auth.login');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');
});
