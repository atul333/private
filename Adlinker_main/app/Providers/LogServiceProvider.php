<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Ensure log directory exists
        $logPath = '/logs/adlinker';
        if (!File::exists($logPath)) {
            File::makeDirectory($logPath, 0775, true);
        }

        // Set proper permissions
        File::chmod($logPath, 0775);
    }
}