<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\Admin\ProductController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\user\ProductUserController;

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
    Route::post('admin-login', 'adminLogin');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// user product list

Route::get('', [ProductUserController::class, 'index']);
Route::get('/{id}', [ProductUserController::class, 'details']);





Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin/product/index', [ProductController::class, 'index']);
    Route::post('admin/product/store', [ProductController::class, 'store']);
    Route::put('admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::put('admin/product/update/{id}', [ProductController::class, 'update']);
    Route::delete('admin/product/delete/{id}', [ProductController::class, 'delete']);
    Route::get('admin/product/show/{id}', [ProductController::class, 'show']);
    // user route
    Route::get('admin/user/index', [UserController::class, 'index']);
    Route::post('admin/user/store', [UserController::class, 'store']);
    Route::put('admin/user/edit/{id}', [UserController::class, 'edit']);
    Route::put('admin/user/update/{id}', [UserController::class, 'update']);
    Route::delete('admin/user/delete/{id}', [UserController::class, 'delete']);
    Route::get('admin/user/show/{id}', [UserController::class, 'show']);

});
