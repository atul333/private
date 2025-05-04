<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\TelegramNotificationController;

Route::post('/webhook', [TelegramController::class, 'handleWebhook']);
Route::middleware('auth')->group(function () {
    Route::post('/link-account', [TelegramNotificationController::class, 'linkTelegramAccount']);
});