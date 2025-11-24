<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instagram\Advertiser\DashboardController;
use App\Http\Controllers\Instagram\Advertiser\CampaignController;

/*
|--------------------------------------------------------------------------
| Instagram Advertiser Routes
|--------------------------------------------------------------------------
|
| Routes for Instagram advertisers to browse profiles and create campaigns
|
*/

Route::middleware(['auth', 'role:advertiser'])->prefix('instagram/advertiser')->name('instagram.advertiser.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Browse Profiles
    Route::get('/profiles', [CampaignController::class, 'index'])->name('profiles.index');
    
    // Campaign Management
    Route::get('/profiles/{profile}/campaign/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/campaigns/{campaign}/payment', [CampaignController::class, 'payment'])->name('campaigns.payment');
    Route::post('/campaigns/{campaign}/payment', [CampaignController::class, 'processPayment'])->name('campaigns.payment.process');
    
    // Campaign History
    Route::get('/campaigns-history', [CampaignController::class, 'history'])->name('campaigns.history');
});
