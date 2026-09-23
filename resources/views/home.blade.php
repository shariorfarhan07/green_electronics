@extends('layout.app')
@section('title', 'My Account')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">My Account</h2>
        <nav class="wb-page-header__crumb">
            <a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span>
            <span class="active">Account</span>
        </nav>
    </div>
</div>

<div class="container" style="padding:2.5rem 15px 4rem;">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="wb-account-grid">
        <aside class="wb-account-side">
            <div class="wb-account-profile">
                <div class="wb-account-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="wb-account-profile__name">{{ Auth::user()->name }}</div>
                <div class="wb-account-profile__email">{{ Auth::user()->email }}</div>
            </div>

            <div class="wb-account-stats">
                <div class="wb-account-stat">
                    <div class="wb-account-stat__num">{{ $orderCount }}</div>
                    <div class="wb-account-stat__label">Orders</div>
                </div>
                <div class="wb-account-stat">
                    <div class="wb-account-stat__num">{{ $wishlistCount }}</div>
                    <div class="wb-account-stat__label">Wishlist</div>
                </div>
            </div>

            <nav class="wb-account-nav">
                <a href="{{ route('account') }}" class="wb-account-nav__link is-active">
                    <x-icon name="user" :size="16" /> Overview
                </a>
                <a href="{{ route('account.orders.index') }}" class="wb-account-nav__link">
                    <x-icon name="box" :size="16" /> My Orders
                </a>
                <a href="{{ route('wishlist.index') }}" class="wb-account-nav__link">
                    <x-icon name="heart" :size="16" /> Wishlist
                </a>
                @if($userdata->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="wb-account-nav__link">
                        <x-icon name="shield" :size="16" /> Admin Panel
                    </a>
                @endif
            </nav>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="wb-btn wb-btn--ghost wb-btn--block">
                    <x-icon name="reply" :size="16" /> Log out
                </button>
            </form>
        </aside>

        <div class="wb-account-main">
            <div class="wb-account-welcome">
                <div>
                    <h3>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h3>
                    <p>Track your orders and manage your account from here.</p>
                </div>
                <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent">
                    <x-icon name="grid" :size="16" /> Continue Shopping
                </a>
            </div>

            <div class="wb-summary">
                <div class="wb-summary__title" style="display:flex;align-items:center;gap:.75rem;">
                    Recent Orders
                    @if($orderCount > 0)
                        <a href="{{ route('account.orders.index') }}" style="margin-left:auto;font-size:.82rem;font-weight:600;display:inline-flex;align-items:center;gap:.2rem;">
                            View all <x-icon name="chevron-right" :size="12" />
                        </a>
                    @endif
                </div>

                @forelse($recentOrders as $order)
                    @php
                        $items = $orderItems->get($order->id, collect());
                        $firstItem = $items->first();
                    @endphp
                    <div class="wb-order-card">
                        <div class="wb-order-thumb">
                            @if($firstItem && ($images[$firstItem->item_id] ?? null))
                                <img src="{{ Storage::disk('local')->url('product_images/'.$images[$firstItem->item_id]) }}" alt="{{ $firstItem->item_name }}">
                            @else
                                <x-icon name="box" :size="20" />
                            @endif
                        </div>
                        <div>
                            <div class="wb-order-card__id">Order #{{ $order->id }}</div>
                            <div class="wb-order-card__meta">
                                {{ $items->count() }} item{{ $items->count() === 1 ? '' : 's' }}
                                &middot; &#2547;{{ number_format($order->grand_total, 2) }}
                                &middot; {{ $order->created_at ? $order->created_at->format('d M Y') : $order->date }}
                            </div>
                        </div>
                        <div class="wb-order-card__right">
                            <span class="wb-status wb-status--{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
                            <a href="{{ route('account.orders.show', $order->id) }}" class="wb-btn wb-btn--ghost wb-btn--sm">
                                View <x-icon name="chevron-right" :size="14" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:2.5rem 1rem;">
                        <x-icon name="box" :size="36" />
                        <p style="margin:.8rem 0 1.2rem;color:var(--ink-soft);">You haven't placed any orders yet.</p>
                        <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent">Start Shopping</a>
                    </div>
                @endforelse
            </div>

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
    </div>
</div>

@endsection
