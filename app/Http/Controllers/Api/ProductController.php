<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::has('productImage')->withFilters(
            request()->input('categories', []),
            request()->input('brands', []),
            request()->input('subcategories', [])
        )->paginate(20);
    
        return new ProductCollection($products);
    }
}
