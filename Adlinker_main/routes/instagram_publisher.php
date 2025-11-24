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

Route::middleware(['auth', 'role:publisher'])->prefix('instagram/publisher')->name('instagram.publisher.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{profile}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile Campaigns
    Route::get('/profile/{profile}/campaigns', [ProfileController::class, 'campaigns'])->name('profile.campaigns');
});
