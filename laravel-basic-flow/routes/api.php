<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('register',[AuthController::class,'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    Route::apiResource('blog-category', CategoryController::class);
    Route::apiResource('blog-post', BlogController::class);

    Route::group(['middleware' => 'auth:api'], static function() {

        Route::post('makePayment', [PaymentController::class, 'makePayment']);

    });
    Route::get('verifyTransaction', [PaymentController::class, 'verifyTransaction'])->name('verifyTransaction');
});