# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

Laravel 7 (PHP ^7.2.5) e-commerce app for "ElectronicsBagBD.com" (`APP_NAME` in `.env`). MySQL database, Laravel Mix (webpack) for front-end assets, session-based auth plus GitHub/Google OAuth via Laravel Socialite.

## Commands

No local PHP/Composer toolchain is guaranteed to be installed — check before assuming `php`/`composer` are on PATH.

```
composer install                 # install PHP dependencies
npm install                      # install JS dependencies
php artisan key:generate         # generate APP_KEY (already set in committed .env)
php artisan migrate              # run migrations against the configured DB
php artisan migrate:fresh --seed # rebuild DB from scratch and seed

php artisan serve                # run dev server (default http://127.0.0.1:8000)

npm run dev                      # build assets for development
npm run watch                    # rebuild on file change
npm run prod                     # production asset build

php vendor/bin/phpunit                       # run full test suite
php vendor/bin/phpunit --filter=TestName     # run a single test
php vendor/bin/phpunit tests/Feature/Foo.php # run a single test file
```

Tests use `tests/Unit` and `tests/Feature` suites (see `phpunit.xml`). The DB connection for tests is whatever `.env`/`phpunit.xml` resolves to — sqlite in-memory is available but commented out in `phpunit.xml`, so tests currently hit the real configured MySQL DB unless that's changed.

## Database

- Connection: MySQL, configured entirely via `.env` (`DB_DATABASE=projectgreenelectronics`, `DB_USERNAME=root`, empty password, `127.0.0.1:3306`).
- Migrations live in `database/migrations`; there is no separate seeder wiring beyond the default `database/seeds/DatabaseSeeder.php` and `UserFactory`.
- Key tables beyond Laravel defaults: `products`, `orders`, `orders_items`, `wishlist`, plus an `admin` boolean added to `users` via `2020_09_29_170458_add_admin_field.php`.

## Architecture

- **Routing** (`routes/web.php`): mostly closure/controller-array routes (Laravel 5-style `['uses' => ..., 'as' => ...]` arrays rather than the newer array-callable syntax), not resourceful/grouped. Notable route groups:
  - Public storefront: `/`, `shop`, `product`, `productview/{id}`, `search`, `cart`, `billing` → `ProductsController` (note: routes reference the lowercase-first-letter `productsController` for some entries — case-insensitive on the underlying filesystem but be aware of the mismatch with the actual class `App\Http\Controllers\ProductsController`).
  - Wishlist/cart mutation routes are `GET` requests (not POST), guarded by `auth` middleware for wishlist actions only.
  - Admin area under `admin/*` guarded by a custom `restictToAdmin` middleware alias (registered in `app/Http/Kernel.php`, implemented in `app/Http/Middleware/RestrictAccess.php`), which checks `Auth::user()->isAdmin()` and redirects to `/login` otherwise. Admin routes are not grouped with a shared prefix/middleware group — the alias is repeated per-route.
  - OAuth: `login/{platform}` and `login/{platform}/callback` are generic Socialite routes handled by `App\Http\Controllers\social` (lowercase class name) rather than `LoginController`, even though `LoginController` is imported in `web.php`.

- **Models** (`app/*.php`, not under `app/Models`): `User`, `Product`, `Order`, `Orders_Items`, `Cart`. Simple Eloquent models with `$fillable` arrays; no relationships beyond what's implicit in migrations — check migration files for actual FK structure before assuming relationships exist.

- **Controllers**: `app/Http/Controllers/ProductsController.php` is the main storefront controller (products, cart, wishlist, billing all live here rather than being split by resource). `app/Http/Controllers/Admin/AdminProductController.php` handles all admin CRUD for products and viewing orders/invoices. Auth scaffolding under `app/Http/Controllers/Auth/` is the stock Laravel UI (`laravel/ui`) output.

- **OAuth config**: GitHub/Google client IDs and secrets are committed directly in `.env` (not just `.env.example`) — treat `.env` in this repo as containing real-looking secrets when handling it.

- **Front-end**: `resources/js/app.js` + `resources/sass/app.scss` built via Laravel Mix (`webpack.mix.js`) into `public/js` and `public/css`. Views are plain Blade under `resources/views` (note both `resources/views/lay`, `resources/views/layout`, and `resources/views/layouts` exist — check which is actually referenced before adding new views, as there may be dead/duplicate layout directories).
