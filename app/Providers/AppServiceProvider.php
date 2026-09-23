<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Nothing to share with views any more: the app renders a single Blade
        // file (app.blade.php, the Inertia shell) and every page's data — the
        // nav categories, cart, auth user and store settings the old view
        // composers provided — is shared through HandleInertiaRequests instead.
        // Paginators are serialized to JSON for the React Pagination component,
        // so no pagination view is rendered either.
    }
}
