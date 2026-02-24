<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Auth;

class LogUserActions
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            
            // Prepare log data
            $logData = [
                'email' => $user->email,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'status_code' => method_exists($response, 'status') ? $response->status() : $response->getStatusCode(),
            ];

            // Add request parameters if any (excluding sensitive data)
            $input = $request->except(['password', 'password_confirmation']);
            if (!empty($input)) {
                $logData['request_data'] = json_encode($input);
            }

            // Determine the action based on the route
            $routeName = $request->route() ? $request->route()->getName() : 'Unknown';
            $action = $routeName ?: $request->method() . ':' . $request->path();

            // Log the action using our centralized logging service
            LoggingService::logActivity($action, 'User Action', $logData);
        }

        return $response;
    }
}