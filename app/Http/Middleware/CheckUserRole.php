<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    // Middleware CheckUserRole
    public function handle($request, Closure $next, $role)
    {
        // Vérifiez si l'utilisateur a le rôle requis
        if (!$request->user()->role === $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

}
