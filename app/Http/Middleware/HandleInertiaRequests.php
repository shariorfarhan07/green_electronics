<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use App\Category;
use App\ContactMessage;
use App\Setting;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Props every page gets. The header, nav, cart drawer and footer are part
     * of the persistent React layout rather than per-page markup, so the data
     * they need is shared here once instead of being passed by each controller.
     */
    public function share(Request $request): array
    {
        $cart = Session::get('cart');

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => Auth::user(),
                'isAdmin' => Auth::check() && Auth::user()->isAdmin(),
            ],
            // Line items are included, not just totals, so the mini cart drawer
            // can render them on any page. Only the handful of fields the drawer
            // needs are sent rather than the whole Product model.
            'cart' => $cart ? [
                'totalQuantity' => $cart->totalQuantity,
                'totalPrice' => $cart->totalPrice,
                'items' => collect($cart->items)->map(function ($item) {
                    return [
                        'id' => $item['data']->id,
                        'name' => $item['data']->name,
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'image' => $item['data']->primary_image_url,
                    ];
                })->values(),
            ] : null,
            'ordersDisabled' => Setting::bool('orders_disabled'),
            'navCategories' => Category::with('children')->roots()->get(),
            'store' => [
                'phone' => config('store.phone'),
                'phoneDisplay' => config('store.phone_display'),
                'whatsapp' => config('store.whatsapp'),
            ],
            // Flash messages: Blade read these straight off the session, but an
            // Inertia page only gets what's shared here.
            'flash' => [
                'success' => Session::get('success'),
                'status' => Session::get('status'),
                'resent' => Session::get('resent'),
                'importErrors' => Session::get('importErrors', []),
                'importErrorCount' => Session::get('importErrorCount', 0),
            ],
            // Admin sidebar badge only — kept off storefront requests so they
            // don't pay for the query (the Blade version scoped this to the
            // admin layout's view composer for the same reason).
            'unreadMessages' => fn () => $request->is('admin/*') ? ContactMessage::unread()->count() : 0,
        ]);
    }
}
