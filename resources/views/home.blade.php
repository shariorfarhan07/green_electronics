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
                    <a href="{{ url('admin') }}" class="wb-btn wb-btn--primary">Go to Admin Panel</a>
                @else
                    <a href="{{ route('homepage') }}" class="wb-btn wb-btn--accent">Continue Shopping</a>
                    <a href="{{ route('WishListProduct') }}" class="wb-btn wb-btn--ghost">My Wishlist</a>
                @endif
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
