<?php

use Illuminate\Support\Facades\Route;

$cfg = [
    'namespace'  => 'Codictive\\Cms\\Controllers\\Auth',
    'prefix'     => '/auth',
    'middleware' => 'web',
];

Route::group($cfg, function () {
    Route::get('/login', 'AuthController@showLoginForm')->name('auth.show_login_form');
    Route::post('/login', 'AuthController@login')->name('auth.login');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');
});
