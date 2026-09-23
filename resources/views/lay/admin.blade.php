<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin &middot; Green Electronics</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="wb-admin">
    <div class="wb-offcanvas__backdrop" id="wb-admin-sidebar-backdrop"></div>

    <aside class="wb-admin__sidebar" id="wb-admin-sidebar">
        <div class="wb-admin__brand">
            <a href="{{ route('admin.products.index') }}" style="color:#fff;">Green<span>Electronics</span></a>
            <button type="button" class="wb-offcanvas__close" data-close aria-label="Close menu" style="background:rgba(255,255,255,.1);color:#fff;">
                <x-icon name="close" :size="16" />
            </button>
        </div>
        <nav class="wb-admin__nav">
            <div class="wb-admin__nav-group-title">Catalogue</div>
            <a href="{{ route('admin.products.index') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.products.index') ? 'is-active' : '' }}">
                <x-icon name="grid" :size="17" /> All Products
            </a>
            <a href="{{ route('admin.products.create') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.products.create') ? 'is-active' : '' }}">
                <x-icon name="plus" :size="17" /> Add New Product
            </a>
            <a href="{{ route('admin.categories.index') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.categories.index') ? 'is-active' : '' }}">
                <x-icon name="filter" :size="17" /> Categories
            </a>
            <a href="{{ route('admin.products.bulk') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.products.bulk') ? 'is-active' : '' }}">
                <x-icon name="printer" :size="17" /> Bulk Products
            </a>
            <div class="wb-admin__nav-group-title">Sales</div>
            <a href="{{ route('admin.orders.index') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}">
                <x-icon name="box" :size="17" /> Orders
            </a>
            <div class="wb-admin__nav-group-title">Inbox</div>
            <a href="{{ route('admin.messages.index') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                <x-icon name="mail" :size="17" /> Messages
                @if(($unreadMessages ?? 0) > 0)
                    <span class="wb-admin__nav-count">{{ $unreadMessages }}</span>
                @endif
            </a>
            <div class="wb-admin__nav-group-title">Store</div>
            <a href="{{ route('admin.settings.edit') }}" class="wb-admin__nav-link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">
                <x-icon name="wrench" :size="17" /> Settings
            </a>
        </nav>
        <div class="wb-admin__sidebar-foot">
            <a href="{{ url('/') }}"><x-icon name="chevron-left" :size="15" /> Back to Store</a>
            <form action="{{ route('logout') }}" method="post" style="margin-top:.5rem;">
                @csrf
                <button type="submit" style="border:none;background:none;padding:0;font:inherit;color:inherit;cursor:pointer;display:flex;align-items:center;gap:.5rem;">
                    <x-icon name="reply" :size="15" /> Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="wb-admin__main">
        <header class="wb-admin__topbar">
            <button type="button" class="wb-admin__toggle" data-open="admin-menu" aria-label="Open menu">
                <x-icon name="menu" :size="20" />
            </button>
            <h1 class="wb-admin__topbar-title">@yield('page-title', 'Dashboard')</h1>
            <div style="margin-left:auto;display:flex;align-items:center;gap:.6rem;">
                <span style="font-size:.85rem;color:var(--ink-soft);" class="d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                <div style="width:34px;height:34px;border-radius:50%;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;">
                    <x-icon name="user" :size="16" />
                </div>
            </div>
        </header>

        <div class="wb-admin__content">
            @section('content')
            @show
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
