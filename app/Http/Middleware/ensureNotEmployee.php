<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureNotEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || Auth::user()->employee) {

            abort(403, 'Unauthorized. Only Company Admin can access this route.');
        }

        return $next($request);
    }
}
