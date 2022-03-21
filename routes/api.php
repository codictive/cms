<?php

use Illuminate\Support\Facades\Route;

$cfg = [
    'namespace'  => 'Codictive\\Cms\\Controllers\\Api',
    'prefix'     => '/api',
    'middleware' => 'api',
];

Route::group($cfg, function () {
});
