<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ChatController;

// Include wallet routes
Route::middleware(['auth'])->group(function () {
    // Razorpay Routes
    Route::post('/razorpay/create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.create.order');
    Route::post('/razorpay/verify-payment', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify.payment');
    require __DIR__.'/wallet.php';

    // Chat routes
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/mark-as-read', [ChatController::class, 'markAsRead'])->name('chat.mark-as-read');
});
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

// Policy and Information Routes
Route::get('/terms', function () { return view('terms'); })->name('terms');
Route::get('/privacy', function () { return view('privacy'); })->name('privacy');
Route::get('/refund', function () { return view('refund'); })->name('refund');
Route::get('/cancellation', function () { return view('cancellation'); })->name('cancellation');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/faq', function () { return view('faq'); })->name('faq');

// Redirect root to home or platform selection
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('platform.selection');
    }
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Platform Selection Routes (MUST BE BEFORE TELEGRAM ROUTES)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\PlatformSelectionController;

Route::middleware(['auth'])->group(function () {
    Route::get('/platform-selection', [PlatformSelectionController::class, 'index'])->name('platform.selection');
    Route::post('/platform-select', [PlatformSelectionController::class, 'selectPlatform'])->name('platform.select');
    Route::get('/platform/{platform}/coming-soon', [PlatformSelectionController::class, 'comingSoon'])->name('platform.coming-soon');
});

/*
|--------------------------------------------------------------------------
| Instagram Routes (MUST BE BEFORE TELEGRAM ROUTES)
|--------------------------------------------------------------------------
*/
require __DIR__.'/instagram_publisher.php';
require __DIR__.'/instagram_advertiser.php';

/*
|--------------------------------------------------------------------------
| Telegram Routes (WITH WILDCARD {user} PARAMETER)
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::get('/{user}/campaigns', [App\Http\Controllers\CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/{user}/campaigns/create', [App\Http\Controllers\CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/{user}/campaigns', [App\Http\Controllers\CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/{user}/campaigns/{campaign}/edit', [App\Http\Controllers\CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/{user}/campaigns/{campaign}', [App\Http\Controllers\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/{user}/campaigns/channel/{channel}', [App\Http\Controllers\CampaignController::class, 'showChannelDetails'])->name('campaigns.channel.details');
    
    // Add campaign expire route here
    Route::post('/{user}/advertiser/campaigns/{campaign}/expire', [App\Http\Controllers\Api\CampaignController::class, 'expire'])
        ->name('advertiser.campaigns.expire');

    // Simple Payment Route
    Route::get('/{user}/campaigns/{campaign}/payment', [App\Http\Controllers\CampaignController::class, 'processPayment'])->name('campaigns.payment.process');
Route::get('/{user}/campaigns/{campaign}/payment/create', [App\Http\Controllers\CampaignController::class, 'processPayment'])->name('campaigns.payment.create');

// Campaign Refund API Route
Route::post('/api/campaigns/{campaign}/refund', [App\Http\Controllers\Api\CampaignRefundController::class, 'refund'])->name('api.campaigns.refund');

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
