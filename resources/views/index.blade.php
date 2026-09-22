@extends('layout.app')

@section('content')

<div class="container">
    <div class="wb-hero">
        <div class="wb-hero__inner">
            <span class="wb-hero__eyebrow">Bangladesh's Electronics Component Store</span>
            <h1 class="wb-hero__title">Everything you need to <span>build</span>, from Arduino to CNC.</h1>
            <p class="wb-hero__sub">Genuine development boards, sensors, robotics parts and 3D printing supplies &mdash; shipped nationwide with cash on delivery.</p>
            <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent">Shop All Products <x-icon name="chevron-right" :size="16" /></a>
        </div>
    </div>

    <div class="wb-cat-strip">
        @foreach($navCategories ?? [] as $cat)
            <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="wb-cat-chip">
                <x-icon :name="$cat->icon" :size="26" />
                <span>{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>
</div>

@php
    $railData = [
        ['title' => 'Arduino', 'items' => $products1, 'slug' => 'arduino'],
        ['title' => 'Robotics', 'items' => $products2, 'slug' => 'robotics'],
        ['title' => 'Sensors', 'items' => $products3, 'slug' => 'sensor'],
    ];
@endphp

@foreach($railData as $rail)
@if(count($rail['items']))
<section class="wb-section">
    <div class="container">
        <div class="wb-section__head">
            <h2 class="wb-section__title">{{ $rail['title'] }}</h2>
            <a href="{{ route('shop', ['category' => $rail['slug']]) }}" class="wb-section__link">View All <x-icon name="chevron-right" :size="14" /></a>
        </div>
        <div class="wb-grid--5">
            @foreach($rail['items'] as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif
@endforeach

@if(count($products4))
<section class="wb-section" style="background:var(--paper-alt);">
    <div class="container">
        <div class="wb-section__head">
            <h2 class="wb-section__title">New Arrivals</h2>
        </div>
        <div class="wb-grid--5">
            @foreach($products4 as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

@if(count($products5))
<section class="wb-section">
    <div class="container">
        <div class="wb-section__head">
            <h2 class="wb-section__title">Best Sellers</h2>
        </div>
        <div class="wb-grid--5">
            @foreach($products5 as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!count($products4))
<section class="wb-section">
    <div class="container">
        <div class="wb-empty-state">
            <x-icon name="box" :size="40" />
            <h3>No products yet</h3>
            <p>The catalogue is being stocked &mdash; check back soon, or visit the admin panel to add products.</p>
        </div>
    </div>
</section>
@endif

@endsection
