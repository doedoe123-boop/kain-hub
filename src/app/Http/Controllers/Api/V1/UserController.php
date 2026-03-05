<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Update the authenticated user's profile (name, phone).
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->update($request->validated());

        return response()->json($user->fresh());
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return response()->json(['message' => 'Password updated successfully.']);
    }

    /**
     * Update per-user notification preferences.
     */
    public function updateSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notification_preferences' => ['required', 'array'],
            'notification_preferences.order_updates' => ['boolean'],
            'notification_preferences.promotions' => ['boolean'],
        ]);

        $user = $request->user();
        $user->update($validated);

        return response()->json($user->fresh());
    }

    /**
     * Soft-delete the authenticated user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        // Revoke all tokens so the user is immediately logged out everywhere.
        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'Account deleted.']);
    }
}
