<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\ContactMessage;
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
        // The categories query is memoized in $navCategories (captured by reference) rather than
        // re-queried, since this composer runs once per *view* rendered (partials, components, etc.)
        // — a page with 50 product cards would otherwise re-run it 50+ times per request.
        $navCategories = null;

        View::composer('*',function ($view) use (&$navCategories)
        {
            if ($navCategories === null) {
                // Roots with their children eager-loaded: one extra query for the whole
                // two-level menu instead of one per section.
                $navCategories = Category::with('children')->roots()->get();
            }
            $cart=Session::get('cart');
            $view->with('userdata',Auth::user())->with("cartforall",$cart)->with('navCategories', $navCategories);
        });

        // Scoped to the admin shell so the storefront never pays for this query.
        View::composer('lay.admin', function ($view) {
            $view->with('unreadMessages', ContactMessage::unread()->count());
        });
    }
}
