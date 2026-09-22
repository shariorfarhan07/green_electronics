
@extends('layout.app')
@section('content')

<div id="hide1" class="solution">
    <!-- solution-->

    <div class="body__overlay "></div>
    <!-- Start Offset Wrapper -->
    <div class="offset__wrapper">
        <!-- Start Search Popap -->
        <div class="search__area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search__inner">
                            <form action="{{route('searchproduct')}}" method="get">
                                <input name="searchText" placeholder="Search here... " type="text">
                                <button type="submit"></button>
                            </form>
                            <div class="search__close__btn">
                                        <span class="search__close__btn_icon">
                                            <i class="zmdi zmdi-close"></i>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Popap -->
        <!-- Start Offset MEnu -->















        <!-- Start Cart Panel -->
        @include('layout.cart')

        <!-- End Cart Panel -->

    <!-- End Offset Wrapper -->
















        <!-- looking for this  -->








    <!-- Start Feature Product -->
    <section class="categories-slider-area bg__white">






        <div class="container2 ">
            <!-- found1-->
            <div class="row">








                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 float-right-style hider">
                   @include('layout.category')
                </div>
                <!-- End Left Feature -->










                <!-- Start Left Feature -->
                <div class="col-md-7 col-lg-7 col-sm-12 col-xs-7 float-right-style slidercenter ">
                    <!-- Start Slider Area -->
                    <div class="slider__container slider--one  ">
                        <div class="slider__activation__wrap owl-carousel owl-theme ">
                            <!-- Start Single Slide -->
                            <div
                                class="slide slider__full--screen slider-height-inherit slider-text-right "
                                style="background: rgba(0, 0, 0, 0) url(banner.png) no-repeat scroll center center / cover ;">
                                <div class="container centerSlider">
                                    <div class="row">
                                        <div   class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                            <div class="slider__inner">
                                                <h1>New Product
                                                    <span class="text--theme">Collection</span></h1>
                                                <div class="slider__btn">
                                                    <a class="htc__btn" href="cart.html">shop now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Slide -->
                            <!-- Start Single Slide -->
                            <div class="slide slider__full--screen slider-height-inherit  slider-text-left"
                                 style="background: rgba(0, 0, 0, 0) url(maxresdefault.jpg) no-repeat scroll center center / cover ;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                            <div class="slider__inner">
                                                <h1>New Product
                                                    <span class="text--theme">Collection</span></h1>
                                                <div class="slider__btn">
                                                    <a class="htc__btn" href="cart.html">shop now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Slide -->
                        </div>
                    </div>

                    <!-- Start Slider Area -->
                </div>

                <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 hider float-right-style">

                    <div class="sideAdd downBorder">Ad 1</div>

                    <div class="sideAdd downBorder">Ad 2</div>

                    <div class="sideAdd">Add 3</div>

                </div>








            </div>
        </div>


    </section>


    <section class="bg__white">
        <div class="brand">
            <div class="owl-carousel owl-theme">
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(1).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(2).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(3).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(4).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(5).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(6).png" alt="brand"></a></div>
                <!-- <div class="itemf"><a href="#"><img class="itemf" src="images\brandlogo\brand(7).png" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img src="\images\brandlogo\brand(8)" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img src="\images\brandlogo\brand(9)" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img src="\images\brandlogo\brand(10)" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img src="\images\brandlogo\brand(1)" alt="brand"></a></div>
                <div class="itemf"><a href="#"><img src="\images\brandlogo\brand(1)" alt="brand"></a></div>
            -->
            </div>
        </div>
    </section>



<!-- Start Our Product Area -->
<section class="htc__product__area pb--50 bg__white">
    <div class="container container1">
        <div class="row">
            <div class="col-md-2">
                <div class="product-categories-all">
                    <div class="product-categories-title ">
                        <h3>Development Boards</h3>
                    </div>
                    <div class="product-categories-menu">
                        <ul>
                            <li>
                                <a href="#">Arduino</a>
                            </li>
                            <li>
                                <a href="#">Arduino shield</a>
                            </li>

                            <li>
                                <a href="#">Raspberry pi </a>
                            </li>
                            <li>
                                <a href="#">Raspberry pi accessories</a>
                            </li>

                            <li>
                                <a href="#">Esp-ressif</a>
                            </li>
                            <li>
                                <a href="#">STM32</a>
                            </li>
                            <li>
                                <a href="#">PIC</a>
                            </li>

                            <li>
                                <a href="#">Sensors</a>
                            </li>
                            <li>
                                <a href="#">USB to serial converter</a>
                            </li>
                            <li>
                                <a href="#">Starter Kit</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="product-style-tab">
                    <div class="product-tab-list">
                        <!-- Nav tabs -->
                        <ul class="tab-style" role="tablist">
                            <li class="active">
                                <a href="#home5" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>latest
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>best sale
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>view all
                                        </h4>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="tab-content another-product-style jump">
                        <div class="tab-pane active" id="home5">
                            <div class="row">
                                <div class="product-slider-active owl-carousel">
                                    @foreach ($products1  as $product)

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6 ">
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb" >
                                                    <a href="#">
                                                        <img class="img-rounded" " src="{{Storage::disk('local')->url('product_images/'.$product->image)  }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                onclick="myFunction('{{Storage::disk("local")->url('product_images/'.$product->image)}}'
                                                            ,' {{ $product-> Name }}','{{ $product->price }}','{{ $product->sdescription }}',
                                                            '{{ $product->stock }}','{{ $product->sold }}',
                                                            '{{route('AddToCartProduct',['id'=>$product->id])}}')">
                                                            <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="{{route('AddToCartProduct',['id'=>$product->id])}}">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="{{route('AddToWishListProduct',['id'=>$product->id])}}">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">{{ $product-> Name }}</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="new__price">৳{{ $product->price }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="home6">
                            <div class="row">
                                <div class="product-slider-active owl-carousel">
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/4.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/5.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/6.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/7.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/8.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/9.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="home7">
                            <div class="row">
                                <div class="product-slider-active owl-carousel">
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/2.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/1.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/5.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/4.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/3.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/7.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="home8">
                            <div class="row">
                                <div class="product-slider-active owl-carousel">
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/9.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/5.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/3.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/4.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/2.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-6 col-xs-6"  >
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="images/product/7.png" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                href="#">
                                                                <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="cart.html">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="wishlist.html">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">Simple Black Clock</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="old__price">৳16.00</li>
                                                    <li class="new__price">৳10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>










<!-- Start Our Product Area -->
<section class="htc__product__area pb--50 bg__white">
    <div class="container container1">
        <div class="row">
            <div class="col-md-2">
                <div class="product-categories-all">
                    <div class="product-categories-title ">
                        <h3>RC & Drone</h3>
                    </div>
                    <div class="product-categories-menu">
                        <ul>
                            <li>
                                <a href="#">Ready to Fly Drone</a>
                            </li>
                            <li>
                                <a href="#">FPV & Drone Camera</a>
                            </li>
                            <li>
                                <a href="#">Transmitter & Receiver</a>
                            </li>
                            <li>
                                <a href="#">Flight Controllers</a>
                            </li>
                            <li>
                                <a href="#">lipo Battery</a>
                            </li>
                            <li>
                                <a href="#">Motor</a>
                            </li>
                            <li>
                                <a href="#">ESC</a>
                            </li>
                            <li>
                                <a href="#">Frame</a>
                            </li>
                            <li>
                                <a href="#">Charger</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="product-style-tab">
                    <div class="product-tab-list">
                        <!-- Nav tabs -->
                        <ul class="tab-style" role="tablist">
                            <li class="active">
                                <a href="#home5" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>latest
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>best sale
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>view all
                                        </h4>
                                    </div>
                                </a>
                            </li>


                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>

</section>

<!-- End Our Product Area -->








<!-- Start Our Product Area -->
<section class="htc__product__area pb--50 bg__white">
    <div class="container container1">
        <div class="row">
            <div class="col-md-2">
                <div class="product-categories-all">
                    <div class="product-categories-title ">
                        <h3>CNC & 3D Printers</h3>
                    </div>
                    <div class="product-categories-menu">
                        <ul>
                            <li>
                                <a href="#">CNC</a>
                            </li>
                            <li>
                                <a href="#">3D Printer</a>
                            </li>
                            <li>
                                <a href="#">Controller Boards</a>
                            </li>
                            <li>
                                <a href="#">3D Printer Filament</a>
                            </li>
                            <li>
                                <a href="#">Linear Guide</a>
                            </li>
                            <li>
                                <a href="#">Extruder</a>
                            </li>
                            <li>
                                <a href="#">Bearing</a>
                            </li>
                            <li>
                                <a href="#">Mechanical parts</a>
                            </li>
                            <li>
                                <a href="#">3D printed parts</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="product-style-tab">
                    <div class="product-tab-list">
                        <!-- Nav tabs -->
                        <ul class="tab-style" role="tablist">
                            <li class="active">
                                <a href="#home5" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>latest
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>best sale
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home6" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>view all
                                        </h4>
                                    </div>
                                </a>
                            </li>


                        </ul>
                    </div>

                    <div class="tab-content another-product-style jump">
                        <div class="tab-pane active" id="home5">
                            <div class="row">
                                <div class="product-slider-active owl-carousel">


                                    @foreach ($products3  as $product)

                                    <div class="col-md-4 single__pro col-lg-2 cat--1 col-sm-6 col-xs-6 ">
                                        <div class="product">
                                            <div class="product__inner">
                                                <div class="pro__thumb" >
                                                    <a href="#">
                                                        <img class="img-rounded" " src="{{Storage::disk('local')->url('product_images/'.$product->image)  }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action">
                                                        <li>
                                                            <a
                                                                data-toggle="modal"
                                                                data-target="#productModal"
                                                                title="Quick View"
                                                                class="quick-view modal-view detail-link"
                                                                onclick="myFunction('{{Storage::disk("local")->url('product_images/'.$product->image)}}'
                                                            ,' {{ $product-> Name }}','{{ $product->price }}','{{ $product->sdescription }}',
                                                            '{{ $product->stock }}','{{ $product->sold }}',
                                                            '{{route('AddToCartProduct',['id'=>$product->id])}}')">
                                                            <span class="ti-plus"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Add TO Cart" href="{{route('AddToCartProduct',['id'=>$product->id])}}">
                                                                <span class="ti-shopping-cart"></span></a>
                                                        </li>
                                                        <li>
                                                            <a title="Wishlist" href="{{route('AddToWishListProduct',['id'=>$product->id])}}">
                                                                <span class="ti-heart"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2>
                                                    <a href="product-details.html">{{ $product-> Name }}</a>
                                                </h2>
                                                <ul class="product__price">
                                                    <li class="new__price">৳{{ $product->price }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Our Product Area -->

<!-- Start Our Product Area <section class="htc__product__area ptb--50
            bg__white"> <div class="container"> <div class="row"> <div class="col-md-3">
            <div class="product-categories-all"> <div class="product-categories-title">
            <h3>Electronics components</h3> </div> <div class="product-categories-menu">
            <ul> <li><a href="#">arduino 2</a></li> <li><a href="#">arduino 3</a></li>
            <li><a href="#">arduino 4</a></li> <li><a href="#">arduino 5</a></li> <li><a
            href="#">arduino 6</a></li> <li><a href="#">arduino 1</a></li> <li><a
            href="#">arduino7</a></li> <li><a href="#">arduino 8</a></li> <li><a
            href="#">arduino 9</a></li> </ul> </div> </div> </div> col-md-9 -->
<section class="bg__white">
    <div class="container-fluid">
        <div class="product-style-tab1">
            <div class="product-tab-list">
                <!-- Nav tabs -->
                <ul class="tab-style product-tab-list-btn" role="tablist">
                    <li class="active">
                        <a href="#home9" data-toggle="tab">
                            <div class="tab-menu-text">
                                <h4>latest
                                </h4>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#home10" data-toggle="tab">
                            <div class="tab-menu-text">
                                <h4>best sale
                                </h4>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#home11" data-toggle="tab">
                            <div class="tab-menu-text">
                                <h4>top rated</h4>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#home12" data-toggle="tab">
                            <div class="tab-menu-text">
                                <h4>on sale</h4>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="all-product-btn ">
                    <a href="shop-sidebar.html">all</a>
                </div>
            </div>
        </div>






        <div class="tab-content another-product-style  pb--50">
            <div class="tab-pane active" id="home9">

                <div class="row">

                    <!--product start-->

                    <div class="product-slider-active2">


                        @foreach ($products4  as $product)

                        <div class="col-md-4 single__pro col-lg-2 cat--1 col-sm-6 col-xs-6 ">
                            <div class="product">
                                <div class="product__inner">
                                    <div class="pro__thumb" >
                                        <a href="#">
                                            <img class="img-rounded" " src="{{Storage::disk('local')->url('product_images/'.$product->image)  }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="product__hover__info">
                                        <ul class="product__action">
                                            <li>
                                                <a
                                                    data-toggle="modal"
                                                    data-target="#productModal"
                                                    title="Quick View"
                                                    class="quick-view modal-view detail-link"
                                                    onclick="myFunction('{{Storage::disk("local")->url('product_images/'.$product->image)}}'
                                                ,' {{ $product-> Name }}','{{ $product->price }}','{{ $product->sdescription }}',
                                                '{{ $product->stock }}','{{ $product->sold }}',
                                                '{{route('AddToCartProduct',['id'=>$product->id])}}')">
                                                <span class="ti-plus"></span></a>
                                            </li>
                                            <li>
                                                <a title="Add TO Cart" href="{{route('AddToCartProduct',['id'=>$product->id])}}">
                                                    <span class="ti-shopping-cart"></span></a>
                                            </li>
                                            <li>
                                                <a title="Wishlist" href="{{route('AddToWishListProduct',['id'=>$product->id])}}">
                                                    <span class="ti-heart"></span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product__details">
                                    <h2>
                                        <a href="product-details.html">{{ $product-> Name }}</a>
                                    </h2>
                                    <ul class="product__price">
                                        <li class="new__price">৳{{ $product->price }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


        <section class="bg__white">
            <div class="container-fluid">
                <div class="product-style-tab1">
                    <div class="product-tab-list">
                        <!-- Nav tabs -->
                        <ul class="tab-style product-tab-list-btn" role="tablist">
                            <li class="active">
                                <a href="#home9" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>latest
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home10" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>best sale
                                        </h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home11" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>top rated</h4>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#home12" data-toggle="tab">
                                    <div class="tab-menu-text">
                                        <h4>on sale</h4>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="all-product-btn ">
                            <a href="shop-sidebar.html">all</a>
                        </div>
                    </div>
                </div>






                <div class="tab-content another-product-style  pb--50">
                    <div class="tab-pane active" id="home9">

                        <div class="row">

                            <!--product start-->

                            <div class="product-slider-active2">


                                @foreach ($products5  as $product)

                                <div class="col-md-4 single__pro col-lg-2 cat--1 col-sm-6 col-xs-6  ">
                                    <div class="product">
                                        <div class="product__inner">
                                            <div class="pro__thumb" >
                                                <a href="#">
                                                    <img class="img-rounded" " src="{{Storage::disk('local')->url('product_images/'.$product->image)  }}" alt="product images">
                                                </a>
                                            </div>
                                            <div class="product__hover__info">
                                                <ul class="product__action">
                                                    <li>
                                                        <a
                                                            data-toggle="modal"
                                                            data-target="#productModal"
                                                            title="Quick View"
                                                            class="quick-view modal-view detail-link"
                                                            onclick="myFunction('{{Storage::disk("local")->url('product_images/'.$product->image)}}'
                                                        ,' {{ $product-> Name }}','{{ $product->price }}','{{ $product->sdescription }}',
                                                        '{{ $product->stock }}','{{ $product->sold }}',
                                                        '{{route('AddToCartProduct',['id'=>$product->id])}}')">
                                                        <span class="ti-plus"></span></a>
                                                    </li>
                                                    <li>
                                                        <a title="Add TO Cart" href="{{route('AddToCartProduct',['id'=>$product->id])}}">
                                                            <span class="ti-shopping-cart"></span></a>
                                                    </li>
                                                    <li>
                                                        <a title="Wishlist" href="{{route('AddToWishListProduct',['id'=>$product->id])}}">
                                                            <span class="ti-heart"></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product__details">
                                            <h2>
                                                <a href="product-details.html">{{ $product-> Name }}</a>
                                            </h2>
                                            <ul class="product__price">
                                                <li class="new__price">৳{{ $product->price }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- End Our Product Area -->
<!-- Start Blog Area -->
<div id="hide2">

    <section class="htc__blog__area bg__white pb--130 ">

        <div class="container container1 ">
            <div class="row">
                <div class="col-xs-12">
                    <div class="section__title section__title--2 text-center">
                        <h2 class="title__line">Coming soon!!!
                        </h2>
                        <p>We are plaining to bring this upcoming services!
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog__wrap clearfix mt--60 xmt-30">
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="blog foo">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="pcb.jpg" alt="blog images">
                                    </a>

                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <p class="blog__des">
                                            <a href="blog-details.html">Lorem ipsum dolor sit consectetu.</a>
                                        </p>
                                        <ul class="bl__meta">
                                            <li>By :<a href="#">Admin</a>
                                            </li>
                                            <li>Product</li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn" href="blog-details.html">read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="blog foo">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="3dprinting.jpg" alt="blog images">
                                    </a>

                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <p class="blog__des">
                                            <a href="blog-details.html">Lorem ipsum dolor sit consectetu.</a>
                                        </p>
                                        <ul class="bl__meta">
                                            <li>By :<a href="#">Admin</a>
                                            </li>
                                            <li>Product</li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn" href="blog-details.html">read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 hidden-sm col-xs-12">
                        <div class="blog foo">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="project.jpg">
                                    </a>

                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <p class="blog__des">
                                            <a href="blog-details.html">Lorem ipsum dolor sit consectetu.</a>
                                        </p>
                                        <ul class="bl__meta">
                                            <li>By :<a href="#">Admin</a>
                                            </li>
                                            <li>Product</li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn" href="blog-details.html">read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                </div>
            </div>
        </div>
    </section>
@endsection
