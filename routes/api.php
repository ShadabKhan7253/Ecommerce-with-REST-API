<?php

use App\Http\Controllers\Buyer\BuyerCategoriesController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyersController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoriesController;
use App\Http\Controllers\Category\CategoryBuyersController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionsController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Seller\SellerBuyersController;
use App\Http\Controllers\Seller\SellerCategoriesController;
use App\Http\Controllers\Seller\SellersController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionsController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UsersController;
use App\Models\Category;
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
Route::resource('buyers', BuyersController::class, ['only'=>['index', 'show']]);
Route::resource('sellers', SellersController::class, ['only'=>['index', 'show']]);
Route::resource('categories', CategoriesController::class, ['except'=>['create', 'edit']]);
Route::resource('products', ProductsController::class, ['only'=>['index', 'show']]);
Route::resource('transactions', TransactionsController::class, ['only'=>['index', 'show']]);

Route::resource('transactions.categories', TransactionCategoryController::class, ['only'=>'index']);
Route::resource('transactions.seller', TransactionSellerController::class, ['only'=>'index']);

Route::resource('buyers.transactions', BuyerTransactionController::class, ['only'=>'index']);
Route::resource('buyers.products', BuyerProductController::class, ['only'=>'index']);
Route::resource('buyers.sellers', BuyerSellerController::class, ['only'=>'index']);
Route::resource('buyers.categories', BuyerCategoriesController::class, ['only'=>'index']);

Route::resource('categories.products', CategoryProductController::class, ['only'=>'index']);
Route::resource('categories.sellers', CategorySellerController::class, ['only'=>'index']);
Route::resource('categories.transactions', CategoryTransactionsController::class, ['only'=>'index']);
Route::resource('categories.buyers', CategoryBuyersController::class, ['only'=>'index']);

Route::resource('sellers.transactions', SellerTransactionController::class, ['only'=>'index']);
Route::resource('sellers.categories', SellerCategoriesController::class, ['only'=>'index']);
Route::resource('sellers.buyers', SellerBuyersController::class, ['only'=>'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
