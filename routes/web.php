<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/product', [ShopController::class, 'index']);
Route::get('/product/{slug}', [ShopController::class, 'show']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::post('/checkout', [CheckoutController::class, 'initTransaction']);
Route::get('/checkout-form', [CheckoutController::class, 'getCheckoutForm']);
Route::post('/checkout-return', [CheckoutController::class, 'confirmTransaction']);

Route::get('/carrito', [CartController::class, 'index']);
Route::get('/add-to-cart/{id}', [CartController::class, 'getAddToCart']);
Route::get('/remove/{id}', [CartController::class, 'getRemoveItem']);
Route::get('/update-cart', [CartController::class, 'getupdateItem']);
Route::get('/add-many', [CartController::class, 'getAddManyItem']);
Route::get('/get-discount', [CartController::class, 'getDiscountItems']);

Route::get('/busqueda', [SearchController::class, 'index']);

