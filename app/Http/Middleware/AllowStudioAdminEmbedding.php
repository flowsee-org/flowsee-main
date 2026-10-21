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

        // frame-ancestors is the allowlist; build it from the same configurable
        // origins used for the Studio API CORS so no domain is hard-coded.
        $allowedOrigins = config('cors.allowed_origins', []);

        $frameAncestors = "'self'";

        if (is_array($allowedOrigins)) {
            foreach ($allowedOrigins as $allowedOrigin) {
                $frameAncestors .= ' '.(string) $allowedOrigin;
            }
        }

        $response->headers->set(
            'Content-Security-Policy',
            'frame-ancestors '.$frameAncestors,
        );
        // CSP frame-ancestors is the allowlist; X-Frame-Options would block
        // the cross-subdomain studio frame in browsers that still honor it.
        $response->headers->remove('X-Frame-Options');

        return $response;
    }
}
