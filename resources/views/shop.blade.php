@extends('layout.app')
@section('content')



<!-- Start Offset Wrapper -->
@include('layout.cart')
<!-- End Offset Wrapper -->





<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop Page</h2>
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="/">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb-item active">Shop Page</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<!-- End Bradcaump area -->
<!-- Start Our Product Area -->




<div class="htc__product__area shop__page ptb--130 row" style="background-color:#ffffff; min-height: 700px;">
    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 float-right-style" >
        @include('layout.category')
    </div>
    <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12 float-left-style bg__white">
        <div class="htc__product__container bg__white">
            <!-- Start Product MEnu -->
            <div class="row">
                <div class="col-md-12">
                    <div class="filter__menu__container">
                        <div class="product__menu is-checked">
                            <button data-filter="*" class="is-checked">Here is your product</button>
                            <!--
                            <button data-filter=".cat--1">Furnitures</button>
                            <button data-filter=".cat--2">Bags</button>
                            <button data-filter=".cat--3">Decoration</button>
                            <button data-filter=".cat--4">Accessories</button>
                            -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- Start Filter Menu -->


            <!-- End Product MEnu -->
            <div class="row">
                <div class="product__list another-product-style " >
                   @if($products)
                    @foreach ($products as $product)

                    <div class="col-md-3 single__pro col-lg-2 cat--1 col-sm-6 col-xs-2 boxsize">
                        <div class="product">
                            <div class="product__inner">
                                <div class="pro__thumb" style="max-height: 200px;">
                                    <a href="#">
                                        <img class="img-rounded" style="max-height: 200px;" src="{{Storage::disk('local')->url('product_images/'.$product->image)  }}" alt="product images">
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
                                            <a title="Wishlist" href="wishlist.html">
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
                                    <li class="old__price">{{ $product-> id }}</li>
                                    <li class="new__price">৳{{ $product->price }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h1>No Products Found</h1>
                    @endif





















                </div>
            </div>
            <!-- Start Load More BTn -->
            <div class="row mt--50">
                <div class="col-md-12">
                    <div class="htc__loadmore__btn">

                        {{$products->links()}}
                    </div>
                </div>
            </div>
            <!-- End Load More BTn -->
        </div>
    </div>
</div>
<!-- End Our Product Area -->
<!-- Start Footer Area -->

<!-- End Footer Area -->

<!-- Body main wrapper end -->
<!-- QUICKVIEW PRODUCT -->
@endsection
