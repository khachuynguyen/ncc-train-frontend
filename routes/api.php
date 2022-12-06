<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SlidesController;
use App\Http\Requests\TestRequest;
use App\Supports\CheckValidateImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')->group(function () {
    //get all categories\
    Route::get('', [CategoriesController::class, 'index']);
    Route::get('/{cateId}/manufacturers', [ProductsController::class, 'getManuByCateId']);
});

Route::prefix('manufacturers')->group(function () {
    //get all manufacturers
    Route::get('', [ManufacturersController::class, 'index']);
});

Route::prefix('products')->group(function () {
    Route::middleware('auth:api')->group(function () {
        //add product
        Route::post('', [ProductsController::class, 'storeProduct']);
        //delete product
        Route::delete('/{id}', [ProductsController::class, 'deleteProduct']);
        //edit product
        Route::put('', [ProductsController::class, 'updateProduct']);
    });
    //get product by id
    Route::get('/{id}', [ProductsController::class, 'getById']);
    //get all products
    Route::get('', [ProductsController::class, 'index']);
    //get product by category
    Route::get('/categories/{cateId}', [ProductsController::class, 'getProductByCateId']);
    //get product by cateid and manuid
    Route::get('categories/{cateid?}/manufacturers/{manuid?}', [ProductsController::class, 'getProductByCateManu']);
    //get product by manuid
    Route::get('/manufacturers/{manuid?}', [ProductsController::class, 'getProductByManuId']);
});

Route::get('/search', [ProductsController::class, 'searchProduct']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
