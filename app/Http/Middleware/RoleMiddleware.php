<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if user is logged in AND if their role matches the requirement
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // If they don't have the right role, kick them back to the dashboard
        return redirect('dashboard')->with('error', 'You do not have access to this page.');
    }
}