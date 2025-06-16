<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->employee) {
            
            abort(403, 'Unauthorized. Only employees can access this route.');
        }

        return $next($request);
    }
}

