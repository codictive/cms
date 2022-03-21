# Codictive CMS

A Laravel Based Content Management System

## Installation

1. Run `composer require codictive/cms`

2. Add `Codictive\Cms\ServiceProvider::class` to the `providers` section of `config/app.php`

3. Publish files via:

- `php artisan vendor:publish --tag=cms.common --force`

Or (add `--force` to override existing files):

- `php artisan vendor:publish --tag=cms.all`
- `php artisan vendor:publish --tag=cms.lang`
- `php artisan vendor:publish --tag=cms.public`
- `php artisan vendor:publish --tag=cms.config`
- `php artisan vendor:publish --tag=cms.seeders`
- `php artisan vendor:publish --tag=cms.migrations`
