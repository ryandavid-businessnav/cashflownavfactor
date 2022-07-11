<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubsubController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TokenController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AccountController::class, 'get']);
    Route::post('/signout', [AccountController::class, 'signout']);
    Route::post('/signout', [AccountController::class, 'signout']);
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']); // add this
});

Route::post('/sanctum/token', [TokenController::class, 'get']);
Route::post('/pubsub', [PubsubController::class, 'subscribe']);