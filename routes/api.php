<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/store-books', [BookController::class, 'storeBooks']);
Route::get('/show-bookData', [BookController::class, 'showBooks']);
Route::post('/update-bookData/{id}', [BookController::class, 'updateBooks']);
Route::delete('/delete-bookData/{id}', [BookController::class, 'deleteBooks']);

Route::post('register', [RegistrationController::class, 'register']);
Route::post('login', [RegistrationController::class, 'login']);
Route::get('logout', [RegistrationController::class, 'logout']);
Route::post('forget-password', [RegistrationController::class, 'forgetPassword']);
Route::middleware('auth:api')->group(function () {

    Route::resource('products', ProductController::class);
    Route::post('store-products', [ProductController::class, 'store']);
    Route::get('show-products/{id}', [ProductController::class, 'show']);
    Route::post('update-products', [ProductController::class, 'update']);
    Route::get('delete-products', [ProductController::class, 'destroy']);
});
