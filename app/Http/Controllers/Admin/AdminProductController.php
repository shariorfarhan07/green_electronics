<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;
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

    public function bulkForm(){
        return view('admin.productsBulk');
    }

    /**
     * CSV columns are deliberately plain (id, sku, name, category, price, stock) so the
     * same file downloaded here can be edited (just the price column, usually) and
     * re-uploaded via import() below — id is what ties a row back to a product.
     */
    public function export(){
        $filename = 'products-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'sku', 'name', 'category', 'price', 'stock']);

            Product::with('category')->orderBy('id')->chunk(200, function ($products) use ($out) {
                foreach ($products as $product) {
                    fputcsv($out, [
                        $product->id,
                        $product->sku,
                        $product->name,
                        $product->category->name ?? '',
                        $product->price,
                        $product->stock,
                    ]);
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function import(Request $request){
        Validator::make($request->all(), [
            'csv' => 'required|file|mimes:csv,txt',
        ])->validate();

        $handle = fopen($request->file('csv')->getRealPath(), 'r');
        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            return redirect()->route('admin.products.bulk')->withErrors(['csv' => 'The file is empty or not a valid CSV.']);
        }

        $header = array_map(fn($h) => strtolower(trim($h)), $header);
        $idCol = array_search('id', $header);
        $priceCol = array_search('price', $header);

        if ($idCol === false || $priceCol === false) {
            fclose($handle);
            return redirect()->route('admin.products.bulk')->withErrors(['csv' => 'The CSV must have an "id" and a "price" column — export the current list first to get the right format.']);
        }

        $updated = 0;
        $errors = [];
        $row = 1;

        while (($data = fgetcsv($handle)) !== false) {
            $row++;
            $id = trim($data[$idCol] ?? '');
            $price = trim($data[$priceCol] ?? '');

            if ($id === '' && $price === '') {
                continue; // blank row
            }

            if (!ctype_digit($id)) {
                $errors[] = "Row {$row}: invalid id \"{$id}\".";
                continue;
            }

            if (!is_numeric($price) || $price < 0) {
                $errors[] = "Row {$row}: invalid price \"{$price}\" for id {$id}.";
                continue;
            }

            $product = Product::find($id);
            if (!$product) {
                $errors[] = "Row {$row}: no product with id {$id}.";
                continue;
            }

            $product->update(['price' => $price]);
            $updated++;
        }

        fclose($handle);

        return redirect()->route('admin.products.bulk')
            ->withsuccess("Updated {$updated} product price(s).")
            ->with('importErrors', array_slice($errors, 0, 25))
            ->with('importErrorCount', count($errors));
    }

    public function edit($id){
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::with('children')->roots()->get();
        return view('admin.editProductForm', ['product' => $product, 'categories' => $categories]);
    }

    public function storeImage(Request $request, $id){
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

        return redirect()->route('admin.products.edit', $product->id)->withsuccess('Image uploaded.');
    }

    public function destroyImage($imageId){
        $image = ProductImage::findOrFail($imageId);
        $productId = $image->product_id;

        $image->delete();
        $this->deleteFileIfUnused($image->path);

        return redirect()->route('admin.products.edit', $productId)->withsuccess('Image removed.');
    }

    /**
     * Seeded products share a placeholder file, so the file is only removed once no
     * other row still points at it — otherwise deleting one product's image would
     * blank out every product sharing that path.
     */
    private function deleteFileIfUnused($path){
        if (ProductImage::where('path', $path)->exists()) {
            return;
        }

        if (Storage::disk('public')->exists('product_images/'.$path)) {
            Storage::disk('public')->delete('product_images/'.$path);
        }
    }

   public function create(){
        $categories = Category::with('children')->roots()->get();
        return view('admin.createProductForm', ['categories' => $categories]);
   }
   public function destroy($id){
        $product = Product::with('images')->findOrFail($id);
        $paths = $product->images->pluck('path');

        $product->delete();

        foreach ($paths as $path) {
            $this->deleteFileIfUnused($path);
        }
        return redirect()->route('admin.products.index')->withsuccess('Product deleted.');
    }

   public function store(Request $request){
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

        return redirect()->route('admin.products.index')->withsuccess('Product created.');
   }

    public function update(Request $request,$id){
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

        return redirect()->route('admin.products.index')->withsuccess('Product updated.');

    }
}
