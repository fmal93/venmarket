<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Http\Resources\SubCategoryCollection;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::withCount(['products' => function ($query) {
            $query->withFilters(
                request()->input('categories', []),
                request()->input('brands', []),
                request()->input('subcategories', [])
            );
        }])
        ->get();
    
        return new SubCategoryCollection($subcategories);
    }
}
