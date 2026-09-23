<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'category_id', 'subcategory', 'brand',
        'description', 'short_description', 'specifications', 'video_url',
        'stock', 'sold', 'price',
    ];

    protected $appends = ['primary_image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images->first()->path ?? null;
    }

    /**
     * Full URL of the primary image, for API/Inertia responses where the
     * frontend can't call the Storage facade itself.
     */
    public function getPrimaryImageUrlAttribute()
    {
        $path = $this->primary_image;

        return $path ? Storage::disk('local')->url('product_images/'.$path) : null;
    }

    /**
     * Map order-item product ids to their first image path, in one query, for order
     * and invoice screens. Items whose product was since deleted are simply absent,
     * so callers fall back to a placeholder.
     */
    private static function imagesForOrderItems($items)
    {
        $ids = collect($items)->pluck('item_id')->filter()->unique();

        if ($ids->isEmpty()) {
            return collect();
        }

        return static::with('images')->whereIn('id', $ids)->get()
            ->mapWithKeys(function ($product) {
                return [$product->id => $product->primary_image];
            });
    }

    /**
     * Same as imagesForOrderItems, but as full URLs — Inertia pages can't call
     * the Storage facade to build them the way Blade did.
     */
    public static function imageUrlsForOrderItems($items)
    {
        return static::imagesForOrderItems($items)->map(function ($path) {
            return $path ? Storage::disk('local')->url('product_images/'.$path) : null;
        });
    }
}
