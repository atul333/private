<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublisherAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $requestedUserId = $request->route('user');

        if ($user->id != $requestedUserId) {
            return redirect('/' . $user->id . '/publisher/dashboard');
        }

        return $next($request);
    }
}