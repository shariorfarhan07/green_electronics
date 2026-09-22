@extends('layouts.app')

@section('content')
<div class="wb-auth-card">
    <div class="wb-auth-card__logo">
        <div style="width:52px;height:52px;border-radius:50%;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;">
            <x-icon name="lock" :size="24" />
        </div>
    </div>
    <h1 class="wb-auth-card__title">Welcome back</h1>
    <p class="wb-auth-card__sub">Sign in to your Green Electronics account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@example.com">
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <label class="wb-auth-check mb-0">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Remember me') }}
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:.85rem;">{{ __('Forgot password?') }}</a>
            @endif
        </div>

        <button type="submit" class="wb-btn wb-btn--accent wb-btn--block">{{ __('Sign In') }}</button>
    </form>

    <div class="wb-auth-divider">or continue with</div>
    <div class="wb-auth-social">
        <a href="{{ url('login/github') }}" class="wb-btn wb-btn--ghost"><x-icon name="github" :size="16" /> GitHub</a>
        <a href="{{ url('login/google') }}" class="wb-btn wb-btn--ghost">Google</a>
    </div>

    <p class="wb-auth-footer">New here? <a href="{{ route('register') }}">Create an account</a></p>
</div>
@endsection
