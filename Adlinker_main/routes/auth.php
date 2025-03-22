<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('web')->group(function () {
    // Advertiser routes
    Route::prefix('advertiser')->group(function () {
        Route::get('/dashboard', function () {
            return view('advertiser.dashboard');
        })->middleware('auth');
    });

    // Publisher routes
    Route::prefix('publisher')->group(function () {
        Route::get('/dashboard', function () {
            return view('publisher.dashboard');
        })->middleware('auth');
    });
});