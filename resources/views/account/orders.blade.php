@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">My Orders</h2>
        <nav class="wb-page-header__crumb">
            <a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span>
            <a href="{{ route('account') }}" style="color:inherit;">Account</a> <span class="brd-separetor">/</span>
            <span class="active">Orders</span>
        </nav>
    </div>
</div>

<div class="container" style="padding:2.5rem 15px 4rem;">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count())
        @foreach($orders as $order)
            <div class="wb-order-card">
                <div>
                    <div class="wb-order-card__id">Order #{{ $order->id }}</div>
                    <div class="wb-order-card__meta">
                        Placed {{ $order->created_at ? $order->created_at->format('d M Y') : $order->date }}
                        &middot; &#2547;{{ number_format($order->grand_total, 2) }}
                    </div>
                </div>
                <div class="wb-order-card__right">
                    <span class="wb-status wb-status--{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
                    <a href="{{ route('account.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
                        View Details <x-icon name="chevron-right" :size="14" />
                    </a>
                </div>
            </div>
        @endforeach

        <div class="mt-4">{{ $orders->links() }}</div>
    @else
        <div class="wb-summary" style="text-align:center;padding:3rem 1.5rem;">
            <x-icon name="box" :size="38" />
            <h4 style="margin-top:1rem;">No orders yet</h4>
            <p style="color:var(--ink-soft);">When you place an order it will show up here with live status updates.</p>
            <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent mt-2">Start Shopping</a>
        </div>
    @endif

    <div class="wb-summary mt-4" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
        <div>
            <div style="font-weight:700;">Need help with an order?</div>
            <div style="font-size:.85rem;color:var(--ink-soft);">Our team is available 10am&ndash;8pm, Saturday to Thursday.</div>
        </div>
        <a href="tel:{{ config('store.phone') }}" class="wb-btn wb-btn--accent" style="margin-left:auto;">
            <x-icon name="phone" :size="16" /> Call Green Electronics
        </a>
    </div>
</div>

@endsection
