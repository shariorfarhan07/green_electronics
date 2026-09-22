@extends('layout.app')
@section('content')

<div class="wb-page-header">
    <div class="container">
        <h2 class="wb-page-header__title">Checkout</h2>
        <nav class="wb-page-header__crumb"><a href="{{ url('/') }}" style="color:inherit;">Home</a> <span class="brd-separetor">/</span> <span class="active">Checkout</span></nav>
    </div>
</div>

<div class="wb-checkout">
    <div class="container">
        <form action="{{ route('billingconfirm') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="wb-summary mb-4">
                        <div class="wb-summary__title">Contact Details</div>
                        <div class="row">
                            <div class="col-md-6 wb-field">
                                <label>First name <span class="required">*</span></label>
                                <input type="text" name="firstname" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col-md-6 wb-field">
                                <label>Last name <span class="required">*</span></label>
                                <input type="text" name="lastname" class="form-control" placeholder="Last name" required>
                            </div>
                            <div class="col-md-6 wb-field">
                                <label>Phone <span class="required">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="017XXXXXXXX" required>
                            </div>
                            <div class="col-md-6 wb-field">
                                <label>Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="wb-summary mb-4">
                        <div class="wb-summary__title">Shipping Address</div>
                        <div class="wb-field">
                            <label>Address <span class="required">*</span></label>
                            <input type="text" name="address" class="form-control" placeholder="House number and street name" required>
                        </div>
                        <div class="wb-field">
                            <label>Apartment / suite (optional)</label>
                            <input type="text" name="flat" class="form-control" placeholder="Apartment, suite, unit, etc.">
                        </div>
                        <div class="row">
                            <div class="col-md-4 wb-field">
                                <label>City <span class="required">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-4 wb-field">
                                <label>Division <span class="required">*</span></label>
                                <select name="division" id="wb-division" class="form-control" onchange="wbUpdateShipping()" required>
                                    <option value="Dhaka" selected>Dhaka</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Chittagong">Chittagong</option>
                                </select>
                            </div>
                            <div class="col-md-4 wb-field">
                                <label>Zip <span class="required">*</span></label>
                                <input type="text" name="zip" class="form-control" required>
                            </div>
                        </div>
                        <p class="mono" style="font-size:.8rem;color:var(--ink-soft);">Country: <strong>Bangladesh</strong></p>
                    </div>

                    <div class="wb-summary">
                        <div class="wb-summary__title">Payment Method</div>
                        <label class="wb-payment-option d-block">
                            <div class="wb-payment-option__head">
                                <input type="radio" name="paymentmethod" value="cash on delivery" checked onchange="wbTogglePayment()"> Cash on Delivery
                            </div>
                            <div class="wb-payment-option__body">Pay with cash at the time of delivery.</div>
                        </label>
                        <label class="wb-payment-option d-block">
                            <div class="wb-payment-option__head">
                                <input type="radio" name="paymentmethod" value="bkash" onchange="wbTogglePayment()"> Pay with bKash
                            </div>
                            <div class="wb-payment-option__body">
                                Send payment first, then fill in the details below. A 1.85% bKash "Send Money" fee applies.<br>
                                bKash Personal Number: <strong>019XXXXXXXX</strong> or <strong>016XXXXXXXXXX</strong>
                                <div class="wb-field mt-3">
                                    <label>Your bKash Number</label>
                                    <input type="text" name="paymentnumber" class="form-control" placeholder="017XXXXXXXX">
                                </div>
                                <div class="wb-field">
                                    <label>bKash Transaction ID</label>
                                    <input type="text" name="txid" class="form-control" placeholder="f5df4g9h8ryt9g6">
                                </div>
                            </div>
                        </label>
                        <div class="wb-note-bn">আপনার অবগতির জন্য জানানো যাচ্ছে যে ঢাকা শহরের বাহিরে যেকোনো অর্ডার এর জন্য পূর্বে বিকাশ পেমেন্ট করতে হবে।</div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="wb-summary" style="position:sticky;top:calc(var(--header-h) + 16px);">
                        <div class="wb-summary__title">Order Summary</div>
                        <div class="wb-summary__row"><span>Subtotal</span><span>&#2547;{{ $cartforall->totalPrice }}</span></div>
                        <div class="wb-summary__row"><span>Shipping</span><span id="wb-co-shipping">&#2547;60</span></div>
                        <div class="wb-summary__row wb-summary__row--total"><span>Total</span><span id="wb-co-total">&#2547;{{ $cartforall->totalPrice + 60 }}</span></div>
                        <button type="submit" class="wb-btn wb-btn--accent wb-btn--block mt-3">Confirm Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var wbSubtotal = {{ $cartforall->totalPrice }};
    function wbUpdateShipping() {
        var division = document.getElementById('wb-division').value;
        var shipping = division === 'Dhaka' ? 60 : 100;
        document.getElementById('wb-co-shipping').innerHTML = '&#2547;' + shipping;
        document.getElementById('wb-co-total').innerHTML = '&#2547;' + (wbSubtotal + shipping);
    }
    function wbTogglePayment() {}
</script>

@endsection
