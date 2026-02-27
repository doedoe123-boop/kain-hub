<?php

namespace App\Listeners;

use App\Models\LoginHistory;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

/**
 * Records login attempts (success and failure) to the login_histories table.
 *
 * Listens to:
 * - Illuminate\Auth\Events\Login  → records successful logins
 * - Illuminate\Auth\Events\Failed → records failed login attempts
 */
class RecordLoginHistory
{
    public function __construct(
        private readonly Request $request,
    ) {}

    /**
     * Handle successful login events.
     */
    public function handleLogin(Login $event): void
    {
        LoginHistory::recordSuccess(
            $event->user,
            $this->request->ip(),
            $this->request->userAgent(),
        );
    }

    /**
     * Handle failed login events.
     */
    public function handleFailed(Failed $event): void
    {
        $email = $event->credentials['email'] ?? 'unknown';

        LoginHistory::recordFailure(
            $email,
            $this->request->ip(),
            $this->request->userAgent(),
        );
    }
}
