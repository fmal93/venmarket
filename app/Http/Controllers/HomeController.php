<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\Contac;

class HomeController extends Controller
{
    public function Index()
    {
        $products = Product::has('productValue')->get();
        $recommended = Product::Where('recommended', '=', true)->take(15)->get();
        $categories_recommended = Category::Where('recommended', '=', true)->take(3)->get();
        return view('home', ['products' => $products, 'recommended' => $recommended, 'categories_recommended' => $categories_recommended]);
    }
}
