<?php

namespace App\Services;

use App\Models\User;
use App\UserRole;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Handles customer authentication: registration, login, and token management.
 *
 * All credential verification and user creation logic lives here, keeping
 * controllers responsible only for HTTP request/response handling.
 */
class AuthService
{
    /**
     * Register a new customer, persist them, and issue a Sanctum token.
     *
     * @return array{user: User, token: string}
     */
    public function register(string $name, string $email, string $password, string $deviceName): array
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => UserRole::Customer,
        ]);

        $token = $user->createToken($deviceName)->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * Verify credentials and issue a Sanctum token for an existing user.
     *
     * @return array{user: User, token: string}
     *
     * @throws ValidationException
     */
    public function login(string $email, string $password, string $deviceName): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($deviceName)->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * Revoke the user's current Sanctum access token.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    /**
     * Send a password reset link to the given email address.
     *
     * Always returns true to avoid leaking whether the address exists.
     */
    public function sendPasswordResetLink(string $email): bool
    {
        Password::broker()->sendResetLink(['email' => $email]);

        return true;
    }

    /**
     * Reset the user's password using the given broker token.
     *
     * @throws ValidationException
     */
    public function resetPassword(string $token, string $email, string $password): User
    {
        $status = Password::broker()->reset(
            [
                'token' => $token,
                'email' => $email,
                'password' => $password,
            ],
            function (User $user, string $newPassword): void {
                $user->forceFill([
                    'password' => Hash::make($newPassword),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return User::where('email', $email)->firstOrFail();
    }
}
