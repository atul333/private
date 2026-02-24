<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instagram\Publisher\DashboardController;
use App\Http\Controllers\Instagram\Publisher\ProfileController;

/*
|--------------------------------------------------------------------------
| Instagram Publisher Routes
|--------------------------------------------------------------------------
|
| Routes for Instagram publishers to manage their profiles and campaigns
|
*/

Route::middleware(['auth', 'role:publisher'])->group(function () {
    
    // Dashboard
    Route::get('/{user}/instagram/publisher/dashboard', [DashboardController::class, 'index'])->name('instagram.publisher.dashboard');
    
    // Profile Management
    Route::get('/{user}/instagram/publisher/profile/create', [ProfileController::class, 'create'])->name('instagram.publisher.profile.create');
    Route::post('/{user}/instagram/publisher/profile', [ProfileController::class, 'store'])->name('instagram.publisher.profile.store');
    Route::get('/{user}/instagram/publisher/profile/{profile}/edit', [ProfileController::class, 'edit'])->name('instagram.publisher.profile.edit');
    Route::put('/{user}/instagram/publisher/profile/{profile}', [ProfileController::class, 'update'])->name('instagram.publisher.profile.update');
    Route::delete('/{user}/instagram/publisher/profile/{profile}', [ProfileController::class, 'destroy'])->name('instagram.publisher.profile.destroy');
    
    // Profile Campaigns
    Route::get('/{user}/instagram/publisher/profile/{profile}/campaigns', [ProfileController::class, 'campaigns'])->name('instagram.publisher.profile.campaigns');
    Route::post('/{user}/instagram/publisher/profile/{profile}/campaigns/{campaign}/approve', [ProfileController::class, 'approveCampaign'])->name('instagram.publisher.campaign.approve');
    Route::post('/{user}/instagram/publisher/profile/{profile}/campaigns/{campaign}/reject', [ProfileController::class, 'rejectCampaign'])->name('instagram.publisher.campaign.reject');
    Route::post('/{user}/instagram/publisher/profile/{profile}/campaigns/{campaign}/submit-story', [ProfileController::class, 'submitStoryLink'])->name('instagram.publisher.campaign.submit-story');
    Route::get('/{user}/instagram/publisher/profile/{profile}/campaigns/{campaign}/download', [ProfileController::class, 'downloadMedia'])->name('instagram.publisher.campaign.download');
});
