<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Orders_Items;
use App\Product;
//use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;



class AdminProductController extends Controller
{
    //
    public function index(){
        $products = Product::orderBy('created_at', 'desc')->paginate(6);
        return view("admin.AdmindisplayProducts",['products'=>$products ]);

    }
    public function order(){
        $products = Order::orderBy('date', 'desc')->paginate(20);
        return view("admin.order",['products'=>$products ]);

    }
    public function invoice($id){
        $products = Orders_Items::where('order_id', $id)->get();

        $userdetails=Order::find($id);

       return view("admin.invoice",['products'=>$products ,'customer'=>$userdetails]);

    }

    public function editProductForm($id){
        $product=Product::find($id);
     return view('admin.editProductForm',['product'=>$product]) ;
    }
    public function editProductImageForm($id){
        $product=Product::find($id);
        return view('admin.editProductImageForm',['product'=>$product]) ;
    }
    public function editProductImageForm1($id){
        $product=Product::find($id);
        return view('admin.editProductImageForm1',['product'=>$product]) ;
    }
    public function editProductImageForm2($id){
        $product=Product::find($id);
        return view('admin.editProductImageForm2',['product'=>$product]) ;
    }
    public function editProductImageForm3($id){
        $product=Product::find($id);
        return view('admin.editProductImageForm3',['product'=>$product]) ;
    }

   public function createProductForm(){
        return view('admin.createProductForm');
   }
   public function deleteProduct($id){
        $product=Product::find($id);
       $exists=Storage::disk("local")->exists('public/product_images/'.$product->image);
       //delete that image
       if($exists){
           Storage::delete('public/product_images/'.$product->images);
       }
       $exists=Storage::disk("local")->exists('public/product_images/'.$product->image1);
       //delete that image1
       if($exists){
           Storage::delete('public/product_images/'.$product->images1);
       }
       $exists=Storage::disk("local")->exists('public/product_images/'.$product->image2);
       //delete that image2
       if($exists){
           Storage::delete('public/product_images/'.$product->images2);
       }
       $exists=Storage::disk("local")->exists('public/product_images/'.$product->image3);
       //delete that image3
       if($exists){
           Storage::delete('public/product_images/'.$product->images3);
       }
        Product::destroy($id);
     return redirect()->route('adminDisplayProduct');
    }

   public function sendCreateProductForm(Request $request){
       $date=date('Y-m-d H:i:s');
        $name=$request->input('name');
        $description=$request->input('description');
        $price=$request->input('price');
        $stock=$request->input('stock');
        $type1=$request->input('type1');
        $type2=$request->input('type1');
        $type3=$request->input('type1');
        $slug=$request->input('slug');
       $ssdescription= $request->input('sdescription');
       $datasheet= $request->input('datasheet');
       $link= $request->input('link');

       Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();
       $ext =$request->file('image')->getClientOriginalExtension();
       $stringImageReFormat=str_replace(' ','',$request->input('name'));
       $imageName=$stringImageReFormat.$date.".".$ext;// add extention to the image
       $imageEncoded=File::get($request->image);

       Storage::disk('local')->put('public/product_images/'.$imageName,$imageEncoded);
       $newProductArray=array('sdescription'=>$ssdescription,'datasheet'=>$datasheet,'link'=>$link,'Name'=>$name,'description'=>$description,'stock'=>$stock,'price'=>$price,'image'=>$imageName,'type1'=>$type1,'type2'=>$type2,'type3'=>$type3,'slug'=>$slug,'sold'=>0);
       $created=DB::table('products')->insert($newProductArray);

       if($created){

        return redirect()->route('adminDisplayProduct');

       }else{
          return 'new product was not created';

       }
   }
    public function updateProductImageForm(Request $request,$id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();

        if($request->hasFile("image")){
           $product=Product::find($id);
            $exists=$product->image;
            try {
                if($exists){
                    $exists=Storage::disk("local")->exists('public/product_images/'.$product->image);
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            //delete that image
            if($exists){
                Storage::delete('public/product_images/'.$product->image1);
                $imageName=$product->image;
            }else{
                $ext =$request->file('image')->getClientOriginalExtension();
                $stringImageReFormat=str_replace(' ','',$request->input('name'));
                $imageName=$stringImageReFormat.".".$ext;// add extention to the image

            }
            // upload that image
            //$request->file('image')->getClientOriginalExtension();//return jpg

            $request->image->storeAs("public/product_images/",$imageName);
            $arrayToUpdate=array('image'=>$imageName);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProduct');
        }else{
           return 'no image was selected';
        }

    }



    public function updateProductImageForm1(Request $request,$id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();

        if($request->hasFile("image")){
            $product=Product::find($id);
            $exists=$product->image1;
            try {
                if($exists){
                    $exists=Storage::disk("local")->exists('public/product_images/'.$product->image1);
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            //delete that image
            if($exists){
                Storage::delete('public/product_images/'.$product->image1);
                $imageName=$product->image1;
            }else{
                $ext =$request->file('image')->getClientOriginalExtension();
                $stringImageReFormat=str_replace(' ','1',$request->input('name'));
                $imageName=$stringImageReFormat.".".$ext;// add extention to the image

            }
            // upload that image
            //$request->file('image')->getClientOriginalExtension();//return jpg

            $request->image->storeAs("public/product_images/",$imageName);
            $arrayToUpdate=array('image'=>$imageName);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProduct');
        }else{
            return 'no image was selected';
        }

    }


    public function updateProductImageForm2(Request $request,$id){

        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();

        if($request->hasFile("image")){
            $product=Product::find($id);
            $exists=$product->image2;
            try {
                if($exists){
                    $exists=Storage::disk("local")->exists('public/product_images/'.$product->image2);
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            //delete that image
            if($exists){
                Storage::delete('public/product_images/'.$product->image2);
                $imageName=$product->image2;
            }else{
                $ext =$request->file('image')->getClientOriginalExtension();
                $stringImageReFormat=str_replace(' ','2',$request->input('name'));
                $imageName=$stringImageReFormat.".".$ext;// add extention to the image

            }
            // upload that image
            //$request->file('image')->getClientOriginalExtension();//return jpg

            $request->image->storeAs("public/product_images/",$imageName);
            $arrayToUpdate=array('image2'=>$imageName);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProduct');
        }else{
            return 'no image was selected';
        }

    }


    public function updateProductImageForm3(Request $request,$id){
        Validator::make($request->all(),['image'=>"required|file|image|mimes:jpg,png,jpeg|max:2000"])->validate();

        if($request->hasFile("image")){
            $product=Product::find($id);
            $exists=$product->image3;
            try {
                if($exists){
                    $exists=Storage::disk("local")->exists('public/product_images/'.$product->image3);
                }
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            //delete that image
            if($exists){
                Storage::delete('public/product_images/'.$product->image3);
                $imageName=$product->image3;
            }else{
                $ext =$request->file('image')->getClientOriginalExtension();
                $stringImageReFormat=str_replace(' ','3',$request->input('name'));
                $imageName=$stringImageReFormat.".".$ext;// add extention to the image

            }
            // upload that image
            //$request->file('image')->getClientOriginalExtension();//return jpg

            $request->image->storeAs("public/product_images/",$imageName);
            $arrayToUpdate=array('image3'=>$imageName);
            DB::table('products')->where('id',$id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProduct');
        }else{
            return 'no image was selected';
        }

    }





    public function updateProduct(Request $request,$id){
        $name=$request->input('name');
        $description=$request->input('description');
        $price=$request->input('price');
        $stock=$request->input('stock');
        $type1=$request->input('type1');
        $type2=$request->input('type2');
        $type3= $request->input('type3');
        $slug= $request->input('slug');
        $ssdescription= $request->input('sdescription');
        $datasheet= $request->input('datasheet');
        $link= $request->input('link');

        $arrayToUpdate=array('Name'=>$name,'description'=>$description,'stock'=>$stock,'price'=>$price,'type1'=>$type1,'type2'=>$type2,'type3'=>$type3,'slug'=>$slug,'sdescription'=>$ssdescription,'datasheet'=>$datasheet,'link'=>$link);
        DB::table('products')->where('id',$id)->update($arrayToUpdate);
        return redirect()->route('adminDisplayProduct');

    }
}
