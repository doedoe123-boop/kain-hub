<?php

namespace App\Http;

class HttpErrorMessages
{
    /**
     * @var array<int, string>
     */
    protected static array $titles = [
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

    /**
     * @var array<int, string>
     */
    protected static array $messages = [
        400 => 'The server could not understand your request. Please check and try again.',
        401 => 'You need to be authenticated to access this resource.',
        403 => "You don't have permission to access this resource.",
        404 => "The page you're looking for doesn't exist or has been moved.",
        405 => 'The request method is not supported for this route.',
        408 => 'The server timed out waiting for your request.',
        419 => 'Your session has expired. Please refresh and try again.',
        429 => "You've sent too many requests. Please slow down and try again shortly.",
        500 => "Something went wrong on our end. We're working on it.",
        502 => 'We received an invalid response from an upstream server.',
        503 => "We're temporarily down for maintenance. Please check back soon.",
        504 => 'The server took too long to respond. Please try again.',
    ];

    public static function title(int $code): string
    {
        return static::$titles[$code] ?? 'Error';
    }

    public static function message(int $code): string
    {
        return static::$messages[$code] ?? 'An unexpected error occurred. Please try again later.';
    }

    /**
     * Get title, message, and code as a view-ready array.
     *
     * @return array{code: int, title: string, message: string}
     */
    public static function toArray(int $code): array
    {
        return [
            'code' => $code,
            'title' => static::title($code),
            'message' => static::message($code),
        ];
    }
}
