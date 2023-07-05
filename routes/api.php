<?php

use App\Http\Controllers\Seller\SellersController;
use App\Http\Controllers\User\UsersController;
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

Route::resource('users', UsersController::class, ['except'=>['create', 'edit']]);
Route::resource('buyers', \App\Http\Controllers\Buyer\BuyersController::class, ['only'=>['index', 'show']]);
Route::resource('sellers', SellersController::class, ['only'=>['index', 'show']]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
