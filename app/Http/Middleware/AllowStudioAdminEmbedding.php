<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowStudioAdminEmbedding
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Content-Security-Policy',
            "frame-ancestors 'self' https://studio.flowsee.ir",
        );
        // CSP frame-ancestors is the allowlist; X-Frame-Options would block
        // the cross-subdomain studio frame in browsers that still honor it.
        $response->headers->remove('X-Frame-Options');

        return $response;
    }
}
