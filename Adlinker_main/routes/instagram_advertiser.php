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

Route::middleware(['auth', 'role:advertiser'])->group(function () {
    
    // Dashboard
    Route::get('/{user}/instagram/advertiser/dashboard', [DashboardController::class, 'index'])->name('instagram.advertiser.dashboard');
    
    // Browse Profiles
    Route::get('/{user}/instagram/advertiser/profiles', [CampaignController::class, 'index'])->name('instagram.advertiser.profiles.index');
    
    // Campaign Management
    Route::get('/{user}/instagram/advertiser/profiles/{profile}/campaign/create', [CampaignController::class, 'create'])->name('instagram.advertiser.campaigns.create');
    Route::post('/{user}/instagram/advertiser/campaigns', [CampaignController::class, 'store'])->name('instagram.advertiser.campaigns.store');
    Route::get('/{user}/instagram/advertiser/campaigns/{campaign}', [CampaignController::class, 'show'])->name('instagram.advertiser.campaigns.show');
    Route::get('/{user}/instagram/advertiser/campaigns/{campaign}/payment', [CampaignController::class, 'payment'])->name('instagram.advertiser.campaigns.payment');
    Route::post('/{user}/instagram/advertiser/campaigns/{campaign}/payment', [CampaignController::class, 'processPayment'])->name('instagram.advertiser.campaigns.payment.process');
});
