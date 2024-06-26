<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsSupervisor
{
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role == 'supervisor') {
            return $next($request);
        }
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
