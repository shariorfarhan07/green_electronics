<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Green Electronics') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wb-auth-shell">
        <nav class="wb-auth-nav">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between" style="padding:1.1rem 0;">
                    <a href="{{ url('/') }}" class="wb-logo">Green<span>Electronics</span></a>
                    <a href="{{ url('/') }}" class="wb-btn wb-btn--ghost wb-btn--sm">
                        <x-icon name="chevron-left" :size="15" /> Back to Shop
                    </a>
                </div>
            </div>
        </nav>

        <main class="wb-auth-main">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
