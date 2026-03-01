<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        // HTTPS enforcement (only active in production)
        $middleware->prepend(\App\Http\Middleware\ForceHttps::class);

        // Customer auth is on the API/SPA — redirect unauthenticated
        // web visitors to the home page instead of a login route.
        $middleware->redirectGuestsTo('/');

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'store.subdomain' => \App\Http\Middleware\ResolveStoreFromSubdomain::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpExceptionInterface $e) {
            $code = $e->getStatusCode();

            $titles = [
                400 => 'Bad Request',
                401 => 'Unauthorized',
                403 => 'Forbidden',
                404 => 'Page Not Found',
                405 => 'Method Not Allowed',
                408 => 'Request Timeout',
                419 => 'Page Expired',
                429 => 'Too Many Requests',
                500 => 'Server Error',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
            ];

            $messages = [
                400 => 'The server could not understand your request. Please check and try again.',
                401 => 'You need to be authenticated to access this resource.',
                403 => 'You don\'t have permission to access this resource.',
                404 => 'The page you\'re looking for doesn\'t exist or has been moved.',
                405 => 'The request method is not supported for this route.',
                408 => 'The server timed out waiting for your request.',
                419 => 'Your session has expired. Please refresh and try again.',
                429 => 'You\'ve sent too many requests. Please slow down and try again shortly.',
                500 => 'Something went wrong on our end. We\'re working on it.',
                502 => 'We received an invalid response from an upstream server.',
                503 => 'We\'re temporarily down for maintenance. Please check back soon.',
                504 => 'The server took too long to respond. Please try again.',
            ];

            return response()->view('errors.custom', [
                'code' => $code,
                'title' => $titles[$code] ?? 'Error',
                'message' => $messages[$code] ?? 'An unexpected error occurred. Please try again later.',
            ], $code);
        });
    })->create();
