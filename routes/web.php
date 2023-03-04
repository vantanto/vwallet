<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Middleware\EnsureWalletUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/index', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');
    });

    Route::group(['prefix' => 'transactions', 'middleware' => EnsureWalletUser::class], function() {
        Route::get('/create/{wallet}', [TransactionController::class, 'create'])
            ->name('transactions.create');
        Route::post('/store/{wallet}', [TransactionController::class, 'store'])
            ->name('transactions.store');
        Route::get('/edit/{wallet}/{id}', [TransactionController::class, 'edit'])
            ->name('transactions.edit');
        Route::post('/update/{wallet}/{id}', [TransactionController::class, 'update'])
            ->name('transactions.update');
        Route::post('/destroy/{wallet}/{id}', [TransactionController::class, 'destroy'])
            ->name('transactions.destroy');
        Route::post('/load-more/{wallet}/{offset}', [TransactionController::class, 'loadMore'])
            ->name('transactions.load-more');
    });
    
    Route::group(['prefix' => 'wallets'], function() {
        Route::get('/index', [WalletController::class, 'index'])
            ->name('wallets.index');
        Route::get('/create', [WalletController::class, 'create'])
            ->name('wallets.create');
        Route::post('/store', [WalletController::class, 'store'])
            ->name('wallets.store');
        Route::get('/edit/{id}', [WalletController::Class, 'edit'])
            ->name('wallets.edit');
        Route::get('/detail/{id}', [WalletController::class, 'detail'])
            ->name('wallets.detail');
        Route::post('/update/{id}', [WalletController::class, 'update'])
            ->name('wallets.update');
        Route::post('/destroy/{id}', [WalletController::class, 'destroy'])
            ->name('wallets.destroy');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])
    //     ->name('profile.destroy');
});

require __DIR__.'/auth.php';
