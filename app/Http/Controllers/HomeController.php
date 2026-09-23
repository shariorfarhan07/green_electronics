<?php

namespace App\Http\Controllers;

use App\Order;
use App\Orders_Items;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the account dashboard: profile, quick stats and recent orders.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id();

        $recentOrders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $orderItems = Orders_Items::whereIn('order_id', $recentOrders->pluck('id'))
            ->get()
            ->groupBy('order_id');

        return Inertia::render('Account/Dashboard', [
            'recentOrders' => $recentOrders,
            'orderItems' => $orderItems,
            'images' => Product::imageUrlsForOrderItems($orderItems->flatten()),
            'orderCount' => Order::where('user_id', $userId)->count(),
            'wishlistCount' => DB::table('wishlist')->where('user_id', $userId)->count(),
        ]);
    }
}
