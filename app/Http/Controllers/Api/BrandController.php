<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Resources\BrandCollection;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount(['products' => function ($query) {
            $query->withFilters(
                request()->input('categories', []),
                request()->input('brands', []),
                request()->input('subcategories', [])
            );
        }])
        ->get();
    
        return new BrandCollection($brands);
    }
}
