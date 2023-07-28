<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(
    function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);

Route::prefix('cart')->middleware(['auth'])->group(function () {
    Route::post('add', [CartController::class, 'addItemToCart']);
    Route::delete('remove', [CartController::class, 'removeFromCart']);
    Route::get('items', [CartController::class, 'getCartItems']);
    Route::put('update', [CartController::class, 'updateCartItemQuantity']);
    Route::delete('clear', [CartController::class, 'clearCart']);
    Route::post('merge', [CartController::class, 'mergeCarts']);
});

Route::resource('orders', OrderController::class)->middleware(['auth']);
