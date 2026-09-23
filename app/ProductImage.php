<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'path', 'sort_order'];
    protected $appends = ['url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('local')->url('product_images/'.$this->path);
    }
}
