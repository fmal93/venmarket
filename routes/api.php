<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Resources\RegionCollection;
use App\Models\Region;
use App\Http\Resources\ComunaCollection;
use App\Http\Resources\ComunaResource;
use App\Models\Comuna;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/subcategories', [SubCategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/regions', function () {
    return new RegionCollection(Region::all());
});
Route::get('/comunas', function () {
    return new ComunaCollection(Comuna::all());
});
Route::get('/comuna/{id}', function ($id) {
    $comunas = Comuna::where('region_id', '=', $id)->get();
    return new ComunaCollection($comunas);
});
Route::get('/comunas/{id}', function ($id) {
    return new ComunaResource(Comuna::findOrFail($id));
});


