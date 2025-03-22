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
    Route::resource('channels', App\Http\Controllers\ChannelController::class);
});

Auth::routes();

