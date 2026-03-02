<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Throwable;

class LoggingService
{
    /**
     * Log user activity
     *
     * @param string $action The action being performed
     * @param string $message The log message
     * @param array $context Additional context data
     * @return void
     */
    public static function logActivity(string $action, string $message, array $context = [])
    {
        $userId = 'Unknown';
        $userIp = 'Unknown';
        
        try {
            if (app()->bound('auth')) {
                $userId = Auth::check() ? Auth::id() : 'Guest';
            }
            if (app()->bound('request')) {
                $userIp = Request::ip();
            }
        } catch (\Throwable $e) {
            // Silently handle if request/auth isn't fully loaded
        }
        
        $context['user_info'] = "User:{$userId} IP:{$userIp}";
        $context['action'] = $action;
        
        // Remove any sensitive data
        $context = self::removeSensitiveData($context);
        
        Log::info($message, $context);
    }
    
    /**
     * Log an exception or error
     *
     * @param string $action The action during which the error occurred
     * @param string $message The error message
     * @param Throwable|null $exception The exception object
     * @param array $context Additional context data
     * @return void
     */
    public static function logError(string $action, string $message, ?Throwable $exception = null, array $context = [])
    {
        $userId = 'Unknown';
        $userIp = 'Unknown';
        
        try {
            if (app()->bound('auth')) {
                $userId = Auth::check() ? Auth::id() : 'Guest';
            }
            if (app()->bound('request')) {
                $userIp = Request::ip();
            }
        } catch (\Throwable $e) {
            // Silently handle if request/auth isn't fully loaded
        }
        
        $context['user_info'] = "User:{$userId} IP:{$userIp}";
        $context['action'] = $action;
        
        if ($exception) {
            $context['exception'] = "\n[Exception] {$exception->getMessage()}\n[Trace] {$exception->getTraceAsString()}";
        }
        
        // Remove any sensitive data
        $context = self::removeSensitiveData($context);
        
        Log::error($message, $context);
    }
    
    /**
     * Remove sensitive data from the context array
     *
     * @param array $context
     * @return array
     */
    private static function removeSensitiveData(array $context)
    {
        $sensitiveKeys = [
            'password', 'password_confirmation', 'token', 'api_key', 'secret',
            'credit_card', 'card_number', 'cvv', 'ssn', 'social_security'
        ];
        
        foreach ($sensitiveKeys as $key) {
            if (isset($context[$key])) {
                $context[$key] = '[REDACTED]';
            }
        }
        
        return $context;
    }
}