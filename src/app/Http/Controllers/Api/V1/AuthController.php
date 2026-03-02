<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V1\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Thin HTTP handler for customer authentication.
 *
 * All business logic (credential verification, user creation,
 * password hashing, token management) lives in AuthService.
 */
class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Register a new customer and return a Sanctum token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            name: $request->name,
            email: $request->email,
            password: $request->password,
            deviceName: $request->device_name ?? $request->userAgent() ?? 'web',
        );

        return response()->json($result, 201);
    }

    /**
     * Authenticate a customer and return a Sanctum token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            email: $request->email,
            password: $request->password,
            deviceName: $request->device_name ?? $request->userAgent() ?? 'web',
        );

        return response()->json($result);
    }

    /**
     * Send a password reset link to the given email address.
     *
     * Always returns 200 to avoid leaking whether the email exists.
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->authService->sendPasswordResetLink($request->email);

        return response()->json([
            'message' => 'If that email is registered, a reset link has been sent.',
        ]);
    }

    /**
     * Reset the user's password and return a new Sanctum token.
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = $this->authService->resetPassword(
            token: $request->token,
            email: $request->email,
            password: $request->password,
        );

        $token = $user->createToken($request->device_name ?? $request->userAgent() ?? 'web')->plainTextToken;

        return response()->json(compact('user', 'token'));
    }

    /**
     * Revoke the current access token (logout).
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Return the authenticated customer.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
