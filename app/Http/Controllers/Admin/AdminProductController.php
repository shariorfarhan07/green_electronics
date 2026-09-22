<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
use App\Order;
use App\Orders_Items;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;



class AdminProductController extends Controller
{
    //
    public function index(){
        $products = Product::with(['category', 'images'])->orderBy('created_at', 'desc')->paginate(10);
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
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.editProductForm', ['product' => $product, 'categories' => $categories]);
    }

    public function manageProductImages($id){
        $product = Product::with('images')->findOrFail($id);
        return view('admin.manageProductImages', ['product' => $product]);
    }

    public function uploadProductImage(Request $request, $id){
        $product = Product::findOrFail($id);

        Validator::make($request->all(), [
            'images' => 'required',
            'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:2000',
        ])->validate();

        $nextOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $file) {
            $imageName = Str::slug($product->name).'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/product_images', $imageName);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $imageName,
                'sort_order' => $nextOrder++,
            ]);
        }

        return redirect()->route('manageProductImages', $product->id)->withsuccess('Image uploaded.');
    }

    public function deleteProductImage($imageId){
        $image = ProductImage::findOrFail($imageId);
        $productId = $image->product_id;

        if (Storage::disk('public')->exists('product_images/'.$image->path)) {
            Storage::disk('public')->delete('product_images/'.$image->path);
        }
        $image->delete();

        return redirect()->route('manageProductImages', $productId);
    }

   public function createProductForm(){
        $categories = Category::orderBy('name')->get();
        return view('admin.createProductForm', ['categories' => $categories]);
   }
   public function deleteProduct($id){
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists('product_images/'.$image->path)) {
                Storage::disk('public')->delete('product_images/'.$image->path);
            }
        }

        $product->delete();
        return redirect()->route('adminDisplayProduct');
    }

   public function sendCreateProductForm(Request $request){
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required',
            'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:2000',
        ])->validate();

        $name = $request->input('name');
        $slug = $request->input('slug') ?: Str::slug($name);

        $product = Product::create([
            'name' => $name,
            'slug' => $slug,
            'sku' => $request->input('sku') ?: strtoupper(Str::random(3)).'-'.rand(1000, 9999),
            'category_id' => $request->input('category_id'),
            'subcategory' => $request->input('subcategory'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'specifications' => $request->input('specifications'),
            'video_url' => $request->input('video_url'),
            'stock' => $request->input('stock'),
            'sold' => 0,
            'price' => $request->input('price'),
        ]);

        $order = 0;
        foreach ($request->file('images') as $file) {
            $imageName = Str::slug($name).'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/product_images', $imageName);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $imageName,
                'sort_order' => $order++,
            ]);
        }

        return redirect()->route('adminDisplayProduct')->withsuccess('Product created.');
   }

    public function updateProduct(Request $request,$id){
        $product = Product::findOrFail($id);

        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ])->validate();

        $product->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug') ?: $product->slug,
            'sku' => $request->input('sku') ?: $product->sku,
            'category_id' => $request->input('category_id'),
            'subcategory' => $request->input('subcategory'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'specifications' => $request->input('specifications'),
            'video_url' => $request->input('video_url'),
            'stock' => $request->input('stock'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('adminDisplayProduct')->withsuccess('Product updated.');

    }
}
