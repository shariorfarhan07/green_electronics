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
- Global per-request data (nav categories, cart totals, auth user, store settings) is shared once in `HandleInertiaRequests::share()`. Don't reach for `Cache::remember()` to speed those queries up — the `file` cache driver reads through the same slow bind mount and made this *worse*, not better, when tried. Anything scoped to one area belongs behind a check or a closure so other requests don't pay for it (as `unreadMessages` does for `admin/*`).

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

- The admin panel no longer uses AdminLTE/Font Awesome/jQuery — it shares the same compiled `app.css` as the storefront, with `wb-admin__*` classes for the sidebar/topbar/tables/forms.
- The category taxonomy lives in the `categories` table (see "Schema redesign" above), not a config file. All categories are shared globally as the `navCategories` Inertia prop — used by the header mega-menu, mobile off-canvas menu, homepage category strip, footer and shop sidebar.
- `resources/js/Components/Icon.jsx` is a single inline-SVG icon set (`<Icon name="..." />`) that replaced the old mismatched zmdi/themify/fontawesome icon fonts.
- `resources/js/Components/ProductCard.jsx` is the shared product card used on the homepage rails and shop grid.
- `database/seeders/ProductSeeder.php` seeds 10 categories and ~50 placeholder products for demo purposes; it writes category placeholder SVGs to `storage/app/public/product_images/` via the `public` disk. Note: `Storage::disk('local')->url(...)` always resolves to `/storage/...` regardless of the `local` disk's configured `root` (see `FilesystemAdapter::getLocalUrl()`), so product images must live under the `public` disk / `storage/app/public/product_images` for the `/storage` symlink to serve them — run `php artisan storage:link` after a fresh clone. Models expose these as URLs to the frontend via appended accessors (`Product::$primary_image_url`, `ProductImage::$url`, `Product::imageUrlsForOrderItems()`) since React can't call the Storage facade.
- Product photos are shown with `object-fit: contain` everywhere and are never cropped — this is deliberate (the source photos have whitespace/solid backgrounds baked in; an earlier auto-crop pass was explicitly reverted). The product-page gallery is borderless: no frame or backing panel, and the selected thumbnail is marked by opacity, not a border.
- Fixed while redesigning: `shop`/`product`/`search` routes all now go through `ProductsController@search`, which always passes `$products` (previously `shop`/`product` returned a static view with no data — a pre-existing bug); `productView` now uses `findOrFail` (404 instead of a null-property crash on a missing id); the checkout form's `lastname` field name now matches what the checkout handler reads (previously silently dropped every customer's last name).

## Architecture

- **Routing** (`routes/web.php`): mostly closure/controller-array routes (Laravel 5-style `['uses' => ..., 'as' => ...]` arrays rather than the newer array-callable syntax), not resourceful/grouped. Notable route groups:
  - Public storefront: `/`, `shop`, `product`, `productview/{id}`, `search`, `cart`, `billing` → `ProductsController` (note: routes reference the lowercase-first-letter `productsController` for some entries — case-insensitive on the underlying filesystem but be aware of the mismatch with the actual class `App\Http\Controllers\ProductsController`).
  - Wishlist/cart mutation routes are `GET` requests (not POST), guarded by `auth` middleware for wishlist actions only.
  - Admin area under `admin/*` guarded by a custom `restictToAdmin` middleware alias (registered in `app/Http/Kernel.php`, implemented in `app/Http/Middleware/RestrictAccess.php`), which checks `Auth::user()->isAdmin()` and redirects to `/login` otherwise. Admin routes are not grouped with a shared prefix/middleware group — the alias is repeated per-route.
  - OAuth: `login/{platform}` and `login/{platform}/callback` are generic Socialite routes handled by `App\Http\Controllers\social` (lowercase class name) rather than `LoginController`, even though `LoginController` is imported in `web.php`.

- **Models** (`app/*.php`, not under `app/Models`): `User`, `Category`, `Product` (`belongsTo Category`, `hasMany ProductImage` via `images()`, `primary_image` accessor), `ProductImage` (`belongsTo Product`), `Order`, `Orders_Items`, `Cart` (a plain non-Eloquent class serialized into the session, not a DB table).

- **Controllers**: `app/Http/Controllers/ProductsController.php` is the main storefront controller (products, cart, wishlist, billing all live here rather than being split by resource). `app/Http/Controllers/Admin/AdminProductController.php` handles all admin CRUD for products and viewing orders/invoices. Auth scaffolding under `app/Http/Controllers/Auth/` is the stock Laravel UI (`laravel/ui`) output.

- **OAuth config**: GitHub/Google client IDs and secrets are committed directly in `.env` (not just `.env.example`) — treat `.env` in this repo as containing real-looking secrets when handling it.

- **Front-end**: see "Single-page application (Inertia + React)" below.

## Single-page application (Inertia + React)

The whole app — storefront, auth and admin — is one SPA. Every controller returns `Inertia::render('PageName', [...props])`; there is **exactly one Blade file left**, `resources/views/app.blade.php`, the shell that boots the JS. There are no Blade page views, layouts, partials or components, and no `View::composer`s. If you add a screen, add a React page, not a Blade view.

- **Pages** live in `resources/js/Pages/`, and the page name passed to `Inertia::render()` is its path there (`Admin/Products` → `resources/js/Pages/Admin/Products.jsx`). `resources/js/inertia.jsx` resolves them via a webpack `require` context, so no registration step is needed for a new page.
- **Layouts** are attached per page with the Inertia persistent-layout pattern at the bottom of each page file: `Page.layout = (page) => <Layout>{page}</Layout>`. Three exist: `Layout.jsx` (storefront chrome — header, nav, off-canvas menu, cart drawer, footer), `AuthLayout.jsx` (bare login/register shell) and `AdminLayout.jsx` (admin sidebar/topbar, takes a `title` prop). `Pages/Admin/Invoice.jsx` deliberately has **no** layout — it's a print document.
- Because the layout is persistent, its state (open drawers, etc.) survives navigation, and the chrome never re-mounts. Don't move header/footer markup into individual pages.
- **Navigation must go through Inertia** or the SPA breaks: use `<Link href="...">` instead of `<a href="...">` for anything internal, and `router.get/post/put/delete` for programmatic visits. Keep plain `<a>` only for genuinely external things — `tel:`, `mailto:`, OAuth redirects, and the CSV export (a file download, not a page visit).
- **Forms** use `useForm()` and post to the existing routes. Validation errors come back automatically as the `errors` prop (Inertia's base middleware shares them), so Laravel-side validation is unchanged. File uploads need `forceFormData: true`.
- **Mutation-then-return routes** (`cart/add/{id}`, `cart/items/{id}/{n}`) `redirect()->back()` rather than to a fixed route, so an Inertia visit re-renders whatever page the customer was on with fresh props. Clicking these through `<Link>` is what makes add-to-cart feel instant.
- **Shared props** come from `app/Http/Middleware/HandleInertiaRequests.php`: `auth` (with `isAdmin`), `cart` totals, `ordersDisabled`, `navCategories`, `store` contact details, `flash` and `unreadMessages`. Anything the chrome needs belongs there, not in each controller.
- Model data the frontend needs as a URL or computed value must be an **appended accessor** (`$appends`), since React can't call Blade helpers — see `Product::$primary_image_url`, `ProductImage::$url`, `Order::$grand_total`, `ContactMessage::$is_unread`.
- Paginators are passed straight through as props; `Components/Pagination.jsx` renders from the serialized `links` array. Don't call `->links()`.
- `Components/Admin/` holds the React replacements for what used to be jQuery/vanilla DOM enhancements: `SearchableSelect` (the ~150-entry category tree), `ImageDropzone`, `FileDropzone`, `ProductFormFields` (shared by the create and edit product screens) and `ErrorAlert`.
- **Build**: one entry point. `mix.react('resources/js/inertia.jsx', 'public/js')` + the sass build → `public/js/inertia.js` and `public/css/app.css`. Bootstrap's *SCSS* is still imported by `app.scss` for its grid/form/alert classes, but no Bootstrap or jQuery **JavaScript** is loaded any more — don't reintroduce `$(...)`-style code.
- `webpack.mix.js` carries two overrides this stack needs; don't remove them without testing: a babel-loader rule for `node_modules/@inertiajs/**` (webpack 4's parser can't handle the ES2020 syntax they ship) and an `axios$` alias forcing axios's CJS build (the ESM build breaks `@inertiajs/core`'s interop helper). The pinned versions matter too: `inertiajs/inertia-laravel@1.3.x` and `@inertiajs/react@1.3.0` — newer releases use `import.meta` and a different page-payload format that webpack 4 / this shell can't handle.
