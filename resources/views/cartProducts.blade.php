@extends('layout.app')

@section('content')
<!-- End Header Style -->
<script type="text/javascript">
    function changeText() {
        document.getElementById("shipping_method").innerHTML = '<Strong>৳60</Strong>';
        document.getElementById("totalc").innerHTML = {{ $cartItems ->totalPrice  }}+60;
        document.getElementById("outSideDhakatext").innerHTML ='';
    }
    function changeTextOutside() {
        document.getElementById("shipping_method").innerHTML = '<Strong>৳100</Strong>';
        document.getElementById("totalc").innerHTML = ({{ $cartItems ->totalPrice  }}+100)*(1+0.018);
        document.getElementById("outSideDhakatext").innerHTML = 'Please complete your bKash payment at first, then fill up the form below.Also <br>note that 1.85% bKash "SEND MONEY" cost will be added with net price.<br> Total amount you need to send us at ৳ 153.00';
        document.getElementById("outSideDhakatext").style.color='red';
    }
</script>

<div class="body__overlay"></div>
<!-- Start Offset Wrapper -->
<div class="offset__wrapper">
    <!-- Start Search Popap -->
    <div class="search__area">
        <div class="container" >
            <div class="row" >
                <div class="col-md-12" >
                    <div class="search__inner">
                        <form action="#" method="get">
                            <input placeholder="Search here... " type="text">
                            <button type="submit"></button>
                        </form>
                        <div class="search__close__btn">
                            <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @foreach($cartItems-> items as $item)
    @endforeach
    <!-- End Search Popap -->
    <!-- Start Offset MEnu -->
    @include('layout.cart')
<!-- End Offset Wrapper -->
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url('images/bg/2.jpg') no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Cart</h2>
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="/">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb-item active">Cart</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="cart-main-area ptb--120 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($cartItems-> items as $item)

                            <tr>
                                <td class="product-thumbnail"><a href="#"><img src="{{Storage::disk('local')->url('product_images/'.$item['data']['image'])  }}" alt="product img" /></a></td>
                                <td class="product-name"><a href="#">{{$item['data']['Name']}}</a></td>
                                <td class="product-price" ><span class="amount">৳{{$item['price']}}</span></td>
                                <td class="product-quantity"style="font-size:25px;"><a href="product/{{$item['data']['id']}}/{{$item['quantity']-1}}">- </a>{{$item['quantity']}}<a href="product/{{$item['data']['id']}}/{{$item['quantity']+1}}"> +</a></td>
                                <td class="product-subtotal">৳{{$item['price']*$item['quantity']}}</td>
                                <td class="product-remove"><a href="product/{{$item['data']['id']}}/0">X</a></td>
                            </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>



                    <div class="row">
                        <div class="col-md-8 col-sm-7 col-xs-12">
                            <ul class="shippingBD">

                                <li> <input type="radio" id="shipping" onclick="changeText()" name="shippingmethod" value="InsideDhaka" />
                                    Inside Dhaka city Charge 60 taka.
                                </li>
                                <li> <input type="radio"id="shipping" onclick="changeTextOutside()"  name="shippingmethod" value="OutsideDhaka" /> Outside Dhaka city Charge 100 taka by sundorban courier service.</li>
                                <div id="outSideDhakatext">

                                </div>
                            </ul>
                            <!--
                            <div class="coupon">
                                <h3>Coupon</h3>
                                <p>Enter your coupon code if you have one.</p>
                                <input type="text" placeholder="Coupon code" />
                                <input type="submit" value="Apply Coupon" />
                            </div>-->
                        </div>
                        <div class="col-md-4 col-sm-5 col-xs-12">
                            <div class="cart_totals ">
                                <h2>Cart Totals</h2>
                                <table class="container">
                                    <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span class="amount">৳{{ $cartItems->totalPrice  }}</span></td>
                                    </tr>
                                    <tr  >
                                        <th>Shipping</th>
                                        <td id="shipping_method">
                                            select shipping
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td>
                                            <strong><span class="amount" id="totalc"> select shipping</span></strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="wc-proceed-to-checkout">
                                    <a href="{{route('billingdetails')}}">Complete Shipping Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cart-main-area end -->

@endsection







