<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = array_map(
            fn (string $role) => UserRole::from($role),
            $roles,
        );

        if (! in_array($request->user()->role, $allowedRoles, true)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
