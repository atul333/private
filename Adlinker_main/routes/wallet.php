<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

// Publisher wallet routes
Route::middleware(['auth', 'role:publisher'])->group(function () {
    Route::prefix('{id}/publisher')->group(function () {
        Route::get('/wallet', [WalletController::class, 'index'])->name('publisher.wallet.index');
        Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('publisher.wallet.deposit');
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('publisher.wallet.withdraw');
    })->where('id', auth()->id());
});

// Advertiser wallet routes
Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::prefix('{id}/advertiser')->group(function () {
        Route::get('/wallet', [WalletController::class, 'index'])->name('advertiser.wallet.index');
        Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('advertiser.wallet.deposit');
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('advertiser.wallet.withdraw');
    })->where('id', auth()->id());
});