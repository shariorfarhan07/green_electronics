@extends('layouts.app')

@section('content')
<div class="wb-auth-card">
    <div class="wb-auth-card__logo">
        <div style="width:52px;height:52px;border-radius:50%;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;">
            <x-icon name="user" :size="24" />
        </div>
    </div>
    <h1 class="wb-auth-card__title">Create your account</h1>
    <p class="wb-auth-card__sub">Join Green Electronics to track orders and save your wishlist</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('Full Name') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Your name">
            @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
        </div>

        <button type="submit" class="wb-btn wb-btn--accent wb-btn--block">{{ __('Create Account') }}</button>
    </form>

    <p class="wb-auth-footer">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
</div>
@endsection
