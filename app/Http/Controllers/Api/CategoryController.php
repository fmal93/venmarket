<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->withFilters(
                request()->input('categories', []),
                request()->input('brands', []),
                request()->input('subcategories', [])
            );
        }])
        ->get();
    
        return new CategoryCollection($categories);
    }
}
