<?php

namespace App\Http\Controllers;

use App\Order;
use App\Orders_Items;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Account/Orders', ['orders' => $orders]);
    }

    public function show($id)
    {
        // Scoped to the signed-in user so order ids cannot be enumerated.
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $items = Orders_Items::where('order_id', $order->id)->get();

        return Inertia::render('Account/OrderDetail', [
            'order' => $order,
            'items' => $items,
            'images' => Product::imageUrlsForOrderItems($items),
            'timeline' => Order::TIMELINE,
            'stage' => $order->timelineStage(),
            'isCancelled' => $order->isCancelled(),
        ]);
    }
}
