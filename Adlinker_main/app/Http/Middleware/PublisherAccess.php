<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PublisherAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $urlUserId = $request->route('user');
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser || $authenticatedUser->id != $urlUserId) {
            abort(403, 'Unauthorized access to publisher dashboard.');
        }

        return $next($request);
    }
}