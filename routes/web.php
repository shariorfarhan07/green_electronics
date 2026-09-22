<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('index');
});
*/
Route::get('/', ["uses"=>"ProductsController@index","as"=>'homepage']);


Route::get('comingsoon', function () {
    return view('comingsoon');
});
Route::get('contact', function () {
    return view('contact');
});
Route::get('shop', function () {
    return view('shop');
});

Route::get('product', function () {
    return view('shop');
});
Route::get('o', function () {
    return view('orderForm');
});

//wish list
Route::get('product/addToWishList/{id}',['uses'=> 'productsController@AddToWishListProduct','as'=>'AddToWishListProduct'])->middleware('auth');
Route::get('wishlist', ["uses"=>"ProductsController@showWishList","as"=>'WishListProduct'])->middleware('auth');
Route::get('product/RemoveWishList/{id}',['uses'=> 'productsController@RemoveFromWishListProduct','as'=>'RemoveFromWishListProduct'])->middleware('auth');

//cart routings
Route::get('product/addTocart/{id}',['uses'=> 'productsController@AddToCartProduct','as'=>'AddToCartProduct']);
Route::get('cart', ["uses"=>"ProductsController@showCart","as"=>'cartproduct']);
Route::get('product/{id}/{number}',['uses'=> 'productsController@adjustcart','as'=>'adjustCart']);
//product view routes

Route::get('productview/{id}',['uses'=> 'productsController@productView','as'=>'productView']);
//search url
Route::get('search',['uses'=> 'productsController@search','as'=>'searchproduct']);

//billing & payment page
Route::get('billing',['uses'=> 'productsController@showpaymentpage','as'=>'billingdetails']);
Route::post('billingconfirm',['uses'=> 'productsController@billingconfirm','as'=>'billingconfirm']);



//socialite
//github & google
Route::get('login/{platform}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{platform}/callback', [LoginController::class, 'handleProviderCallback']);






//user authentication
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//admin panel
//displays product
Route::get('admin',['uses'=>'Admin\AdminProductController@index' ,'as'=>'adminDisplayProduct'])->middleware('restictToAdmin');
Route::get('admin/order',['uses'=>'Admin\AdminProductController@order' ,'as'=>'order'])->middleware('restictToAdmin');
Route::get('admin/order/{id}',['uses'=>'Admin\AdminProductController@invoice' ,'as'=>'invoice'])->middleware('restictToAdmin');


//edit ptroduct details no images
Route::get('admin/editproductform/{id}',['uses'=>'Admin\AdminProductController@editProductForm' ,'as'=>'editProductForm']);
Route::post('admin/updateproduct/{id}',['uses'=>'Admin\AdminProductController@updateProduct' ,'as'=>'updateProduct']);
//edit product details not images
//post request for updating image
Route::get('admin/editproductimageform/{id}',['uses'=>'Admin\AdminProductController@editProductImageForm' ,'as'=>'editProductImageForm']);
Route::post('admin/updateproductimageform/{id}',['uses'=>'Admin\AdminProductController@updateProductImageForm' ,'as'=>'sendEditProductImageForm']);

Route::get('admin/editproductimageform1/{id}',['uses'=>'Admin\AdminProductController@editProductImageForm1' ,'as'=>'editProductImageForm1']);
Route::post('admin/updateproductimageform1/{id}',['uses'=>'Admin\AdminProductController@updateProductImageForm1' ,'as'=>'sendEditProductImageForm1']);
Route::get('admin/editproductimageform2/{id}',['uses'=>'Admin\AdminProductController@editProductImageForm2' ,'as'=>'editProductImageForm2']);
Route::post('admin/updateproductimageform2/{id}',['uses'=>'Admin\AdminProductController@updateProductImageForm2' ,'as'=>'sendEditProductImageForm2']);
Route::get('admin/editproductimageform3/{id}',['uses'=>'Admin\AdminProductController@editProductImageForm3' ,'as'=>'editProductImageForm3']);
Route::post('admin/updateproductimageform3/{id}',['uses'=>'Admin\AdminProductController@updateProductImageForm3' ,'as'=>'sendEditProductImageForm3']);


//post for details of the products
//for creating product
Route::get('admin/createproductform',['uses'=>'Admin\AdminProductController@createProductForm' ,'as'=>'admincreateproductform']);
Route::post('admin/sendcreateproduct',['uses'=>'Admin\AdminProductController@sendCreateProductForm' ,'as'=>'adminsendcreateproductform']);
//admin delete product
Route::get('admin/deleteproduct/{id}',['uses'=>'Admin\AdminProductController@deleteProduct' ,'as'=>'deleteproduct']);
