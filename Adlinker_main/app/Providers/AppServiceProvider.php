<?php

namespace App\Providers;

use App\Models\Withdrawal;
use App\Observers\WithdrawalObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Withdrawal::observe(WithdrawalObserver::class);
    }
}
