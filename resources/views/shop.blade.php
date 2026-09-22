@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">{{ $activeCategory->name ?? (request()->get('searchText') ?: 'Shop All Products') }}</h2>
        <nav class="wb-page-header__crumb">
            <a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Shop</span>
        </nav>
    </div>
</div>

<div class="wb-shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layout.category')
            </div>
            <div class="col-lg-9">
                <div class="wb-toolbar">
                    <span class="wb-toolbar__count">
                        @if($products && $products->total())
                            Showing {{ $products->firstItem() }}&ndash;{{ $products->lastItem() }} of {{ $products->total() }} products
                        @else
                            No products found
                        @endif
                    </span>
                </div>

                @if($products && $products->count())
                    <div class="wb-grid">
                        @foreach ($products as $product)
                            @include('partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="wb-empty-state">
                        <x-icon name="box" :size="44" />
                        <h3>No products found</h3>
                        <p>Try browsing a different category or check back soon.</p>
                        <a href="{{ route('shop') }}" class="wb-btn wb-btn--accent">View All Products</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
