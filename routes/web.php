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
Route::get('about', function () {
    return view('about');
});
Route::get('contact', function () {
    return view('contact');
});
Route::get('shop', ['uses' => 'ProductsController@search', 'as' => 'shop']);

Route::get('product', ['uses' => 'ProductsController@search', 'as' => 'productlist']);

//wish list
Route::get('product/addToWishList/{id}',['uses'=> 'ProductsController@AddToWishListProduct','as'=>'AddToWishListProduct'])->middleware('auth');
Route::get('wishlist', ["uses"=>"ProductsController@showWishList","as"=>'WishListProduct'])->middleware('auth');
Route::get('product/RemoveWishList/{id}',['uses'=> 'ProductsController@RemoveFromWishListProduct','as'=>'RemoveFromWishListProduct'])->middleware('auth');

//cart routings
Route::get('product/addTocart/{id}',['uses'=> 'ProductsController@AddToCartProduct','as'=>'AddToCartProduct']);
Route::get('cart', ["uses"=>"ProductsController@showCart","as"=>'cartproduct']);
Route::get('product/{id}/{number}',['uses'=> 'ProductsController@adjustcart','as'=>'adjustCart']);
//product view routes

Route::get('productview/{id}',['uses'=> 'ProductsController@productView','as'=>'productView']);
//search url
Route::get('search',['uses'=> 'ProductsController@search','as'=>'searchproduct']);

//billing & payment page
Route::get('billing',['uses'=> 'ProductsController@showpaymentpage','as'=>'billingdetails']);
Route::post('billingconfirm',['uses'=> 'ProductsController@billingconfirm','as'=>'billingconfirm']);



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
//manage all images for a product (replaces the old fixed 4-slot image forms)
Route::get('admin/product/{id}/images',['uses'=>'Admin\AdminProductController@manageProductImages' ,'as'=>'manageProductImages']);
Route::post('admin/product/{id}/images',['uses'=>'Admin\AdminProductController@uploadProductImage' ,'as'=>'uploadProductImage']);
Route::get('admin/product-image/{imageId}/delete',['uses'=>'Admin\AdminProductController@deleteProductImage' ,'as'=>'deleteProductImage']);


//post for details of the products
//for creating product
Route::get('admin/createproductform',['uses'=>'Admin\AdminProductController@createProductForm' ,'as'=>'admincreateproductform']);
Route::post('admin/sendcreateproduct',['uses'=>'Admin\AdminProductController@sendCreateProductForm' ,'as'=>'adminsendcreateproductform']);
//admin delete product
Route::get('admin/deleteproduct/{id}',['uses'=>'Admin\AdminProductController@deleteProduct' ,'as'=>'deleteproduct']);
