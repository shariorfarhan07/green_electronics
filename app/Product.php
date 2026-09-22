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
}
