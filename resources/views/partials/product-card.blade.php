<div class="wb-card">
    <a href="{{ route('products.show', ['id' => $product->id]) }}" class="wb-card__media">
        <img src="{{ Storage::disk('local')->url('product_images/'.$product->primary_image) }}" alt="{{ $product->name }}" loading="lazy">
    </a>
    <div class="wb-card__actions">
        <a href="{{ auth()->check() ? route('wishlist.add', ['id' => $product->id]) : route('login') }}" class="wb-card__action" title="Wishlist" aria-label="Add to wishlist">
            <x-icon name="heart" :size="15" />
        </a>
        <a href="#" class="wb-card__action" title="Quick View" data-toggle="modal" data-target="#productModal"
           onclick="myFunction('{{ Storage::disk('local')->url('product_images/'.$product->primary_image) }}','{{ addslashes($product->name) }}','{{ $product->price }}','{{ addslashes($product->short_description) }}','{{ $product->stock }}','{{ $product->sold }}','{{ route('cart.add', ['id' => $product->id]) }}')">
            <x-icon name="search" :size="15" />
        </a>
    </div>
    <div class="wb-card__body">
        <span class="wb-card__cat">{{ $product->category->name ?? 'Component' }}</span>
        <a href="{{ route('products.show', ['id' => $product->id]) }}" class="wb-card__title">{{ $product->name }}</a>
        <div class="wb-card__foot">
            <span class="wb-card__price">&#2547;{{ $product->price }}</span>
            <a href="{{ route('cart.add', ['id' => $product->id]) }}" class="wb-card__cart-btn" title="Add to cart" aria-label="Add to cart">
                <x-icon name="cart" :size="16" />
            </a>
        </div>
        <span class="wb-card__stock {{ $product->stock > 0 ? 'wb-card__stock--in' : 'wb-card__stock--out' }}">
            {{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}
        </span>
    </div>
</div>
