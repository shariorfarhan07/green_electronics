@extends('layout.app')
@section('content')

@php
    $waLines = ["Hi Green Electronics, I'd like to order:"];
    foreach ($cartforall->items as $item) {
        $waLines[] = "- {$item['data']->name} x{$item['quantity']}";
    }
    $waLines[] = "Total: \u{09F3}" . number_format($cartforall->totalPrice, 2);
    $waMessage = implode("\n", $waLines);
@endphp

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Checkout</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Checkout</span></nav>
    </div>
</div>

<div class="container" style="padding:2.5rem 15px 4rem;">
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="wb-summary" style="text-align:center;padding:2.5rem 1.75rem;">
                <div class="wb-order-closed__icon"><x-icon name="phone" :size="30" /></div>
                <h3 style="margin:1.1rem 0 .5rem;">We're taking orders by phone right now</h3>
                <p style="color:var(--ink-soft);max-width:440px;margin:0 auto 1.75rem;">
                    Online checkout is paused for a moment. Call us or send your order on WhatsApp
                    and our team will confirm it with you directly &mdash; same prices, same delivery.
                </p>
                <div style="display:flex;gap:.85rem;flex-wrap:wrap;justify-content:center;">
                    <a href="tel:{{ config('store.phone') }}" class="wb-btn wb-btn--accent">
                        <x-icon name="phone" :size="16" /> Call {{ config('store.phone_display') }}
                    </a>
                    <a href="https://wa.me/{{ config('store.whatsapp') }}?text={{ urlencode($waMessage) }}" target="_blank" rel="noopener" class="wb-btn wb-btn--primary">
                        <x-icon name="whatsapp" :size="16" /> WhatsApp Your Order
                    </a>
                </div>
                <p style="margin:1.5rem 0 0;font-size:.82rem;color:var(--ink-faint);">
                    Available 10am&ndash;8pm, Saturday to Thursday.
                </p>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="wb-summary" style="position:sticky;top:calc(var(--header-h) + 16px);">
                <div class="wb-summary__title">Your Cart</div>
                <div class="wb-checkout-items mb-3">
                    @foreach($cartforall->items as $item)
                        <div class="wb-checkout-items__row">
                            <div class="wb-checkout-items__thumb">
                                <img src="{{ Storage::disk('local')->url('product_images/'.$item['data']->primary_image) }}" alt="{{ $item['data']->name }}">
                                <span class="wb-checkout-items__qty">{{ $item['quantity'] }}</span>
                            </div>
                            <div class="wb-checkout-items__name">{{ $item['data']->name }}</div>
                            <div class="wb-checkout-items__price">&#2547;{{ $item['price'] * $item['quantity'] }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="wb-summary__row wb-summary__row--total"><span>Subtotal</span><span>&#2547;{{ number_format($cartforall->totalPrice, 2) }}</span></div>
                <p style="margin:.8rem 0 0;font-size:.8rem;color:var(--ink-faint);">Final total includes delivery, confirmed by phone.</p>
            </div>
        </div>
    </div>
</div>

@endsection
