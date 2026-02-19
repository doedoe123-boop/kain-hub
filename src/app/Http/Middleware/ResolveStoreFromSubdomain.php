<?php

namespace App\Http\Middleware;

use App\Models\Store;
use App\StoreStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveStoreFromSubdomain
{
    /**
     * Resolve the current store from the subdomain and bind it to the container.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $this->extractSubdomain($request);

        if (! $slug) {
            abort(404);
        }

        $store = Store::where('slug', $slug)->first();

        if (! $store) {
            abort(404);
        }

        if ($store->status === StoreStatus::Suspended) {
            abort(403, 'This store has been suspended.');
        }

        app()->instance('currentStore', $store);
        view()->share('currentStore', $store);

        return $next($request);
    }

    /**
     * Extract the subdomain slug from the request host.
     */
    private function extractSubdomain(Request $request): ?string
    {
        $host = $request->getHost();
        $domain = config('app.domain');

        if (! str_ends_with($host, '.' . $domain)) {
            return null;
        }

        $subdomain = str_replace('.' . $domain, '', $host);

        if ($subdomain === '' || $subdomain === $domain) {
            return null;
        }

        return $subdomain;
    }
}
