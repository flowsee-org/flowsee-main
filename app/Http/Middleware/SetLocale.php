<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // The URL is canonical: / is Persian and /en is English. The cookie
        // is refreshed on every response so the preference remains available
        // to client-side UI and future entry points without overriding routes.
        $locale = $request->segment(1) === 'en' ? 'en' : 'fa';
        app()->setLocale($locale);

        return $next($request)->withCookie(cookie('flowsee-locale', $locale, 60 * 24 * 365, '/', null, $request->isSecure(), false, false, 'lax'));
    }
}
