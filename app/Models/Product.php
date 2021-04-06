<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categoriy()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function productValue()
    {
        return $this->hasOne(ProductValue::class);
    }

    public function scopeWithFilters($query, $categories, $brands, $subcategories)
    {
        return $query->when(count($brands), function ($query) use ($brands) {
                $query->whereIn('brand_id', $brands);
            })
            ->when(count($categories), function ($query) use ($categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when(count($subcategories), function ($query) use ($subcategories) {
                $query->whereIn('sub_category_id', $subcategories);
            });
    }
}

