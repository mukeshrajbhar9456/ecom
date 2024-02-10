<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/product/index', [ProductController::class, 'index']);
    Route::post('admin/product/store', [ProductController::class, 'store']);
    Route::put('admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::put('admin/product/update/{id}', [ProductController::class, 'update']);
    Route::delete('admin/product/delete/{id}', [ProductController::class, 'delete']);
});
