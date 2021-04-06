<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index()
    {
        $products = Product::has('productValue')->get();
        return view('home', ['products' => $products]);
    }
}
