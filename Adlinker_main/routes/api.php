<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;

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

// Campaign routes
// Telegram webhook route
Route::post('/telegram/webhook', [\App\Http\Controllers\TelegramNotificationController::class, 'handleWebhook']);

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/campaigns/{id}/complete', [CampaignController::class, 'complete']);
    Route::post('/campaigns/{id}/expire', [CampaignController::class, 'expire']);
});
