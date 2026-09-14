<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // Geolocation is used by the attendance-location page. Restrict it to this
        // application origin while keeping camera and microphone disabled.
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        return $response;
    }
}
