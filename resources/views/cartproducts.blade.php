@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Your Cart</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Cart</span></nav>
    </div>
</div>

<div class="wb-cart">
    <div class="container">
        <div class="table-responsive mb-4">
            <table class="wb-line-table">
                <thead>
                <tr>
                    <th></th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems->items as $item)
                    <tr>
                        <td>
                            <div class="wb-line__thumb">
                                <img src="{{ Storage::disk('local')->url('product_images/'.$item['data']->primary_image) }}" alt="{{ $item['data']->name }}">
                            </div>
                        </td>
                        <td><a href="{{ route('productView', ['id' => $item['data']->id]) }}" class="wb-line__name">{{ $item['data']->name }}</a></td>
                        <td class="wb-line__price">&#2547;{{ $item['price'] }}</td>
                        <td>
                            <div class="wb-qty" data-qty data-min="0" data-href-base="{{ url('product/'.$item['data']->id.'/') }}/">
                                <button type="button" data-step="-1" aria-label="Decrease"><x-icon name="minus" :size="14" /></button>
                                <input type="text" value="{{ $item['quantity'] }}" readonly>
                                <button type="button" data-step="1" aria-label="Increase"><x-icon name="plus" :size="14" /></button>
                            </div>
                        </td>
                        <td class="wb-line__price">&#2547;{{ $item['price'] * $item['quantity'] }}</td>
                        <td><a href="{{ route('adjustCart', ['id' => $item['data']->id, 'number' => 0]) }}" class="wb-line__remove" aria-label="Remove"><x-icon name="trash" :size="17" /></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-7 mb-4">
                <div class="wb-summary">
                    <div class="wb-summary__title">Shipping</div>
                    <label class="wb-shipping-option">
                        <input type="radio" name="shippingmethod" value="60" onclick="wbUpdateShipping(60)"> Inside Dhaka city &mdash; &#2547;60
                    </label>
                    <label class="wb-shipping-option">
                        <input type="radio" name="shippingmethod" value="100" onclick="wbUpdateShipping(100)"> Outside Dhaka city (Sundarban courier) &mdash; &#2547;100
                    </label>
                </div>
            </div>
            <div class="col-md-5">
                <div class="wb-summary">
                    <div class="wb-summary__title">Cart Totals</div>
                    <div class="wb-summary__row"><span>Subtotal</span><span id="wb-subtotal">&#2547;{{ $cartItems->totalPrice }}</span></div>
                    <div class="wb-summary__row"><span>Shipping</span><span id="wb-shipping">Select shipping</span></div>
                    <div class="wb-summary__row wb-summary__row--total"><span>Total</span><span id="wb-total">&#2547;{{ $cartItems->totalPrice }}</span></div>
                    <a href="{{ route('billingdetails') }}" class="wb-btn wb-btn--accent wb-btn--block mt-3">Proceed to Checkout <x-icon name="chevron-right" :size="16" /></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var wbSubtotal = {{ $cartItems->totalPrice }};
    function wbUpdateShipping(cost) {
        document.getElementById('wb-shipping').innerHTML = '&#2547;' + cost;
        document.getElementById('wb-total').innerHTML = '&#2547;' + (wbSubtotal + cost);
    }
</script>

@endsection
