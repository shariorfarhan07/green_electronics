@extends('lay.admin')
@section('page-title', 'Edit Order')
@section('content')

<div class="wb-admin__actions mb-3">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
        <x-icon name="chevron-left" :size="15" /> Back to Invoice #{{ $order->id }}
    </a>
    <a href="{{ route('admin.orders.index') }}" class="wb-btn wb-btn--ghost wb-btn--sm">All Orders</a>
    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $order->phone) }}" class="wb-btn wb-btn--accent wb-btn--sm">
        <x-icon name="phone" :size="14" /> Call Customer &middot; {{ $order->phone }}
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

@php $grandTotal = $order->payment + $order->shipping - ($order->discount ?: 0); @endphp

<div class="wb-admin__form-wrap">

    {{-- Item add/remove post to their own endpoints, so they sit outside the order form. --}}
    <div class="wb-admin__fieldset">
        <div class="wb-admin__fieldset-head">
            <x-icon name="box" :size="18" />
            <div>
                <h4>Order Items</h4>
                <p>The order subtotal recalculates automatically when items change.</p>
            </div>
        </div>
        <div class="wb-admin__fieldset-body">
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
                                <td>
                                    <div style="display:flex;align-items:center;gap:.7rem;">
                                        <span class="wb-order-thumb" style="width:44px;height:44px;">
                                            @if($images[$item->item_id] ?? null)
                                                <img src="{{ Storage::disk('local')->url('product_images/'.$images[$item->item_id]) }}" alt="{{ $item->item_name }}">
                                            @else
                                                <x-icon name="image" :size="16" />
                                            @endif
                                        </span>
                                        <span style="font-weight:600;">{{ $item->item_name }}</span>
                                    </div>
                                </td>
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
                <p style="color:var(--ink-soft);">This order has no items. The subtotal will be &#2547;0.00 until you add one.</p>
            @endif

            <form action="{{ route('admin.orders.items.store', $order->id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-7 form-group">
                        <label for="product_id">Add Product</label>
                        <select class="form-control" name="product_id" id="product_id" required
                                data-searchable data-search-placeholder="Search products…">
                            <option value="">Select a product&hellip;</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} — &#2547;{{ number_format($p->price, 2) }}</option>
                            @endforeach
                        </select>
                        <small class="wb-admin__hint">Price is captured from the product's current price.</small>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" class="form-control" name="qty" id="qty" value="1" min="1" required>
                    </div>
                    <div class="col-md-2 form-group d-flex align-items-end">
                        <button type="submit" class="wb-btn wb-btn--accent" style="width:100%;">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="truck" :size="18" />
                <div>
                    <h4>Fulfilment Status</h4>
                    <p>Shown on the invoice and in the orders list.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="status">Order Status <span class="wb-admin__req">*</span></label>
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
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="user" :size="18" />
                <div>
                    <h4>Customer &amp; Delivery</h4>
                    <p>Where this order is going.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Customer Name <span class="wb-admin__req">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $order->name) }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">Phone <span class="wb-admin__req">*</span></label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $order->phone) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $order->email) }}">
                </div>
                <div class="form-group">
                    <label for="address">Address <span class="wb-admin__req">*</span></label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $order->address) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="city">City <span class="wb-admin__req">*</span></label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ old('city', $order->city) }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="division">Division <span class="wb-admin__req">*</span></label>
                        <input type="text" class="form-control" name="division" id="division" value="{{ old('division', $order->division) }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="zip">Zip <span class="wb-admin__req">*</span></label>
                        <input type="text" class="form-control" name="zip" id="zip" value="{{ old('zip', $order->zip) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="wb-admin__fieldset">
            <div class="wb-admin__fieldset-head">
                <x-icon name="cart" :size="18" />
                <div>
                    <h4>Totals &amp; Payment</h4>
                    <p>Grand total is currently &#2547;{{ number_format($grandTotal, 2) }}.</p>
                </div>
            </div>
            <div class="wb-admin__fieldset-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Subtotal (&#2547;)</label>
                        <input type="text" class="form-control" value="{{ number_format($order->payment, 2) }}" disabled>
                        <small class="wb-admin__hint">Calculated from the order items above.</small>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="shipping">Shipping (&#2547;) <span class="wb-admin__req">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" name="shipping" id="shipping" value="{{ old('shipping', $order->shipping) }}" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="discount">Discount (&#2547;)</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="discount" id="discount" value="{{ old('discount', $order->discount) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="payment_method">Payment Method <span class="wb-admin__req">*</span></label>
                        <select class="form-control" name="payment_method" id="payment_method">
                            <option value="cod" @selected($order->payment_method === 'cod')>Cash on Delivery</option>
                            <option value="bkash" @selected($order->payment_method === 'bkash')>bKash</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="cod_amount">Cash to Collect (&#2547;)</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="cod_amount" id="cod_amount" value="{{ old('cod_amount', $order->cod_amount) }}" placeholder="{{ number_format($grandTotal, 2) }}">
                        <small class="wb-admin__hint">Only used for Cash on Delivery.</small>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="paid">Amount Already Paid (&#2547;)</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="paid" id="paid" value="{{ old('paid', $order->paid) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="bkashnumber">bKash / Payment Number</label>
                        <input type="text" class="form-control" name="bkashnumber" id="bkashnumber" value="{{ old('bkashnumber', $order->bkashnumber) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="txid">Transaction ID</label>
                        <input type="text" class="form-control" name="txid" id="txid" value="{{ old('txid', $order->txid) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Internal Note</label>
                    <textarea class="form-control" rows="3" name="message" id="message" placeholder="Not shown to the customer">{{ old('message', $order->message) }}</textarea>
                </div>
            </div>
        </div>

        <div class="wb-admin__form-actions">
            <button type="submit" class="wb-btn wb-btn--accent">Save Changes</button>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost">Cancel</a>
            <span>Order #{{ $order->id }} &middot; {{ $items->count() }} item(s)</span>
        </div>
    </form>
</div>

@endsection
