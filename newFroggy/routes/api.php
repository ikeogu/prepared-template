<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\CallLogController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('populate-users', [ActionController::class, 'populateUser']);

Route::get('populate-database', [ActionController::class,'populateDataBase']);

Route::get('fetch-logs', [CallLogController::class, 'index']);
