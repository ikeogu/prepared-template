<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
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
Route::group(['middleware' => ['cors', 'json.response']], static function () {
   Route::group(['prefix' => 'v1'], static function () {
        Route::any('/', static fn () => response()->json([
            'message' => 'Welcome to IIARPUB API',
            'apiVersion' => 'v2.0.0',
        ]));

        Route::group(['prefix' => 'auth'], static function () {
            Route::post('login', [AuthController::class, 'login'])->name('login');
            Route::post('register', [AuthController::class, 'register'])->name('register');

            Route::post('confirm-email', [AuthController::class, 'confirmEmail'])->name('confirm-email');
            Route::post('password-reset', [AuthController::class, 'resetPasword'])->name('password-reset');
            Route::post('password-reset-verify-otp', [AuthController::class, 'verifyForgetonPasswordOtp'])->name('password-reset-verify-otp');
            Route::post('password-reset-confirm-email', [AuthController::class, 'confirmEmail'])->name('password-reset-confirm-email');

        });

        //Auth Routes
        Route::group(['middleware' => ['auth:api']], static function () {

            Route::prefix('auth')->group(function () {
                Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
                Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');
                Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
            });
             Route::apiResource('category', CategoryController::class);
        });
   });
}) ;