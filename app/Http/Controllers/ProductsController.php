<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class ProductsController extends Controller

{
    //
  public function index(){
      $products = Product::all();
      $products1 = Product::orderBy('id', 'desc')->where('type2', 'DEVELOPMENT BOARDS')->take(7)->get();
      $products2= Product::orderBy('id', 'desc')->where('type2', 'RC & DRONE')->take(7)->get();
      $products3 = Product::orderBy('id', 'desc')->where('type2', 'CNC & 3D PRINTERS')->take(7)->get();
      $products4 = Product::orderBy('id', 'desc')->take(12)->get();
      $products5 = Product::orderBy('sold', 'desc')->take(12)->get();

      return view("index")->with('products1',$products1)->with('products2',$products2)->with('products3',$products3)->with('products4',$products4)->with('products5',$products5);
  }

public function showpaymentpage(){
 return view('orderForm');
}




  public function billingconfirm(Request $request){
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
      }else{
          $paymentnumber='cash on delevery';
          $txid='cash on delevery';
      }


      $cart=Session::get('cart');
      //cart is not empty
      if($cart){
          //dump($cart);
          $date=date('Y-m-d H:i:s');
          $newOrderArray=array('shipping'=>$shipping,'zip'=>$zip,'date'=>$date,'txid'=>$txid,'bkashnumber'=>$paymentnumber,'status'=>'our representative will call you','payment'=>$cart->totalPrice,'name'=>$name,'email'=>$email,'phone'=>$phone,'address'=>$address,'division'=>$division,'city'=>$city);
          $created_order=DB::table('orders')->insert($newOrderArray);
          $order_id=DB::getPdo()->lastInsertId();
          foreach ($cart->items as $cart_item){
              $item_id=$cart_item['data']['id'];
              $item_name=$cart_item['data']['Name'];
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
   $searchText=$request->get('searchText');
      $products=Product::where('Name','Like',"%".$searchText."%")->
      orWhere('type1', 'LIKE', '%' . $searchText . '%')->
      orWhere('type2', 'LIKE', '%' . $searchText . '%')->
      orWhere('type3', 'LIKE', '%' . $searchText . '%')->paginate(3);
      return view("shop",compact("products"));
  }

  public function productView(Request $request,$id){
      $product = Product::find($id);
     // dump($product);
      return view("product",compact("product"));


  }
  public function AddToWishListProduct(Request $request,$id){
      $userId = Auth::id();
      $exist=DB::table('wishlist')->where('user_id', '=',$userId)->where('product_id', '=', $id)->exists();

      if($exist){
          return redirect()->route('WishListProduct');
      }else{
          $s=['user_id'=>$userId,'product_id'=>$id];
          DB::table('wishlist')->insert($s);
      }
     return redirect()->route('WishListProduct');

  }
  public function RemoveFromWishListProduct(Request $request,$id){
      $userId = Auth::id();
      DB::table('wishlist')->where('user_id', '=',$userId)->where('product_id', '=', $id)->delete();
      return redirect()->route('WishListProduct');
  }
  public function showWishList(){
      $userId = Auth::id();
      $exist=DB::table('wishlist')->where('user_id', $userId)->exists();
      if($exist){
          $products=DB::table('wishlist')->where('user_id', $userId)->get();
          $data=[];
          foreach ($products as $product){
              array_push($data,$product->product_id);
          }
          $products=DB::table('products')->where('id', $data)->get();

          return view('wishlist')->with('products',$products);
      }
      return redirect()->route('homepage');
  }



  public function AddToCartProduct(Request $request,$id){
      $prevCart=$request-> session()->get('cart');
      $cart=new Cart($prevCart);
      $product=Product::find($id);
      $cart->addItem($id, $product);
      $request->session()->put('cart',$cart);
      //dump($cart);
      return redirect()-> route('homepage');
  }
  public function showCart(){
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
  public function adjustcart(Request $request,$id,$number){
      $prevCart=$request-> session()->get('cart');
      $cart=new Cart($prevCart);
      $cart->removeFromCart($id,$number);
      $request->session()->put('cart',$cart);
      //dump($cart);
      return redirect()-> route('cartproduct');

  }


}
