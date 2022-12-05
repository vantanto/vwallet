<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterControlller;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Middleware\EnsureWalletUser;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterControlller::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'categories'], function() {
        Route::get('/index', [CategoryController::class, 'index']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::get('/edit/{id}', [CategoryController::class, 'edit']);
        Route::post('/update/{id}', [CategoryController::class, 'update']);
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'transactions', 'middleware' => EnsureWalletUser::class], function() {
        Route::get('/create/{wallet}', [TransactionController::class, 'create']);
        Route::post('/store/{wallet}', [TransactionController::class, 'store']);
        Route::get('/edit/{wallet}/{id}', [TransactionController::class, 'edit']);
        Route::post('/update/{wallet}/{id}', [TransactionController::class, 'update']);
        Route::post('/destroy/{wallet}/{id}', [TransactionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'wallets'], function() {
        Route::get('/index', [WalletController::class, 'index']);
        Route::post('/store', [WalletController::class, 'store']);
        Route::get('/edit/{id}', [WalletController::Class, 'edit']);
        Route::get('/detail/{id}', [WalletController::class, 'detail']);
        Route::post('/update/{id}', [WalletController::class, 'update']);
        Route::post('/destroy/{id}', [WalletController::class, 'destroy']);
    });

    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);
});
