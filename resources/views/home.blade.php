@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">My Account</div>
            <div class="card-body">
                <p class="mono" style="font-size:.9rem;line-height:2;">
                    Name: <strong>{{ Auth::user()->name }}</strong><br>
                    Email: <strong>{{ Auth::user()->email }}</strong>
                </p>
                @if($userdata->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="wb-btn wb-btn--primary">Go to Admin Panel</a>
                @endif
                <a href="{{ route('account.orders.index') }}" class="wb-btn wb-btn--accent">My Orders</a>
                <a href="{{ route('wishlist.index') }}" class="wb-btn wb-btn--ghost">My Wishlist</a>
                <form action="{{ route('logout') }}" method="post" style="display:inline;">
                    @csrf
                    <button type="submit" class="wb-btn wb-btn--ghost">Log out</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif
                <p style="color:var(--ink-soft);margin:0;">You are logged in. Track orders and manage your wishlist from here.</p>
            </div>
        </div>
    </div>
</div>
@endsection
