<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Services\LoggingService;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            $this->logException($e);
        });
    }
    
    /**
     * Log the exception using our centralized logging service.
     *
     * @param \Throwable $exception
     * @return void
     */
    protected function logException(Throwable $exception): void
    {
        $request = request();
        $path = $request->path();
        $method = $request->method();
        
        $context = [
            'url' => $request->fullUrl(),
            'method' => $method,
            'inputs' => $request->except($this->dontFlash),
        ];
        
        LoggingService::logError(
            'Exception',
            "Exception occurred in {$method}:{$path}",
            $exception,
            $context
        );
    }
}
