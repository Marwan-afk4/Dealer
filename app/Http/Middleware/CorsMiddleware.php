<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add the CORS headers to the response
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Allow all origins
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // Allow these methods
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With'); // Allow these headers

        return $response;
    }
}
