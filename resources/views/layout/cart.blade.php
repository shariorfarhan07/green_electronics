{{-- Mobile off-canvas menu --}}
<div class="wb-offcanvas__backdrop" id="wb-menu-backdrop"></div>
<div class="wb-offcanvas" id="wb-menu">
    <div class="wb-offcanvas__head">
        <span>Menu</span>
        <button type="button" class="wb-offcanvas__close" data-close aria-label="Close menu"><x-icon name="close" /></button>
    </div>
    <div class="wb-offcanvas__body">
        <nav>
            <a href="{{ url('/') }}"><span>Home</span> <x-icon name="chevron-right" :size="16" /></a>
            <a href="{{ route('shop') }}"><span>Shop All</span> <x-icon name="chevron-right" :size="16" /></a>
            <a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}"><span>Wishlist</span> <x-icon name="chevron-right" :size="16" /></a>
            <a href="{{ url('/about') }}"><span>About</span> <x-icon name="chevron-right" :size="16" /></a>
            <a href="{{ url('/contact') }}"><span>Contact</span> <x-icon name="chevron-right" :size="16" /></a>
        </nav>
        <div style="margin-top:1rem;">
            <h6 class="mono" style="text-transform:uppercase;font-size:.72rem;letter-spacing:.05em;color:var(--ink-faint);margin:1rem 0 .25rem;">Categories</h6>
            @foreach($navCategories ?? [] as $cat)
                <details class="wb-offcanvas__cat-group">
                    <summary>
                        <span style="display:flex;align-items:center;gap:.5rem;"><x-icon :name="$cat->icon" :size="17" /> {{ $cat->name }}</span>
                        <x-icon name="chevron-down" :size="16" />
                    </summary>
                    <ul>
                        <li><a href="{{ route('shop', ['category' => $cat->slug]) }}">Browse all {{ $cat->name }}</a></li>
                    </ul>
                </details>
            @endforeach
        </div>
    </div>
</div>

{{-- Mini cart drawer --}}
<div class="wb-offcanvas__backdrop" id="wb-cart-backdrop"></div>
<div class="wb-offcanvas wb-offcanvas--right" id="wb-cart-drawer">
    <div class="wb-offcanvas__head">
        <span>Your Cart @if($cartforall && $cartforall->totalQuantity)({{ $cartforall->totalQuantity }})@endif</span>
        <button type="button" class="wb-offcanvas__close" data-close aria-label="Close cart"><x-icon name="close" /></button>
    </div>
    <div class="wb-offcanvas__body" style="display:flex;flex-direction:column;">
        @if($cartforall && count($cartforall->items) > 0)
            <div style="flex:1;overflow-y:auto;">
                @foreach($cartforall->items as $item)
                    <div class="wb-cart-drawer__item">
                        <div class="wb-cart-drawer__thumb">
                            <img src="{{ Storage::disk('local')->url('product_images/'.$item['data']->primary_image) }}" alt="{{ $item['data']->name }}">
                        </div>
                        <div class="wb-cart-drawer__info">
                            <h6>{{ $item['data']->name }}</h6>
                            <span class="mono" style="font-size:.78rem;color:var(--ink-soft);">Qty: {{ $item['quantity'] }}</span>
                            <div class="wb-cart-drawer__price">&#2547;{{ $item['price'] }}</div>
                        </div>
                        <a href="{{ route('cart.update', ['id' => $item['data']->id, 'number' => 0]) }}" class="wb-cart-drawer__remove" aria-label="Remove"><x-icon name="close" :size="16" /></a>
                    </div>
                @endforeach
            </div>
            <div class="wb-cart-drawer__foot">
                <div class="wb-cart-drawer__total"><span>Subtotal</span><span>&#2547;{{ $cartforall->totalPrice }}</span></div>
                <a href="{{ route('cart.index') }}" class="wb-btn wb-btn--ghost wb-btn--block mb-2">View Cart</a>
                <a href="{{ route('checkout.index') }}" class="wb-btn wb-btn--accent wb-btn--block">Checkout</a>
            </div>
        @else
            <div class="wb-empty-state" style="padding:3rem 1rem;">
                <x-icon name="cart" :size="40" />
                <p>Your cart is empty.</p>
                <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
