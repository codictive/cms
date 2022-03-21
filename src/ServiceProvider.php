<?php

namespace Codictive\Cms;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/app.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'cms');

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'cms');
        $this->mergeConfigFrom(__DIR__ . '/../config/permissions.php', 'permissions');

        // Publish.
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'cms.migrations');
        $this->publishes([
            __DIR__ . '/../database/seeders/' => database_path('seeders'),
        ], 'cms.seeders');

        $this->publishes([
            __DIR__ . '/../config/config.php'      => config_path('cms.php'),
            __DIR__ . '/../config/permissions.php' => config_path('permissions.php'),
        ], 'cms.config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/cms'),
        ], 'cms.public');

        $this->publishes([
            __DIR__ . '/../lang/fa' => lang_path('fa'),
        ], 'cms.lang');

        $this->publishes([
            __DIR__ . '/../database/migrations/'   => database_path('migrations'),
            __DIR__ . '/../database/seeders/'      => database_path('seeders'),
            __DIR__ . '/../config/config.php'      => config_path('cms.php'),
            __DIR__ . '/../config/permissions.php' => config_path('permissions.php'),
            __DIR__ . '/../public'                 => public_path('vendor/cms'),
            __DIR__ . '/../lang/fa'                => lang_path('fa'),
        ], 'cms.all');
    }
}
