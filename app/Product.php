<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'category_id', 'subcategory', 'brand',
        'description', 'short_description', 'specifications', 'video_url',
        'stock', 'sold', 'price',
    ];

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
     * Map order-item product ids to their first image path, in one query, for order
     * and invoice screens. Items whose product was since deleted are simply absent,
     * so callers fall back to a placeholder.
     */
    public static function imagesForOrderItems($items)
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
}
