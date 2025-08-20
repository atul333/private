<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class RotateLogFiles extends Command
{
    protected $signature = 'logs:rotate';
    protected $description = 'Rotate log files and rename with date';

    public function handle()
    {
        // The app logs are now handled by Laravel's daily driver
        // This is just for any custom log files not handled by Laravel
        
        $logPath = '/logs/adlinker';
        $currentLogFile = $logPath . '/actions.log';

        if (File::exists($currentLogFile)) {
            // Get yesterday's date for the old log file name
            $yesterday = Carbon::yesterday()->format('Y-m-d');
            $newFileName = $logPath . '/actions-' . $yesterday . '.log';

            // Rename current log file with yesterday's date
            File::move($currentLogFile, $newFileName);

            // Create a new empty log file
            File::put($currentLogFile, '');
            File::chmod($currentLogFile, 0664);

            $this->info('Legacy log files rotated successfully.');
        }
        
        // Ensure storage/logs directory exists and has proper permissions
        $storageLogsPath = storage_path('logs');
        if (!File::exists($storageLogsPath)) {
            File::makeDirectory($storageLogsPath, 0775, true);
        }
        
        // Set proper permissions
        File::chmod($storageLogsPath, 0775);
        
        $this->info('Log rotation completed.');
    }
}