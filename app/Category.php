<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'icon', 'blurb', 'sort_order'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function isRoot()
    {
        return $this->parent_id === null;
    }

    /**
     * This category's id plus all of its children's, so filtering a top-level
     * section returns everything beneath it rather than nothing.
     */
    public function selfAndDescendantIds()
    {
        return $this->children->pluck('id')->push($this->id)->all();
    }
}
