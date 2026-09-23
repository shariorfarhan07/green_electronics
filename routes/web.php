<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Inertia\Inertia;
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

Route::get('/', ["uses"=>"ProductsController@index","as"=>'homepage']);

Route::get('about', function () {
    return Inertia::render('About');
})->name('about');
Route::get('contact', ['uses' => 'ContactController@show', 'as' => 'contact']);
Route::post('contact', ['uses' => 'ContactController@store', 'as' => 'contact.store']);
Route::get('coming-soon', function () {
    return Inertia::render('ComingSoon');
})->name('coming-soon');

// product browsing (listing, category filter and free-text search all share one action)
Route::get('shop', ['uses' => 'ProductsController@search', 'as' => 'shop']);
Route::get('products/{id}', ['uses' => 'ProductsController@productView', 'as' => 'products.show']);

// cart
Route::get('cart', ["uses"=>"ProductsController@cartIndex","as"=>'cart.index']);
Route::get('cart/add/{id}', ['uses'=> 'ProductsController@addToCart', 'as'=>'cart.add']);
Route::get('cart/items/{id}/{number}', ['uses'=> 'ProductsController@updateCartQuantity', 'as'=>'cart.update']);

// wishlist
Route::get('wishlist', ["uses"=>"ProductsController@wishlistIndex","as"=>'wishlist.index'])->middleware('auth');
Route::get('wishlist/add/{id}', ['uses'=> 'ProductsController@addToWishlist', 'as'=>'wishlist.add'])->middleware('auth');
Route::get('wishlist/remove/{id}', ['uses'=> 'ProductsController@removeFromWishlist', 'as'=>'wishlist.remove'])->middleware('auth');

// checkout
Route::get('checkout', ['uses'=> 'ProductsController@checkoutIndex', 'as'=>'checkout.index']);
Route::post('checkout', ['uses'=> 'ProductsController@checkoutStore', 'as'=>'checkout.store']);

// social login (GitHub / Google via Socialite)
Route::get('login/{platform}', [LoginController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('login/{platform}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

// stock Laravel auth scaffolding: login, register, password reset, email verification
Auth::routes();

Route::get('account', 'HomeController@index')->name('account')->middleware('auth');
Route::get('account/orders', ['uses' => 'AccountController@index', 'as' => 'account.orders.index']);
Route::get('account/orders/{id}', ['uses' => 'AccountController@show', 'as' => 'account.orders.show']);

//admin panel — all routes below require an authenticated admin (see app/Http/Middleware/RestrictAccess.php)
Route::prefix('admin')->middleware('restictToAdmin')->group(function () {
    Route::redirect('/', '/admin/products');

    Route::get('orders', ['uses' => 'Admin\AdminOrderController@index', 'as' => 'admin.orders.index']);
    Route::get('orders/{id}', ['uses' => 'Admin\AdminOrderController@show', 'as' => 'admin.orders.show']);
    Route::get('orders/{id}/edit', ['uses' => 'Admin\AdminOrderController@edit', 'as' => 'admin.orders.edit']);
    Route::put('orders/{id}', ['uses' => 'Admin\AdminOrderController@update', 'as' => 'admin.orders.update']);
    Route::post('orders/{id}/items', ['uses' => 'Admin\AdminOrderController@addItem', 'as' => 'admin.orders.items.store']);
    Route::delete('orders/{id}/items/{itemId}', ['uses' => 'Admin\AdminOrderController@removeItem', 'as' => 'admin.orders.items.destroy']);

    Route::get('products', ['uses' => 'Admin\AdminProductController@index', 'as' => 'admin.products.index']);
    Route::get('products/bulk', ['uses' => 'Admin\AdminProductController@bulkForm', 'as' => 'admin.products.bulk']);
    Route::get('products/export', ['uses' => 'Admin\AdminProductController@export', 'as' => 'admin.products.export']);
    Route::post('products/import', ['uses' => 'Admin\AdminProductController@import', 'as' => 'admin.products.import']);
    Route::get('products/create', ['uses' => 'Admin\AdminProductController@create', 'as' => 'admin.products.create']);
    Route::post('products', ['uses' => 'Admin\AdminProductController@store', 'as' => 'admin.products.store']);
    Route::get('products/{id}/edit', ['uses' => 'Admin\AdminProductController@edit', 'as' => 'admin.products.edit']);
    Route::put('products/{id}', ['uses' => 'Admin\AdminProductController@update', 'as' => 'admin.products.update']);
    Route::delete('products/{id}', ['uses' => 'Admin\AdminProductController@destroy', 'as' => 'admin.products.destroy']);

    // Images are managed inline on the product edit screen, so there is no
    // separate index route — only the upload and delete actions.
    Route::post('products/{id}/images', ['uses' => 'Admin\AdminProductController@storeImage', 'as' => 'admin.products.images.store']);
    Route::delete('products/images/{imageId}', ['uses' => 'Admin\AdminProductController@destroyImage', 'as' => 'admin.products.images.destroy']);

    // contact form submissions
    Route::get('messages', ['uses' => 'Admin\AdminMessageController@index', 'as' => 'admin.messages.index']);
    Route::get('messages/{id}', ['uses' => 'Admin\AdminMessageController@show', 'as' => 'admin.messages.show']);
    Route::delete('messages/{id}', ['uses' => 'Admin\AdminMessageController@destroy', 'as' => 'admin.messages.destroy']);

    // category taxonomy management
    Route::get('categories', ['uses' => 'Admin\AdminCategoryController@index', 'as' => 'admin.categories.index']);
    Route::post('categories', ['uses' => 'Admin\AdminCategoryController@store', 'as' => 'admin.categories.store']);
    Route::put('categories/{id}', ['uses' => 'Admin\AdminCategoryController@update', 'as' => 'admin.categories.update']);
    Route::delete('categories/{id}', ['uses' => 'Admin\AdminCategoryController@destroy', 'as' => 'admin.categories.destroy']);

    // store-wide settings (e.g. contact-only ordering)
    Route::get('settings', ['uses' => 'Admin\AdminSettingController@edit', 'as' => 'admin.settings.edit']);
    Route::put('settings', ['uses' => 'Admin\AdminSettingController@update', 'as' => 'admin.settings.update']);
});
