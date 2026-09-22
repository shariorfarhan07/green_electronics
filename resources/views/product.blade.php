@extends('layout.app')
@section('content')

@php
    $images = $product->images->count() ? $product->images : collect();
@endphp

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">{{ $product->name }}</h2>
        <nav class="wb-page-header__crumb">
            <a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span>
            <a href="{{ route('searchproduct') }}" style="color:inherit;">Shop</a> <span class="brd-separetor">/</span>
            <span class="active">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="wb-pd">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="wb-pd__gallery">
                    @if($images->count() > 1)
                    <div class="wb-pd__thumbs">
                        @foreach($images as $i => $img)
                            <div class="wb-pd__thumb {{ $i === 0 ? 'is-active' : '' }}" data-gallery-thumb data-full="{{ Storage::disk('local')->url('product_images/'.$img->path) }}">
                                <img src="{{ Storage::disk('local')->url('product_images/'.$img->path) }}" alt="{{ $product->name }} thumbnail {{ $i + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="wb-pd__main">
                        <img src="{{ Storage::disk('local')->url('product_images/'.$product->primary_image) }}" alt="{{ $product->name }}" data-gallery-main>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <span class="wb-pd__cat">{{ $product->category->name ?? 'Component' }}</span>
                <h1 class="wb-pd__title">{{ $product->name }}</h1>
                <div class="wb-pd__meta">
                    <span class="{{ $product->stock > 0 ? 'wb-card__stock--in' : 'wb-card__stock--out' }}">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</span>
                    <span>Stock: {{ $product->stock }}</span>
                    <span>Sold: {{ $product->sold }}</span>
                    @if($product->brand)<span>Brand: {{ $product->brand }}</span>@endif
                </div>
                <div class="wb-pd__price">&#2547;{{ $product->price }}</div>
                @if($product->short_description)
                    <p class="wb-pd__desc">{{ $product->short_description }}</p>
                @endif

                <label class="mono" style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.5rem;">Quantity</label>
                <div class="wb-qty" data-qty data-min="1">
                    <button type="button" data-step="-1" aria-label="Decrease"><x-icon name="minus" :size="15" /></button>
                    <input type="text" value="1" readonly>
                    <button type="button" data-step="1" aria-label="Increase"><x-icon name="plus" :size="15" /></button>
                </div>

                <div class="wb-pd__actions">
                    <a href="{{ route('AddToCartProduct', ['id' => $product->id]) }}" class="wb-btn wb-btn--primary">
                        <x-icon name="cart" :size="17" /> Add to Cart
                    </a>
                    <a href="{{ auth()->check() ? route('AddToWishListProduct', ['id' => $product->id]) : route('login') }}" class="wb-btn wb-btn--ghost">
                        <x-icon name="heart" :size="17" /> Wishlist
                    </a>
                </div>

                <div class="wb-trust">
                    <div class="wb-trust__item"><x-icon name="truck" :size="18" /> Nationwide delivery</div>
                    <div class="wb-trust__item"><x-icon name="shield" :size="18" /> Genuine parts</div>
                    <div class="wb-trust__item"><x-icon name="whatsapp" :size="18" /> Cash on delivery</div>
                </div>
            </div>
        </div>

        <div class="wb-tabs" data-tabs>
            <div class="wb-tabs__nav">
                <button type="button" class="wb-tabs__btn is-active" data-tab-btn="description">Description</button>
                <button type="button" class="wb-tabs__btn" data-tab-btn="datasheet">Specifications</button>
            </div>
            <div class="wb-tabs__panel is-active" data-tab-panel="description">{{ $product->description ?: 'No description provided yet.' }}</div>
            <div class="wb-tabs__panel" data-tab-panel="datasheet">{{ $product->specifications ?: 'No specifications provided yet.' }}</div>
        </div>
    </div>
</div>

@endsection
