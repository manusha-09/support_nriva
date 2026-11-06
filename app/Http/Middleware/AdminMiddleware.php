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

        // ONLY Technology Chair ID
        if (Auth::user()->id != 1270) {
            return redirect('/member')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}