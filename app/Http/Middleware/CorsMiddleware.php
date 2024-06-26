<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request  $request
* @param  \Closure  $next
* @return mixed
*/
public function handle(Request $request, Closure $next)
{
return $next($request)
->header('Access-Control-Allow-Origin', 'http://localhost:8081')
->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
->header('Access-Control-Allow-Credentials', 'true');
}
}