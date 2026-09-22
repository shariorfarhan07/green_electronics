<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class ProductsController extends Controller

{
    //
  public function index(){
      $byCategory = function ($slug) {
          return Product::with(['images', 'category'])->whereHas('category', function ($q) use ($slug) {
              $q->where('slug', $slug);
          })->orderBy('id', 'desc')->take(7)->get();
      };

      $products1 = $byCategory('development-boards');
      $products2 = $byCategory('robotics-rc');
      $products3 = $byCategory('cnc-3d-printers');
      $products4 = Product::with(['images', 'category'])->orderBy('id', 'desc')->take(12)->get();
      $products5 = Product::with(['images', 'category'])->orderBy('sold', 'desc')->take(12)->get();

      return view("index")->with('products1',$products1)->with('products2',$products2)->with('products3',$products3)->with('products4',$products4)->with('products5',$products5);
  }

public function checkoutIndex(){
    $cart=Session::get('cart');
    if(!$cart || count($cart->items) === 0){
        return redirect()->route('homepage');
    }
    return view('orderForm');
}




  public function checkoutStore(Request $request){
      $first_name=$request->input('firstname');
      $last_name=$request->input('lastname');

      $name=$first_name." ".$last_name;
      $phone=$request->input('phone');
      $email=$request->input('email');
      $address=$request->input('address').$request->input('flat');
      $division=$request->input('division');
      $city=$request->input('city');
      $paymentmethod=$request->input('paymentmethod');
      $zip=$request->input('zip');
      $shipping=0;
      if($division=="Dhaka"){
          $shipping=60;
      }else{
          $shipping=100;
      }
      if($paymentmethod=='bkash'){
          $paymentnumber=$request->input('paymentnumber');
          $txid=$request->input('txid');
          $codAmount=null;
      }else{
          $paymentnumber='cash on delevery';
          $txid='cash on delevery';
          $paymentmethod='cod';
      }


      $cart=Session::get('cart');
      //cart is not empty
      if($cart){
          //dump($cart);
          $date=date('Y-m-d H:i:s');
          $codAmount = $paymentmethod === 'cod' ? ($cart->totalPrice + $shipping) : null;
          $newOrderArray=array('shipping'=>$shipping,'zip'=>$zip,'date'=>$date,'txid'=>$txid,'bkashnumber'=>$paymentnumber,'payment_method'=>$paymentmethod,'cod_amount'=>$codAmount,'status'=>'our representative will call you','payment'=>$cart->totalPrice,'name'=>$name,'email'=>$email,'phone'=>$phone,'address'=>$address,'division'=>$division,'city'=>$city);
          $created_order=DB::table('orders')->insert($newOrderArray);
          $order_id=DB::getPdo()->lastInsertId();
          foreach ($cart->items as $cart_item){
              $item_id=$cart_item['data']['id'];
              $item_name=$cart_item['data']['name'];
              $item_price=$cart_item['data']['price'];
              $qty=$cart_item['quantity'];
              $newOrderItem=array('order_id'=>$order_id,'item_id'=>$item_id,'item_name'=>$item_name,'item_price'=>$item_price,'qty'=>$qty);
              $created_order_items=DB::table('orders_items')->insert($newOrderItem);
                  }
          Session::forget('cart');
          Session::flush();
          return redirect()->route("homepage")->withsuccess('Thanks For Choosing us');

      }else{
          return redirect()->route("homepage")->withsuccess('nothing in cart');
      }
  }



  public function search(Request $request){
      $searchText = $request->get('searchText');
      $categorySlug = $request->get('category');

      $query = Product::with(['images', 'category'])->orderBy('id', 'desc');

      if ($categorySlug) {
          $query->whereHas('category', function ($q) use ($categorySlug) {
              $q->where('slug', $categorySlug);
          });
      } elseif ($searchText) {
          $query->where(function ($q) use ($searchText) {
              $q->where('name', 'LIKE', '%'.$searchText.'%')
                ->orWhere('subcategory', 'LIKE', '%'.$searchText.'%')
                ->orWhere('brand', 'LIKE', '%'.$searchText.'%');
          });
      }

      $products = $query->paginate(12);
      $activeCategory = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;

      return view("shop", compact("products", "activeCategory"));
  }

  public function productView(Request $request,$id){
      $product = Product::with(['images', 'category'])->findOrFail($id);
      return view("product",compact("product"));


  }
  public function addToWishlist(Request $request,$id){
      $userId = Auth::id();
      $exist=DB::table('wishlist')->where('user_id', '=',$userId)->where('product_id', '=', $id)->exists();

      if($exist){
          return redirect()->route('wishlist.index');
      }else{
          $s=['user_id'=>$userId,'product_id'=>$id];
          DB::table('wishlist')->insert($s);
      }
     return redirect()->route('wishlist.index');

  }
  public function removeFromWishlist(Request $request,$id){
      $userId = Auth::id();
      DB::table('wishlist')->where('user_id', '=',$userId)->where('product_id', '=', $id)->delete();
      return redirect()->route('wishlist.index');
  }
  public function wishlistIndex(){
      $userId = Auth::id();
      $exist=DB::table('wishlist')->where('user_id', $userId)->exists();
      if($exist){
          $productIds = DB::table('wishlist')->where('user_id', $userId)->pluck('product_id');
          $products = Product::with('images')->whereIn('id', $productIds)->get();

          return view('wishlist')->with('products',$products);
      }
      return redirect()->route('homepage');
  }



  public function addToCart(Request $request,$id){
      $prevCart=$request-> session()->get('cart');
      $cart=new Cart($prevCart);
      $product=Product::find($id);
      $cart->addItem($id, $product);
      $request->session()->put('cart',$cart);
      //dump($cart);
      return redirect()-> route('homepage');
  }
  public function cartIndex(){
      $cart=Session::get('cart');
      // cart is not empty
      if($cart){
          return view('cartproducts',['cartItems'=>$cart]);
         //dump($cart);
       //cart is empty
      }else{
       return redirect()->route("homepage");
      }

  }
  public function updateCartQuantity(Request $request,$id,$number){
      $prevCart=$request-> session()->get('cart');
      $cart=new Cart($prevCart);
      $cart->removeFromCart($id,$number);
      $request->session()->put('cart',$cart);
      //dump($cart);
      return redirect()-> route('cart.index');

  }


}
