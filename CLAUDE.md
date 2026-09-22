# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

Laravel 12 (PHP ^8.2, running PHP 8.3 in Docker) e-commerce app for "Green Electronics" (`APP_NAME` in `.env`), an electronics-component store. Upgraded from the original Laravel 7 / PHP 7.2 baseline — see "Upgrade history" below. MySQL database, Laravel Mix (webpack) for front-end assets, session-based auth plus GitHub/Google OAuth via Laravel Socialite.

## Running the project

No local PHP/Composer/MySQL toolchain is guaranteed to be installed — this project runs via Docker Compose (`Dockerfile` + `docker-compose.yml`: a PHP 8.3-cli `app` service + MySQL 5.7 `db` service).

```
docker compose up -d --build   # build and start app + db
docker compose logs -f app     # tail app logs (composer install, migrate, serve)
docker compose down            # stop (add -v to also wipe the DB volume)
docker exec <container> <cmd>  # run one-off commands, e.g. artisan/composer/phpunit, inside the app container
```

`.env`'s `DB_HOST` must be `db` (the compose service name), not `127.0.0.1` — passing `DB_HOST` as a docker-compose `environment:` override does **not** reliably win over the `.env` file's value under this app's `vlucas/phpdotenv` v5 (see "Upgrade history"), so it must be set directly in `.env`.

## Commands (inside the app container, or locally if you have PHP 8.2+/Composer)

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
# On Node 17+ (webpack 4 / Laravel Mix 5 predate OpenSSL 3), prefix build commands with:
#   NODE_OPTIONS=--openssl-legacy-provider npm run prod

php vendor/bin/phpunit                       # run full test suite
php vendor/bin/phpunit --filter=TestName     # run a single test
php vendor/bin/phpunit tests/Feature/Foo.php # run a single test file
```

### Local dev performance

The Docker bind mount (`.:/var/www/html`) is slow on Windows/Mac — every file the PHP process touches pays a cross-VM filesystem penalty. The dominant fix (~3s → ~0.25s per request) is in the `Dockerfile`: `php artisan serve` runs its actual request-handling server (`php -S ...`, launched as a child process — see `Illuminate\Foundation\Console\ServeCommand::serverCommand()`) under the plain **CLI SAPI**, where OPcache is disabled by default (`opcache.enable_cli=0`) even though `opcache.enable` for web SAPIs is on. With it off, *every single request recompiles the entire framework from source* on the slow bind-mounted filesystem — confirmed by direct measurement (stat-ing 3,000 vendor files took ~4s; a raw MySQL query took <5ms). The Dockerfile now ships `/usr/local/etc/php/conf.d/opcache-cli.ini` setting `opcache.enable_cli=1`, which requires an image rebuild (`docker compose up -d --build app`) to take effect, not just a container restart.

Two smaller contributors, both baked into `composer.json`'s `config` (`optimize-autoloader` + `classmap-authoritative`) so they survive `composer install` re-runs on every container start, rather than being a one-off `composer dump-autoload` flag that gets silently wiped the next time the container restarts:
```
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Caveats**:
- With `config:cache`/`route:cache` active, changes to `.env`, `config/*.php`, or `routes/*.php` won't take effect until you `php artisan config:clear` / `route:clear` (or re-run the cache commands). Clear them before actively editing routes/config, re-cache when done. `view:cache` is safe to leave on always — Blade still recompiles a view if its source file changes.
- `classmap-authoritative` means the autoloader **refuses to fall back to PSR-4 directory scanning** for any class it didn't already know about — adding a new `app/*.php` class (a new model, a new controller) won't be found until something runs `composer install`/`dump-autoload` again (it self-heals on the next container start because of the Dockerfile command, but a bare `docker compose restart` inside the same running container won't re-run it — you'd need to `composer dump-autoload` manually or recreate the container).
- Because `View::composer('*', ...)` in `AppServiceProvider` fires once per **view instance rendered** (every partial, every `<x-icon>` component, not just once per request), anything expensive placed in it — like the categories query — gets multiplied by however many sub-views a page renders (the homepage renders 50+ product cards). It's memoized in a closure-captured variable there now; don't replace that with `Cache::remember()` assuming it's free — the `file` cache driver reads through the same slow bind mount and made this *worse*, not better, when tried.

To create a local admin account (no seeder ships one, since the password would end up committed):
```
php artisan tinker --execute="
\$u = new App\User(); \$u->name='Admin'; \$u->email='admin@example.com';
\$u->password = bcrypt('choose-a-password'); \$u->admin = 1; \$u->save();
"
```

Tests use `tests/Unit` and `tests/Feature` suites (see `phpunit.xml`, PHPUnit 11 schema). The DB connection for tests is whatever `.env`/`phpunit.xml` resolves to — sqlite in-memory is available but commented out in `phpunit.xml`, so tests currently hit the real configured MySQL DB unless that's changed.

## Database

- Connection: MySQL, configured entirely via `.env` (`DB_DATABASE=projectgreenelectronics`, `DB_USERNAME=root`, empty password, host `db` under Docker Compose / port `3306`).
- Migrations live in `database/migrations`; seeders live in `database/seeders` (renamed from `database/seeds` during the Laravel 8+ upgrade) — `DatabaseSeeder` calls `ProductSeeder`, plus a class-based `UserFactory`.
- Key tables: `categories` (`name`, `slug`, `icon`, `blurb`) ← `products` (`category_id` FK, `name`, `slug`, `sku`, `subcategory`, `brand`, `description`, `short_description`, `specifications`, `video_url`, `stock`, `sold`, `price`) ← `product_images` (`product_id` FK cascade-delete, `path`, `sort_order`) — normalized during the schema redesign below. Also `orders`, `orders_items`, `wishlist`, and an `admin` boolean on `users` (`2020_09_29_170458_add_admin_field.php`).

### Schema redesign (products/categories/images)

The original schema (still visible in git history) stored category as three unlabeled `type1`/`type2`/`type3` string columns on `products` with no FK, a mixed-case `Name` column that silently defeated `Product::$fillable` mass assignment, and exactly four fixed image columns (`image`, `image1`, `image2`, `image3`) instead of a real one-to-many relationship. This surfaced directly in the admin product form (`type1`/`type2`/`type3` labeled "Small Category"/"Big category"/"Brand" with no indication which was which) and in a real bug: `AdminProductController@sendCreateProductForm` read `$request->input('type1')` into all three columns, so every new product's category was silently wrong regardless of what the form submitted.

Redesigned to: `categories` table (replaces the free-text `type2` + `config/categories.php`), `products.category_id` FK + `subcategory`/`brand` string columns (replacing `type1`/`type2`/`type3`), and a `product_images` table (replaces the 4 fixed columns) via `Product::images()` ordered by `sort_order`, with `Product::primary_image` as an accessor for `images->first()->path`. The admin panel's 4 separate "edit image slot" pages were replaced by one `admin/product/{id}/images` page supporting upload-many/delete-one. Category browsing now filters by `category_id`/slug (`route('searchproduct', ['category' => $slug])`) instead of a `LIKE` match against `type2`; free-text search (`searchText` param) still does a `LIKE` match, now against `name`/`subcategory`/`brand`.

Also fixed while doing this: `ProductsController@showWishList` used to build the wishlist product list with `DB::table('products')->where('id', $data)` where `$data` was an array — the query builder can't bind an array as a scalar value, so this only ever worked by accident; it's now `Product::whereIn('id', $productIds)`.

## Upgrade history

Upgraded from Laravel 7 / PHP ^7.2.5 straight to Laravel 12 / PHP ^8.2 (skipped Laravel 10 as a target after discovering it's past end-of-life with an unpatched CVE — its security-support window ended Feb 2025). Notes for future upgrades or debugging:

- The app kept its Laravel-7-era structure (`app/Http/Kernel.php`, `app/Console/Kernel.php`, `app/Exceptions/Handler.php`, old-style `bootstrap/app.php`) rather than adopting Laravel 11's streamlined skeleton — this is officially supported; only apps scaffolded fresh via `laravel new` get the new minimal `bootstrap/app.php`.
- `routes/web.php` and `routes/api.php` still use Laravel-7-style string/array controller actions (`'uses' => 'ProductsController@index'`) resolved via `RouteServiceProvider`'s explicit `->namespace($this->namespace)->group(...)` calls — this is the documented Laravel 8 upgrade-guide backward-compat path and still works on Laravel 12; routes were **not** rewritten to `[Controller::class, 'method']` syntax.
- `fideloper/proxy` and `fruitcake/laravel-cors` were dropped (both merged into the framework core as of Laravel 8/9) — `TrustProxies` now extends `Illuminate\Http\Middleware\TrustProxies`, and `Kernel.php` uses `Illuminate\Http\Middleware\HandleCors`. `doctrine/dbal` was dropped too (no migrations use `->change()`, so it was never needed).
- `Illuminate\Http\Request::HEADER_X_FORWARDED_ALL` was removed upstream (Symfony); `TrustProxies.php` now ORs the individual `HEADER_X_FORWARDED_*` constants instead.
- Factories moved from the old `$factory->define(...)` closures to class-based factories (`database/factories/UserFactory.php` extends `Factory`; `User` model has `HasFactory`).

## Frontend redesign

The storefront and admin panel both use a clean, minimal design system (Mobbin-style patterns): Inter, white/light-gray neutrals, a single forest-green accent, soft rounded corners (10–20px) and subtle shadows instead of hard borders/textures. Fully mobile-responsive (off-canvas nav + mini-cart drawer under 992px on the storefront; collapsible sidebar under 992px in admin). Notes for future work:

- The admin panel (`resources/views/lay/admin.blade.php` + `resources/views/admin/*`) no longer uses AdminLTE/Font Awesome/jQuery — it's plain Blade + the same compiled `app.css`/`app.js` as the storefront, with `wb-admin__*` classes for the sidebar/topbar/tables/forms. `resources/views/admin/manageProductImages.blade.php` is the multi-image upload/delete page (see "Schema redesign" above).
- The category taxonomy now lives in the `categories` table (see "Schema redesign" above), not a config file. `AppServiceProvider` shares all categories globally as `$navCategories` on every view — used by the header mega-menu, mobile off-canvas menu, homepage category strip, footer, and the shop sidebar (`resources/views/layout/category.blade.php`).
- `resources/views/components/icon.blade.php` is a single inline-SVG icon component (`<x-icon name="..." />`) that replaced the old mismatched zmdi/themify/fontawesome icon fonts across the rewritten views.
- `resources/views/partials/product-card.blade.php` is the shared product card used on the homepage rails, shop grid, and quick-view modal data.
- `database/seeders/ProductSeeder.php` seeds 10 categories and ~50 placeholder products for demo purposes; it writes category placeholder SVGs to `storage/app/public/product_images/` via the `public` disk. Note: `Storage::disk('local')->url(...)` (used throughout the views) always resolves to `/storage/...` regardless of the `local` disk's configured `root` (see `FilesystemAdapter::getLocalUrl()`), so product images must live under the `public` disk / `storage/app/public/product_images` for the `/storage` symlink to serve them — run `php artisan storage:link` after a fresh clone.
- `resources/views/cartProducts.blade.php` was renamed to lowercase `cartproducts.blade.php` to match the `view('cartproducts', ...)` call in `ProductsController@showCart` (Blade view lookups are case-sensitive on the Linux container even though the previous mismatch went unnoticed on case-insensitive local filesystems).
- Fixed while redesigning: `shop`/`product`/`search` routes all now go through `ProductsController@search`, which always passes `$products` (previously `shop`/`product` returned a static view with no data — a pre-existing bug); `productView` now uses `findOrFail` (404 instead of a null-property crash on a missing id); the checkout form's `lastname` field name now matches what `billingconfirm()` reads (previously silently dropped every customer's last name).

## Architecture

- **Routing** (`routes/web.php`): mostly closure/controller-array routes (Laravel 5-style `['uses' => ..., 'as' => ...]` arrays rather than the newer array-callable syntax), not resourceful/grouped. Notable route groups:
  - Public storefront: `/`, `shop`, `product`, `productview/{id}`, `search`, `cart`, `billing` → `ProductsController` (note: routes reference the lowercase-first-letter `productsController` for some entries — case-insensitive on the underlying filesystem but be aware of the mismatch with the actual class `App\Http\Controllers\ProductsController`).
  - Wishlist/cart mutation routes are `GET` requests (not POST), guarded by `auth` middleware for wishlist actions only.
  - Admin area under `admin/*` guarded by a custom `restictToAdmin` middleware alias (registered in `app/Http/Kernel.php`, implemented in `app/Http/Middleware/RestrictAccess.php`), which checks `Auth::user()->isAdmin()` and redirects to `/login` otherwise. Admin routes are not grouped with a shared prefix/middleware group — the alias is repeated per-route.
  - OAuth: `login/{platform}` and `login/{platform}/callback` are generic Socialite routes handled by `App\Http\Controllers\social` (lowercase class name) rather than `LoginController`, even though `LoginController` is imported in `web.php`.

- **Models** (`app/*.php`, not under `app/Models`): `User`, `Category`, `Product` (`belongsTo Category`, `hasMany ProductImage` via `images()`, `primary_image` accessor), `ProductImage` (`belongsTo Product`), `Order`, `Orders_Items`, `Cart` (a plain non-Eloquent class serialized into the session, not a DB table).

- **Controllers**: `app/Http/Controllers/ProductsController.php` is the main storefront controller (products, cart, wishlist, billing all live here rather than being split by resource). `app/Http/Controllers/Admin/AdminProductController.php` handles all admin CRUD for products and viewing orders/invoices. Auth scaffolding under `app/Http/Controllers/Auth/` is the stock Laravel UI (`laravel/ui`) output.

- **OAuth config**: GitHub/Google client IDs and secrets are committed directly in `.env` (not just `.env.example`) — treat `.env` in this repo as containing real-looking secrets when handling it.

- **Front-end**: `resources/js/app.js` + `resources/sass/app.scss` built via Laravel Mix (`webpack.mix.js`) into `public/js` and `public/css`. Views are plain Blade under `resources/views` (note both `resources/views/lay`, `resources/views/layout`, and `resources/views/layouts` exist — check which is actually referenced before adding new views, as there may be dead/duplicate layout directories).
