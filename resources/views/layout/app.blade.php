<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Green Electronics'))</title>
    <meta name="description" content="Green Electronics — Bangladesh's electronics component store for Arduino, sensors, robotics, 3D printing and more.">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="wb-topbar d-none d-md-block">Free delivery inside Dhaka on orders above &#2547;2000 &middot; Cash on delivery available nationwide</div>

<header class="wb-header">
    <div class="wb-header__bar">
        <button type="button" class="wb-mobile-toggle" data-open="menu" aria-label="Open menu">
            <x-icon name="menu" :size="26" />
        </button>

        <a href="{{ url('/') }}" class="wb-logo">Green<span>Electronics</span></a>

        <form class="wb-header__search" action="{{ route('shop') }}" method="get">
            <input type="text" name="searchText" placeholder="Search for Arduino, sensors, modules&hellip;" autocomplete="off">
            <button type="submit" aria-label="Search"><x-icon name="search" /></button>
        </form>

        <div class="wb-header__actions">
            <a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" class="wb-header__action">
                <x-icon name="heart" />
                <span class="wb-header__action-label">Wishlist</span>
            </a>
            <a href="{{ auth()->check() ? route('account') : route('login') }}" class="wb-header__action">
                <x-icon name="user" />
                <span class="wb-header__action-label">{{ auth()->check() ? auth()->user()->name : 'Account' }}</span>
            </a>
            <button type="button" class="wb-header__action" data-open="cart" style="border:none;background:none;">
                <x-icon name="cart" />
                @if($cartforall && $cartforall->totalQuantity > 0)
                    <span class="wb-badge">{{ $cartforall->totalQuantity }}</span>
                @endif
                <span class="wb-header__action-label">Cart</span>
            </button>
        </div>
    </div>

    <nav class="wb-nav">
        <ul class="wb-nav__list">
            <li class="wb-mega">
                <a href="{{ route('shop') }}" class="wb-nav__link wb-nav__categories-btn">
                    <x-icon name="grid" :size="17" /> All Categories
                </a>
                <div class="wb-mega__panel">
                    @foreach($navCategories ?? [] as $cat)
                        <div class="wb-mega__section">
                            <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="wb-mega__item">
                                <x-icon :name="$cat->icon" :size="18" />
                                <span>{{ $cat->name }}</span>
                                @if($cat->children->count())
                                    <x-icon name="chevron-right" :size="14" class="wb-mega__chev" />
                                @endif
                            </a>
                            @if($cat->children->count())
                                <div class="wb-mega__sub">
                                    <div class="wb-mega__sub-head">
                                        <x-icon :name="$cat->icon" :size="18" />
                                        <span>{{ $cat->name }}<small>{{ $cat->blurb }}</small></span>
                                    </div>
                                    <div class="wb-mega__sub-grid">
                                        @foreach($cat->children as $child)
                                            <a href="{{ route('shop', ['category' => $child->slug]) }}" class="wb-mega__sub-link">{{ $child->name }}</a>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="wb-mega__sub-all">View all {{ $cat->name }} <x-icon name="chevron-right" :size="13" /></a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </li>
            <li><a href="{{ url('/') }}" class="wb-nav__link">Home</a></li>
            <li><a href="{{ route('shop') }}" class="wb-nav__link">Shop</a></li>
            <li><a href="{{ url('/about') }}" class="wb-nav__link">About</a></li>
            <li><a href="{{ url('/contact') }}" class="wb-nav__link">Contact</a></li>
        </ul>
    </nav>
</header>

@include('layout.cart')

@yield('content')

<footer class="wb-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <a href="{{ url('/') }}" class="wb-footer__logo">Green<span>Electronics</span></a>
                <div class="wb-footer__addr"><x-icon name="pin" :size="16" /><span>Haji Elias Market, Patuatuli, Dhaka-1100, Bangladesh</span></div>
                <div class="wb-footer__addr"><x-icon name="mail" :size="16" /><span>greenelectronicsbd@gmail.com</span></div>
                <div class="wb-footer__addr"><x-icon name="phone" :size="16" /><span>01912-150390</span></div>
                <div class="wb-footer__social">
                    <a href="#" aria-label="Facebook"><x-icon name="facebook" :size="16" /></a>
                    <a href="#" aria-label="YouTube"><x-icon name="youtube" :size="16" /></a>
                    <a href="#" aria-label="Instagram"><x-icon name="instagram" :size="16" /></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h4>Categories</h4>
                <ul>
                    @foreach(($navCategories ?? collect())->take(6) as $cat)
                        <li><a href="{{ route('shop', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h4>Information</h4>
                <ul>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h4>Why Green Electronics</h4>
                <p style="font-size:.85rem;line-height:1.7;">Bangladesh's electronics component store &mdash; genuine parts for makers, students and engineers at the best price in town.</p>
            </div>
        </div>
        <div class="wb-footer__bottom">&copy; {{ date('Y') }} Green Electronics &mdash; All rights reserved.</div>
    </div>
</footer>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5"><img id="quickview-image" src="" alt="" style="width:100%;object-fit:contain;"></div>
                    <div class="col-md-7">
                        <h4 id="quickview-name"></h4>
                        <p class="wb-pd__price" id="quickview-price"></p>
                        <p id="quickview-desc" class="text-muted" style="font-size:.85rem;"></p>
                        <p style="font-size:.8rem;" class="mono">Stock: <span id="quickview-stock"></span> &middot; Sold: <span id="quickview-sold"></span></p>
                        <div id="quickview-link"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function myFunction(image, name, price, details, stock, sold, link) {
        document.getElementById('quickview-image').src = image;
        document.getElementById('quickview-name').innerHTML = name;
        document.getElementById('quickview-price').innerHTML = '&#2547;' + price;
        document.getElementById('quickview-desc').innerHTML = (details || '').slice(0, 250);
        document.getElementById('quickview-stock').innerHTML = stock;
        document.getElementById('quickview-sold').innerHTML = sold;
        document.getElementById('quickview-link').innerHTML = '<a class="wb-btn wb-btn--accent" href="' + link + '">Add to cart</a>';
    }
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
