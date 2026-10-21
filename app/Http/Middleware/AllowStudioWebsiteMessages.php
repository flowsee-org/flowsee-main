<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowStudioWebsiteMessages
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('OPTIONS')) {
            $response = response()->noContent();
        } else {
            $response = $next($request);
        }

        // Allow any origin configured for the Studio API (local + production),
        // never a hard-coded domain.
        $allowedOrigins = config('cors.allowed_origins', []);
        $origin = $request->headers->get('Origin');

        if (is_array($allowedOrigins) && $origin !== null && in_array($origin, $allowedOrigins, true)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept');
            $response->headers->set('Access-Control-Max-Age', '600');
            $response->headers->set('Vary', 'Origin');
        }

        return $response;
    }
}
