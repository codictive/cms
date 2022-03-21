# Codictive CMS

A Laravel Based Content Management System

## Installation

- Run `composer require codictive/cms`
- Add `Codictive\Cms\ServiceProvider::class` to the `providers` section of `config/app.php`
- Publish files via:
  - `php artisan vendor:publish --tag=cms.public`
  - `php artisan vendor:publish --tag=cms.migrations`
  - `php artisan vendor:publish --tag=cms.seeders`
  - `php artisan vendor:publish --tag=cms.config`
  - `php artisan vendor:publish --tag=cms.lang`
- Remove this things from default Laravel installation:
  - default routes.
  - `User.php` from `app/Models`
  - `2014_10_12_000000_create_users_table.php` from `database/migrations`
  - `welcome.blade.php` from `resources/views`
