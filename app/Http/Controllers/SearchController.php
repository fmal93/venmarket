<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\SubCategory;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'keyword' => 'required|min:3',
        ]);

        $keyword = str_replace(" ", "%%", preg_replace("/\s+/", " ", trim(request()->input('keyword'))));


        $products = Product::where('name', 'like', "%$keyword%")->orWhere('description', 'like', "%$keyword%")->get();

        if (count($products) == 0) {
            
            $brand = Brand::where('name', 'like', "%$keyword%")->first();
            $subCategory = SubCategory::where('name', 'like', "%$keyword%")->first();   
            if ($subCategory) {
                $products = Product::where('sub_category_id', '=', $subCategory->id)->get();
                return view('product.busqueda', compact('products')); 
            }
            if ($brand) {
                $products = Product::where('brand_id', '=', $brand->id)->get();
                return view('product.busqueda', compact('products'));
            }
        }

        return view('product.busqueda', compact('products'));        
        
    }
}
