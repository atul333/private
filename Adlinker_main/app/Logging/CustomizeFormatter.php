<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke(Logger $logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                // Format: [DATE_TIME] [LOG_LEVEL] [USER_ID or IP] [ACTION/ERROR] - MESSAGE
                "[%datetime%] [%level_name%] [%context.user_info%] [%context.action%] - %message% %context.exception%\n",
                'Y-m-d H:i:s',
                true,
                true
            ));
        }
    }
}