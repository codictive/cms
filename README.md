# Codictive CMS

A Laravel Based Content Management System

## Installation

- Run `composer require codictive/cms`
- Add `Codictive\Cms\ServiceProvider::class` to the `providers` section of `config/app.php`
- Publish files via (add `--force` to override existing files):
  - `php artisan vendor:publish --tag=cms.all`
  - Or
  - `php artisan vendor:publish --tag=cms.lang`
  - `php artisan vendor:publish --tag=cms.public`
  - `php artisan vendor:publish --tag=cms.config`
  - `php artisan vendor:publish --tag=cms.seeders`
  - `php artisan vendor:publish --tag=cms.migrations`
