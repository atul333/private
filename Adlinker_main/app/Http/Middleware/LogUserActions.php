<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                'user_id' => $user->id,
                'email' => $user->email,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status_code' => $response->status(),
            ];

            // Add request parameters if any (excluding sensitive data)
            $input = $request->except(['password', 'password_confirmation']);
            if (!empty($input)) {
                $logData['request_data'] = json_encode($input);
            }

            // Log the action
            Log::channel('actions')->info('User Action', $logData);
        }

        return $response;
    }
}