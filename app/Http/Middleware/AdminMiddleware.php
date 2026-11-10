<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Admin access follows the role assigned in the shared NRIVA database.
        if (!Auth::user()->isSupportAdmin()) {
            return redirect('/member')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
