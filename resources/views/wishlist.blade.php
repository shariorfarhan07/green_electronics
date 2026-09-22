@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Wishlist</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Wishlist</span></nav>
    </div>
</div>

<div class="wb-wishlist">
    <div class="container">
        @if(count($products))
            <div class="table-responsive">
                <table class="wb-line-table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <div class="wb-line__thumb">
                                    <img src="{{ Storage::disk('local')->url('product_images/'.$product->primary_image) }}" alt="{{ $product->name }}">
                                </div>
                            </td>
                            <td><a href="{{ route('productView', ['id' => $product->id]) }}" class="wb-line__name">{{ $product->name }}</a></td>
                            <td class="wb-line__price">&#2547;{{ $product->price }}</td>
                            <td><span class="{{ $product->stock > 0 ? 'wb-card__stock--in' : 'wb-card__stock--out' }}">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</span></td>
                            <td><a href="{{ route('AddToCartProduct', ['id' => $product->id]) }}" class="wb-btn wb-btn--sm wb-btn--accent">Add to Cart</a></td>
                            <td><a href="{{ route('RemoveFromWishListProduct', ['id' => $product->id]) }}" class="wb-line__remove" aria-label="Remove"><x-icon name="trash" :size="17" /></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="wb-empty-state">
                <x-icon name="heart" :size="44" />
                <h3>Your wishlist is empty</h3>
                <p>Save products you like and find them here later.</p>
                <a href="{{ route('searchproduct') }}" class="wb-btn wb-btn--accent">Browse Products</a>
            </div>
        @endif
    </div>
</div>

@endsection
