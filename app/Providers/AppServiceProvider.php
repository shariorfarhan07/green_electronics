<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Category;
use App\ContactMessage;
use App\Setting;
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
        // Laravel's built-in pagination views assume Tailwind is loaded; this app ships
        // neither Tailwind nor Bootstrap-4's pagination CSS, so those views' bare
        // <svg class="w-5 h-5"> arrows rendered unconstrained (hundreds of pixels wide).
        // pagination.custom is styled with this app's own wb-pagination classes instead.
        Paginator::defaultView('pagination.custom');

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
            $view->with('userdata',Auth::user())->with("cartforall",$cart)->with('navCategories', $navCategories)
                ->with('ordersDisabled', Setting::bool('orders_disabled'));
        });

        // Scoped to the admin shell so the storefront never pays for this query.
        View::composer('lay.admin', function ($view) {
            $view->with('unreadMessages', ContactMessage::unread()->count());
        });
    }
}
