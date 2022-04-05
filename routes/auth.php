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
    Route::get('/verify', 'AuthController@showVerificationForm')->name('auth.show_verification_form');
    Route::post('/verify', 'AuthController@verify')->name('auth.verify');
    Route::get('/login-via-password', 'AuthController@showPasswordLoginForm')->name('auth.show_password_login_form');
    Route::post('/login-via-password', 'AuthController@passwordLogin')->name('auth.login_password');
    Route::get('/logout', 'AuthController@logout')->name('auth.logout');
    Route::get('/password-reset/request', 'AuthController@showPasswordResetRequestForm')->name('auth.show_password_reset_request_form');
    Route::post('/password-reset/request', 'AuthController@passwordResetRequest')->name('auth.password_reset_request');
    Route::get('/password-reset/verify', 'AuthController@showPasswordResetVerificationForm')->name('auth.show_password_reset_verification_form');
    Route::post('/password-reset/verify', 'AuthController@passwordResetVerify')->name('auth.password_reset_verify');
});
