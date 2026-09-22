@extends('layout.app')
@section('content')
<!-- End Header Style -->
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
    <!-- End Search Popap -->


    <!-- Start Offset MEnu -->
    @include('layout.cart')













<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Product Details</h2>
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb-item active">Product Details</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Product Details -->
<section class="htc__product__details pt--120 pb--100 bg__white">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="product__details__container">
                    <!-- Start Small images -->

                    <ul class="product__small__images" role="tablist">

                        @if($product['image'])
                        <li role="presentation" class="pot-small-img active">
                            <a href="#img-tab-1" role="tab" data-toggle="tab">
                                <img  class="border-2"src="{{Storage::url('product_images/'.$product['image'])}}" alt="small-image" style=" width:140px; height:120px;">
                            </a>
                        </li>
                        @endif
                        @if($product['image1'])
                        <li role="presentation" class="pot-small-img">
                            <a href="#img-tab-2" role="tab" data-toggle="tab">
                                <img src="{{Storage::url('product_images/'.$product['image1'])}}" alt="small-image" style=" width:140px; height:120px;">
                            </a>
                        </li>
                        @endif
                        @if($product['image2'])
                        <li role="presentation" class="pot-small-img hidden-xs">
                            <a href="#img-tab-3" role="tab" data-toggle="tab">
                                <img src="{{Storage::url('product_images/'.$product['image2'])}}" alt="small-image" style=" width:140px; height:120px;">
                            </a>
                        </li>
                        @endif
                        @if($product['image3'])
                        <li role="presentation" class="pot-small-img hidden-xs hidden-sm">
                            <a href="#img-tab-4" role="tab" data-toggle="tab">
                                <img src="{{Storage::url('product_images/'.$product['image3'])}}" alt="small-image" style=" width:140px; height:120px;">
                            </a>
                        </li>
                        @endif

                    </ul>
                    <!-- End Small images -->
                    <div class="product__big__images">
                        <div class="portfolio-full-image tab-content">
                            @if($product['image'])
                            <div role="tabpanel" class="tab-pane fade in active product-video-position" id="img-tab-1">
                                <img src="{{Storage::url('product_images/'.$product['image'])}}" alt="full-image">
                                <div class="product-video">

                                    <a class="video-popup" href="https://www.youtube.com/watch?v=cDDWvj_q-o8">
                                        <i class="zmdi zmdi-videocam"></i> View Video
                                    </a>

                                </div>
                            </div>
                           @endif
                           @if($product['image1'])
                            <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-2" >
                                <img src="{{Storage::url('product_images/'.$product['image1'])}}" alt="full-image">
                                <div class="product-video">
                                    <a class="video-popup" href="https://www.youtube.com/watch?v=cDDWvj_q-o8">
                                        <i class="zmdi zmdi-videocam"></i> View Video
                                    </a>
                                </div>
                            </div>
                           @endif
                           @if($product['image2'])
                            <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-3" >
                                <img src="{{Storage::url('product_images/'.$product['image2'])}}" alt="full-image">
                                <div class="product-video">
                                    <a class="video-popup" href="https://www.youtube.com/watch?v=cDDWvj_q-o8">
                                        <i class="zmdi zmdi-videocam"></i> View Video
                                    </a>
                                </div>
                            </div>
                            @endif
                            @if($product['image3'])
                            <div role="tabpanel" class="tab-pane fade product-video-position" id="img-tab-4">
                                <img src="{{Storage::url('product_images/'.$product['image3'])}}" alt="full-image">
                                <div class="product-video">
                                    <a class="video-popup" href="https://www.youtube.com/watch?v=cDDWvj_q-o8">
                                        <i class="zmdi zmdi-videocam"></i> View Video
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                <div class="htc__product__details__inner">
                    <div class="pro__detl__title">
                        <h2>{{$product['Name']}}</h2>
                    </div>
                    <div class="pro__dtl__rating">
                        <ul class="pro__rating">
                            <li><span class="ti-star"></span></li>
                            <li><span class="ti-star"></span></li>
                            <li><span class="ti-star"></span></li>
                            <li><span class="ti-star"></span></li>
                            <li><span class="ti-star"></span></li>
                        </ul>
                        <span class="rat__qun"></span>
                    </div>
                    <div class="pro__details">
                        <p>We assure you to provide the best quality product! </p>
                        <p>Stock:{{$product['stock']}}</p>
                        <p>sold:{{$product['sold']}}</p>
                    </div>
                    <ul class="pro__dtl__prize">
                        <li>৳{{$product['price']}}</li>
                    </ul>

                    <form action="{{url('/admin/updateproduct/'.$product->id)}}" method="get">
                    <div class="product-action-wrap">
                        <div class="prodict-statas"><span>Quantity :</span></div>
                        <div class="product-quantity">
                            <form id='myform' method='POST' action='#'>
                                <div class="product-quantity">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <ul class="pro__dtl__btn">
                        <li class="buy__now__btn" type="submit" ><a href="#">Add to cart</a></li>
                        <li><a href="#"><span class="ti-heart"></span></a></li>

                    </ul>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Product Details -->
<!-- Start Product tab -->
<section class="htc__product__details__tab bg__white pb--120">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <ul class="product__deatils__tab mb--60" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#description" role="tab" data-toggle="tab">Description</a>
                    </li>
                    <li role="presentation">
                        <a href="#sheet" role="tab" data-toggle="tab">Data sheet</a>
                    </li>
                    <!--
                    <li role="presentation">
                        <a href="#reviews" role="tab" data-toggle="tab">Reviews</a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product__details__tab__content">
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="description" class="product__tab__content fade in active">
                        <div class="product__description__wrap">
                            <h2 class="title__6">Description</h2>
                            <!--<p>{{$product['description']}}</p>-->
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="sheet" class="product__tab__content fade">
                        <div class="pro__feature">
                            <h2 class="title__6">Data sheet</h2>
                            <p><?php echo nl2br(htmlspecialchars($product['sdescription'])); ?></p>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div role="tabpanel" id="reviews" class="product__tab__content fade">
                        <div class="review__address__inner">
                            <!-- Start Single Review -->
                            <div class="pro__review">
                                <div class="review__thumb">
                                    <img src="images/review/1.jpg" alt="review images">
                                </div>
                                <div class="review__details">
                                    <div class="review__info">
                                        <h4><a href="#">Gerald Barnes</a></h4>
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <div class="rating__send">
                                            <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                            <a href="#"><i class="zmdi zmdi-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="review__date">
                                        <span>27 Jun, 2016 at 2:30pm</span>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>
                            <!-- End Single Review -->
                            <!-- Start Single Review -->
                            <div class="pro__review ans">
                                <div class="review__thumb">
                                    <img src="images/review/2.jpg" alt="review images">
                                </div>
                                <div class="review__details">
                                    <div class="review__info">
                                        <h4><a href="#">Gerald Barnes</a></h4>
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <div class="rating__send">
                                            <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                                            <a href="#"><i class="zmdi zmdi-close"></i></a>
                                        </div>
                                    </div>
                                    <div class="review__date">
                                        <span>27 Jun, 2016 at 2:30pm</span>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                                </div>
                            </div>
                            <!-- End Single Review -->
                        </div>
                        <!-- Start RAting Area -->
                        <div class="rating__wrap">
                            <h2 class="rating-title">Write  A review</h2>
                            <h4 class="rating-title-2">Your Rating</h4>
                            <div class="rating__list">
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                </ul>
                                <!-- End Single List -->
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                </ul>
                                <!-- End Single List -->
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                </ul>
                                <!-- End Single List -->
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                </ul>
                                <!-- End Single List -->
                                <!-- Start Single List -->
                                <ul class="rating">
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                    <li><i class="zmdi zmdi-star-half"></i></li>
                                </ul>
                                <!-- End Single List -->
                            </div>
                        </div>
                        <!-- End RAting Area -->
                        <div class="review__box">
                            <form id="review-form">
                                <div class="single-review-form">
                                    <div class="review-box name">
                                        <input type="text" placeholder="Type your name">
                                        <input type="email" placeholder="Type your email">
                                    </div>
                                </div>
                                <div class="single-review-form">
                                    <div class="review-box message">
                                        <textarea placeholder="Write your review"></textarea>
                                    </div>
                                </div>
                                <div class="review-btn">
                                    <a class="fv-btn" href="#">submit review</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Product tab -->
<!-- Start Footer Area -->
@endsection









