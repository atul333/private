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
        // Ensure legacy log directory exists
        $legacyLogPath = '/logs/adlinker';
        if (!File::exists($legacyLogPath)) {
            File::makeDirectory($legacyLogPath, 0775, true);
        }
        File::chmod($legacyLogPath, 0775);
        
        // Ensure storage/logs directory exists
        $storageLogsPath = storage_path('logs');
        if (!File::exists($storageLogsPath)) {
            File::makeDirectory($storageLogsPath, 0775, true);
        }
        File::chmod($storageLogsPath, 0775);
    }
}