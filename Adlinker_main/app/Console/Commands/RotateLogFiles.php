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

            $this->info('Log files rotated successfully.');
        } else {
            $this->warn('No log file found to rotate.');
        }
    }
}