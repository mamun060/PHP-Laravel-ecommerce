<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Category;
use App\Models\ProductTag;
use App\Models\ProductSize;
use App\Models\Subcategory;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Model;



class Product extends Model
{

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }



    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }


    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    // ->withPivot('color_name')
    
    public function colors($select='*')
    {
        return $this->hasMany(ProductVariantPrice::class, 'product_id','id')
                ->selectRaw($select);
    }

    public function sizes($select='*')
    {
        return $this->hasMany(ProductVariantPrice::class, 'product_id', 'id')
        ->selectRaw($select);

    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariantPrice::class, 'product_variant_prices', 'product_id', 'size_name')->withTimestamps();
    }
    


    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'product_brand')
        ->withPivot('brand_name');
    }

    public function productImages()
    {
        return $this->hasMany(ProductGallery::class);
    }


    public function tags()
    {
        return $this->belongsToMany(ProductTag::class, 'product_tags', 'product_id', 'tag_name');
    }


    public function singleProductTags()
    {
        return $this->hasMany(ProductTag::class,'product_id');
    }


    public function comments()
    {
        return $this->morphMany(Review::class, 'commentable');
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }



    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    
}
