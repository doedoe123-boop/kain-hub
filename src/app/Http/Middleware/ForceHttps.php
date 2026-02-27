<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force HTTPS in production environments.
 *
 * Redirects HTTP requests to HTTPS and sets Strict-Transport-Security header.
 * Only active when APP_ENV=production.
 */
class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        if (! $request->secure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        /** @var Response $response */
        $response = $next($request);

        // HSTS header — tells browsers to only use HTTPS for 1 year
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains',
        );

        return $response;
    }
}
