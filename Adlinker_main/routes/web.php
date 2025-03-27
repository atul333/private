<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

// Include auth routes
require __DIR__.'/auth.php';

// Redirect root to home
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'advertiser') {
            return redirect('/advertiser/dashboard');
        } else if ($user->role === 'publisher') {
            return redirect('/publisher/dashboard');
        }
    }
    return view('welcome');
});

Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::get('/{user}/campaigns', [App\Http\Controllers\CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/{user}/campaigns/create', [App\Http\Controllers\CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/{user}/campaigns', [App\Http\Controllers\CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/{user}/campaigns/{campaign}/edit', [App\Http\Controllers\CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/{user}/campaigns/channel/{channel}', [App\Http\Controllers\CampaignController::class, 'showChannelDetails'])->name('campaigns.channel.details');

    // Simple Payment Route
    Route::get('/{user}/campaigns/{campaign}/payment', [App\Http\Controllers\CampaignController::class, 'processPayment'])->name('campaigns.payment.process');
Route::get('/{user}/campaigns/{campaign}/payment/create', [App\Http\Controllers\CampaignController::class, 'processPayment'])->name('campaigns.payment.create');

    // Redirect /id/campaigns/channel/{channel} to user-specific channel details
    Route::get('/id/campaigns/channel/{channel}', function($channel) {
        return redirect('/' . Auth::id() . '/campaigns/channel/' . $channel);
    });
});

// Redirect /campaigns to user-specific campaigns
Route::get('/campaigns', function() {
    return redirect('/' . Auth::id() . '/campaigns');
});

Route::middleware(['auth', 'role:publisher'])->group(function () {
    Route::get('/{user}/publisher/dashboard', [App\Http\Controllers\Publisher\DashboardController::class, 'index'])
        ->name('publisher.dashboard');

    Route::get('/{user}/publisher/channels/{channel}/campaigns', [\App\Http\Controllers\Publisher\CampaignStatusController::class, 'show'])
        ->name('publisher.channel.campaigns');

Route::post('/publisher/campaign/{campaign}/accept', [\App\Http\Controllers\Publisher\CampaignActionController::class, 'accept'])
->name('publisher.campaign.accept');

Route::post('/publisher/campaign/{campaign}/reject', [\App\Http\Controllers\Publisher\CampaignActionController::class, 'reject'])
->name('publisher.campaign.reject');

Route::get('/publisher/campaign/{campaign}/submit-link', [\App\Http\Controllers\Publisher\CampaignActionController::class, 'showSubmitLinkForm'])
->name('publisher.campaign.submit-link.form');

Route::post('/publisher/campaign/{campaign}/submit-link', [\App\Http\Controllers\Publisher\CampaignActionController::class, 'submitLink'])
->name('publisher.campaign.submit-link');
    Route::get('/publisher/dashboard', function() {
        return redirect('/' . Auth::id() . '/publisher/dashboard');
    });
    Route::get('/{user}/channels/create', [App\Http\Controllers\ChannelController::class, 'create'])->name('channels.create');
    Route::post('/{user}/channels', [App\Http\Controllers\ChannelController::class, 'store'])->name('channels.store');
    Route::get('/{user}/channels/{channel}/edit', [App\Http\Controllers\ChannelController::class, 'edit'])->name('channels.edit');
    Route::put('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'update'])->name('channels.update');
    Route::get('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'show'])->name('channels.show');
    Route::delete('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'destroy'])->name('channels.destroy');

    // Withdrawal Routes
    Route::get('/withdrawals', [App\Http\Controllers\Publisher\WithdrawalController::class, 'index'])->name('publisher.withdrawals.index');
    Route::get('/withdrawals/create', [App\Http\Controllers\Publisher\WithdrawalController::class, 'create'])->name('publisher.withdrawals.create');
    Route::post('/withdrawals', [App\Http\Controllers\Publisher\WithdrawalController::class, 'store'])->name('publisher.withdrawals.store');
});

Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::get('/{user}/advertiser/dashboard', [App\Http\Controllers\Advertiser\DashboardController::class, 'index'])
        ->name('advertiser.dashboard');
    Route::get('/advertiser/dashboard', function() {
        return redirect('/' . Auth::id() . '/advertiser/dashboard');
    });
});

