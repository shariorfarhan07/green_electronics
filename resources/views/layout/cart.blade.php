
<div class="offsetmenu  ">
    <div class="offsetmenu__inner">
        <div class="offsetmenu__close__btn">
            <a href="#">
                <i class="zmdi zmdi-close"></i>
            </a>
        </div>
        <div class="off__contact">
            <div class="logo" style="padding-top: 30px">
                <a href="{{route('homepage')}}">
                   <h1 style="color: #0b0b0b; top: 50px;">ElectronicsBagBD</h1>
                </a>
            </div>
            <p>Electronics Bag BD is the largest electronics component wholeseller in bangladesh
                & Promises to provide you the best component for you project at lowest price in town</p>
        </div>
        <div class="sidebar__thumd">


        </div>


        <div class="offset__sosial__share">
            <h4 class="offset__title">Follow Us On Social</h4>
            <ul class="off__soaial__link">
                <li>
                    <a class="bg--twitter" href="/commingsoon" title="Twitter">
                        <i class="zmdi zmdi-twitter"></i>
                    </a>
                </li>

                <li>
                    <a class="bg--instagram" href="/commingsoon" title="Instagram">
                        <i class="zmdi zmdi-instagram"></i>
                    </a>
                </li>

                <li>
                    <a class="bg--facebook" href="/commingsoon" title="Facebook">
                        <i class="zmdi zmdi-facebook"></i>
                    </a>
                </li>

                <li>
                    <a class="bg--google" href="/commingsoon" title="youtube">
                        <i class="zmdi zmdi-youtube-play"></i>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>
<!-- End Offset MEnu -->




<!-- Start Cart Panel -->
<div class="shopping__cart">
    <div class="shopping__cart__inner">
        <div class="offsetmenu__close__btn">
            <a href="#">
                <i class="zmdi zmdi-close"></i>
            </a>
        </div>


        <div class="shp__cart__wrap">
            @if ($cartforall!=null)

            @foreach($cartforall-> items as $item)
            <div class="shp__single__product">
                <div class="shp__pro__thumb">
                    <a href="#">
                        <img src="{{Storage::disk('local')->url('product_images/'.$item['data']['image'])  }}" alt="product images">
                    </a>
                </div>
                <div class="shp__pro__details">
                    <h2>
                        <a href="product-details.html"{{$item['data']['name']}}<</a>
                    </h2>
                    <span class="quantity">QTY:{{$item['quantity']}}</span>
                    <span class="shp__price">৳{{$item['price']}}</span>
                </div>
                <div class="remove__btn">
                    <a href="product/{{$item['data']['id']}}/0" title="Remove this item">
                        <i class="zmdi zmdi-close"></i>
                    </a>
                </div>
            </div>
            @endforeach






        </div>
        <ul class="shoping__total">
            <li class="subtotal">total:</li>
            <li class="total__price">{{$cartforall->totalPrice}}</li>
        </ul>
        <ul class="shopping__btn">
            <li>
                <a href="\cart">View Cart</a>
            </li>
            <li class="shp__checkout">
                <a href="{{route('billingdetails')}}">Checkout</a>
            </li>
        </ul>
        @else
        There is nothin in the cart!!
        @endif
    </div>
</div>
<!-- End Cart Panel -->

<!-- End Offset Wrapper -->
</div>
