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

Route::resource('campaigns', App\Http\Controllers\CampaignController::class);

Route::middleware(['auth', 'role:publisher'])->group(function () {
    Route::get('/{user}/publisher/dashboard', [App\Http\Controllers\Publisher\DashboardController::class, 'index'])
        ->name('publisher.dashboard');
    Route::get('/publisher/dashboard', function() {
        return redirect('/' . Auth::id() . '/publisher/dashboard');
    });
    Route::get('/{user}/channels/create', [App\Http\Controllers\ChannelController::class, 'create'])->name('channels.create');
    Route::post('/{user}/channels', [App\Http\Controllers\ChannelController::class, 'store'])->name('channels.store');
    Route::get('/{user}/channels/{channel}/edit', [App\Http\Controllers\ChannelController::class, 'edit'])->name('channels.edit');
    Route::put('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'update'])->name('channels.update');
    Route::get('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'show'])->name('channels.show');
    Route::delete('/{user}/channels/{channel}', [App\Http\Controllers\ChannelController::class, 'destroy'])->name('channels.destroy');
});

Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::get('/{user}/advertiser/dashboard', [App\Http\Controllers\Advertiser\DashboardController::class, 'index'])
        ->name('advertiser.dashboard');
    Route::get('/advertiser/dashboard', function() {
        return redirect('/' . Auth::id() . '/advertiser/dashboard');
    });
});

