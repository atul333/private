<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

// Publisher wallet routes
Route::middleware(['auth', 'role:publisher'])->group(function () {
    Route::prefix('{id}/publisher')->group(function () {
        Route::get('/wallet', [WalletController::class, 'index'])->name('publisher.wallet.index');
        Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('publisher.wallet.deposit');
        Route::get('/wallet/withdraw', [WalletController::class, 'showWithdrawForm'])->name('publisher.wallet.withdraw');
        Route::post('/wallet/withdraw', [WalletController::class, 'processWithdrawal'])->name('publisher.wallet.process-withdrawal');
    })->where('id', auth()->id());
});

// Advertiser wallet routes
Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::prefix('{id}/advertiser')->group(function () {
        Route::get('/wallet', [WalletController::class, 'index'])->name('advertiser.wallet.index');
        Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('advertiser.wallet.deposit');
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('advertiser.wallet.withdraw');
        Route::get('/wallet/add-funds', [WalletController::class, 'showAddFundsForm'])->name('advertiser.wallet.add-funds-form');
        Route::post('/wallet/add-funds', [WalletController::class, 'addFunds'])->name('advertiser.wallet.add-funds');
    })->where('id', auth()->id());
});

// Admin: Mark withdrawal as payment done
Route::middleware(['auth'])->post('/wallet/withdrawals/{withdrawal}/mark-done', [WalletController::class, 'markPaymentDone'])->name('wallet.withdrawal.mark-done');