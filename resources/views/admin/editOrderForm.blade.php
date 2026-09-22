@extends('lay.admin')
@section('page-title', 'Edit Order')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to Invoice #{{ $order->id }}
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="wb-admin__panel" style="padding:1.5rem;margin-bottom:1.5rem;">
    <h4 class="mb-3">Order Items</h4>

    @if($items->count())
        <div class="wb-admin__table-wrap mb-3">
            <table class="wb-admin__table">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Line Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="font-weight:600;">{{ $item->item_name }}</td>
                        <td class="mono">&#2547;{{ number_format($item->item_price, 2) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td class="mono">&#2547;{{ number_format($item->qty * $item->item_price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.items.destroy', [$order->id, $item->id]) }}" method="post" onsubmit="return confirm('Remove this item from the order?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="wb-admin__icon-btn wb-admin__icon-btn--danger" title="Remove item"><x-icon name="trash" :size="14" /></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="color:var(--ink-soft);">This order has no items. The order subtotal will be &#2547;0.00 until you add one.</p>
    @endif

    <form action="{{ route('admin.orders.items.store', $order->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-7 form-group">
                <label for="product_id">Add Product</label>
                <select class="form-control" name="product_id" id="product_id" required>
                    <option value="">Select a product&hellip;</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} &mdash; &#2547;{{ number_format($p->price, 2) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label for="qty">Quantity</label>
                <input type="number" class="form-control" name="qty" id="qty" value="1" min="1" required>
            </div>
            <div class="col-md-2 form-group d-flex align-items-end">
                <button type="submit" class="wb-btn wb-btn--accent" style="width:100%;">Add</button>
            </div>
        </div>
        <small style="color:var(--ink-faint);">Price is captured from the product's current price. The order subtotal recalculates automatically.</small>
    </form>
</div>

<div class="wb-admin__form">
    <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="status">Order Status</label>
                <select class="form-control" name="status" id="status">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                    @if(!in_array($order->status, $statuses))
                        <option value="{{ $order->status }}" selected>{{ $order->status }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name">Customer Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $order->name }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $order->phone }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ $order->email }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="{{ $order->address }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ $order->city }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="division">Division</label>
                <input type="text" class="form-control" name="division" id="division" value="{{ $order->division }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" name="zip" id="zip" value="{{ $order->zip }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label>Subtotal (&#2547;)</label>
                <input type="text" class="form-control" value="{{ number_format($order->payment, 2) }}" disabled>
                <small style="color:var(--ink-faint);">Calculated from the order items above.</small>
            </div>
            <div class="col-md-4 form-group">
                <label for="shipping">Shipping (&#2547;)</label>
                <input type="text" class="form-control" name="shipping" id="shipping" value="{{ $order->shipping }}" required>
            </div>
            <div class="col-md-4 form-group">
                <label for="discount">Discount (&#2547;, optional)</label>
                <input type="text" class="form-control" name="discount" id="discount" value="{{ $order->discount }}">
            </div>
        </div>

        @php $grandTotal = $order->payment + $order->shipping - ($order->discount ?: 0); @endphp
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" name="payment_method" id="payment_method">
                    <option value="cod" @selected($order->payment_method === 'cod')>Cash on Delivery</option>
                    <option value="bkash" @selected($order->payment_method === 'bkash')>bKash</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
                <label for="cod_amount">Cash to Collect on Delivery (&#2547;)</label>
                <input type="text" class="form-control" name="cod_amount" id="cod_amount" value="{{ $order->cod_amount }}" placeholder="{{ number_format($grandTotal, 2) }}">
                <small style="color:var(--ink-faint);">Grand total is &#2547;{{ number_format($grandTotal, 2) }}. Leave blank to clear; only used for Cash on Delivery.</small>
            </div>
            <div class="col-md-4 form-group">
                <label for="paid">Amount Already Paid (&#2547;, optional)</label>
                <input type="text" class="form-control" name="paid" id="paid" value="{{ $order->paid }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="bkashnumber">bKash / Payment Number</label>
                <input type="text" class="form-control" name="bkashnumber" id="bkashnumber" value="{{ $order->bkashnumber }}">
            </div>
            <div class="col-md-6 form-group">
                <label for="txid">Transaction ID</label>
                <input type="text" class="form-control" name="txid" id="txid" value="{{ $order->txid }}">
            </div>
        </div>

        <div class="form-group">
            <label for="message">Internal Note (optional)</label>
            <textarea class="form-control" rows="3" name="message" id="message">{{ $order->message }}</textarea>
        </div>

        <button type="submit" name="submit" class="wb-btn wb-btn--accent">Save Changes</button>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost">Cancel</a>
    </form>
</div>

@endsection
