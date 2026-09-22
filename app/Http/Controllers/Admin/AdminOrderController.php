<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orders_Items;
use App\Product;
use Illuminate\Http\Request;
use Validator;

class AdminOrderController extends Controller
{
    const STATUSES = [
        'our representative will call you',
        'processing',
        'shipped',
        'delivered',
        'cancelled',
    ];

    public function index(){
        $products = Order::orderBy('date', 'desc')->paginate(20);
        return view("admin.order",['products'=>$products ]);
    }

    public function show($id){
        $products = Orders_Items::where('order_id', $id)->get();
        $customer = Order::findOrFail($id);

        return view("admin.invoice",['products'=>$products ,'customer'=>$customer]);
    }

    public function edit($id){
        $order = Order::findOrFail($id);
        $items = Orders_Items::where('order_id', $id)->get();
        $products = Product::orderBy('name')->get();
        return view('admin.editOrderForm', [
            'order' => $order,
            'items' => $items,
            'products' => $products,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, $id){
        $order = Order::findOrFail($id);

        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:120',
            'division' => 'required|string|max:120',
            'zip' => 'required|string|max:20',
            'status' => 'required|string|max:120',
            'payment_method' => 'required|in:cod,bkash',
            'shipping' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'paid' => 'nullable|numeric',
            'cod_amount' => 'nullable|numeric',
            'bkashnumber' => 'nullable|string|max:120',
            'txid' => 'nullable|string|max:120',
        ])->validate();

        $order->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'division' => $request->input('division'),
            'zip' => $request->input('zip'),
            'status' => $request->input('status'),
            'payment_method' => $request->input('payment_method'),
            'cod_amount' => $request->input('payment_method') === 'cod' ? ($request->input('cod_amount') ?: null) : null,
            'shipping' => $request->input('shipping'),
            'discount' => $request->input('discount') ?: null,
            'paid' => $request->input('paid') ?: null,
            'bkashnumber' => $request->input('bkashnumber'),
            'txid' => $request->input('txid'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('admin.orders.edit', $order->id)->withsuccess('Order updated.');
    }

    public function addItem(Request $request, $id){
        $order = Order::findOrFail($id);

        Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ])->validate();

        $product = Product::findOrFail($request->input('product_id'));

        Orders_Items::create([
            'order_id' => $order->id,
            'item_id' => $product->id,
            'item_name' => $product->name,
            'item_price' => $product->price,
            'qty' => $request->input('qty'),
        ]);

        $this->recalculateSubtotal($order);

        return redirect()->route('admin.orders.edit', $order->id)->withsuccess('Product added to order.');
    }

    public function removeItem($id, $itemId){
        $order = Order::findOrFail($id);
        Orders_Items::where('order_id', $order->id)->where('id', $itemId)->delete();

        $this->recalculateSubtotal($order);

        return redirect()->route('admin.orders.edit', $order->id)->withsuccess('Product removed from order.');
    }

    private function recalculateSubtotal(Order $order){
        $subtotal = Orders_Items::where('order_id', $order->id)
            ->get()
            ->sum(fn ($item) => $item->qty * $item->item_price);

        $order->update(['payment' => $subtotal]);
    }
}
