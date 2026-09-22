@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Order #{{ $order->id }}</h2>
        <nav class="wb-page-header__crumb">
            <a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span>
            <a href="{{ route('account.orders.index') }}" style="color:inherit;">My Orders</a> <span class="brd-separetor">/</span>
            <span class="active">#{{ $order->id }}</span>
        </nav>
    </div>
</div>

<div class="container" style="padding:2.5rem 15px 4rem;">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="wb-summary mb-4">
                <div class="wb-summary__title" style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
                    Order Status
                    <span class="wb-status wb-status--{{ \Illuminate\Support\Str::slug($order->status) }}" style="margin-left:auto;">{{ $order->status }}</span>
                </div>

                @if($order->isCancelled())
                    <p style="color:var(--danger);font-weight:600;margin:0;">This order was cancelled. Call us if you think this is a mistake.</p>
                @else
                    @php $stage = $order->timelineStage(); @endphp
                    <div class="wb-timeline">
                        @foreach(\App\Order::TIMELINE as $i => $step)
                            @php
                                $n = $i + 1;
                                $state = $n < $stage ? 'is-done' : ($n === $stage ? 'is-current' : '');
                            @endphp
                            <div class="wb-timeline__step {{ $state }}">
                                <div class="wb-timeline__dot">
                                    @if($n < $stage)
                                        <x-icon name="check" :size="15" />
                                    @elseif($n === $stage)
                                        <x-icon name="truck" :size="15" />
                                    @else
                                        <x-icon name="box" :size="15" />
                                    @endif
                                </div>
                                <div class="wb-timeline__label">{{ $step }}</div>
                            </div>
                        @endforeach
                    </div>
                    <p style="font-size:.85rem;color:var(--ink-soft);margin:0;">
                        @if($stage <= 1)
                            We have received your order and our representative will confirm it with you shortly.
                        @elseif($stage === 2)
                            Your order is on its way. Keep your phone reachable for the delivery call.
                        @else
                            This order has been delivered. Thank you for shopping with us.
                        @endif
                    </p>
                @endif
            </div>

            <div class="wb-summary">
                <div class="wb-summary__title">Items ({{ $items->count() }})</div>
                @foreach($items as $item)
                    <div class="wb-order-item">
                        <div class="wb-order-thumb">
                            @if($images[$item->item_id] ?? null)
                                <img src="{{ Storage::disk('local')->url('product_images/'.$images[$item->item_id]) }}" alt="{{ $item->item_name }}">
                            @else
                                <x-icon name="image" :size="18" />
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-weight:600;">{{ $item->item_name }}</div>
                            <div style="font-size:.8rem;color:var(--ink-faint);">
                                Qty {{ $item->qty }} &times; &#2547;{{ number_format($item->item_price, 2) }}
                            </div>
                        </div>
                        <div style="font-weight:600;white-space:nowrap;">&#2547;{{ number_format($item->qty * $item->item_price, 2) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="wb-summary mb-4">
                <div class="wb-summary__title">Payment Summary</div>
                <div class="wb-summary__row"><span>Subtotal</span><span>&#2547;{{ number_format($order->payment, 2) }}</span></div>
                <div class="wb-summary__row"><span>Shipping</span><span>&#2547;{{ number_format($order->shipping, 2) }}</span></div>
                @if($order->discount)
                    <div class="wb-summary__row"><span>Discount</span><span>&minus;&#2547;{{ number_format($order->discount, 2) }}</span></div>
                @endif
                <div class="wb-summary__row wb-summary__row--total"><span>Total</span><span>&#2547;{{ number_format($order->grand_total, 2) }}</span></div>
                <div class="wb-summary__row">
                    <span>Payment</span>
                    <span>{{ $order->payment_method === 'bkash' ? 'bKash' : 'Cash on Delivery' }}</span>
                </div>
                @if($order->payment_method === 'cod' && $order->cod_amount)
                    <div class="wb-summary__row"><span>Cash to pay</span><span style="font-weight:700;color:var(--ink);">&#2547;{{ number_format($order->cod_amount, 2) }}</span></div>
                @endif
            </div>

            <div class="wb-summary mb-4">
                <div class="wb-summary__title">Delivery Address</div>
                <p style="margin:0;line-height:1.7;font-size:.9rem;">
                    <strong>{{ $order->name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->city }}, {{ $order->division }} &mdash; {{ $order->zip }}<br>
                    <span style="color:var(--ink-soft);">{{ $order->phone }}</span>
                </p>
            </div>

            <div class="wb-summary">
                <div class="wb-summary__title">Questions about this order?</div>
                <p style="font-size:.85rem;color:var(--ink-soft);">
                    Quote order <strong>#{{ $order->id }}</strong> when you call and we can help straight away.
                </p>
                <a href="tel:{{ config('store.phone') }}" class="wb-btn wb-btn--accent wb-btn--block">
                    <x-icon name="phone" :size="16" /> Call Green Electronics
                </a>
                <p style="text-align:center;margin:.6rem 0 0;font-size:.8rem;color:var(--ink-faint);">
                    {{ config('store.phone_display') }}
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
