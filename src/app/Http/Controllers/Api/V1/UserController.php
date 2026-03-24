<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateRentalAgreementRequest;
use App\Http\Requests\UpdateUserSettingsRequest;
use App\Http\Resources\Api\V1\UserInquiryResource;
use App\Models\PropertyInquiry;
use App\Models\RentalAgreement;
use App\Models\User;
use App\RentalAgreementStatus;
use App\Services\RentalAgreementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private RentalAgreementService $rentalAgreementService
    ) {}

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
    public function updateSettings(UpdateUserSettingsRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->update($request->validated());

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

    /**
     * List the authenticated user's property inquiries.
     */
    public function inquiries(Request $request): AnonymousResourceCollection
    {
        $inquiries = PropertyInquiry::query()
            ->where('user_id', $request->user()->id)
            ->with(['property', 'store', 'rentalAgreement'])
            ->latest()
            ->paginate(10);

        return UserInquiryResource::collection($inquiries);
    }

    /**
     * List the authenticated user's rental agreements.
     */
    public function rentalAgreements(Request $request): AnonymousResourceCollection|LengthAwarePaginator
    {
        $agreements = $this->rentalAgreementsQueryForUser($request->user())
            ->with(['property', 'store'])
            ->latest()
            ->paginate(10);

        $agreements->getCollection()->each(function (RentalAgreement $agreement) use ($request): void {
            if ($agreement->tenant_user_id === null && $agreement->tenant_email === $request->user()->email) {
                $agreement->updateQuietly([
                    'tenant_user_id' => $request->user()->id,
                ]);
            }
        });

        return $agreements->through(fn ($a) => [
            'id' => $a->id,
            'move_in_date' => $a->move_in_date?->toDateString(),
            'monthly_rent' => $a->monthly_rent,
            'security_deposit' => $a->security_deposit,
            'lease_term_months' => $a->lease_term_months,
            'created_at' => $a->created_at?->toIso8601String(),
            'status' => $a->status->value,
            'status_label' => $a->status->label(),
            'tenant_questions' => $a->tenant_questions,
            'landlord_response' => $a->landlord_response,
            'signed_at' => $a->signed_at?->toIso8601String(),
            'notes' => $a->notes,
            'can_sign' => $a->status->canTenantSign(),
            'tenant_primary_action' => match ($a->status) {
                RentalAgreementStatus::Pending => 'Review and Sign',
                RentalAgreementStatus::Negotiating => 'Review response and Sign',
                RentalAgreementStatus::Signed => 'Agreement Signed',
            },
            'property' => [
                'id' => $a->property?->id,
                'title' => $a->property?->title,
                'slug' => $a->property?->slug,
                'city' => $a->property?->city,
                'full_address' => $a->property?->fullLocation(),
                'address_line' => $a->property?->address_line,
                'featured_image' => $a->property?->images[0] ?? null,
            ],
            'store' => [
                'id' => $a->store?->id,
                'name' => $a->store?->name,
                'slug' => $a->store?->slug,
                'phone' => $a->store?->phone,
            ],
        ]);
    }

    /**
     * Update a rental agreement (sign or submit questions).
     */
    public function updateRentalAgreement(UpdateRentalAgreementRequest $request, int $id): JsonResponse
    {
        $agreement = $this->rentalAgreementsQueryForUser($request->user())
            ->findOrFail($id);

        if ($agreement->tenant_user_id === null && $agreement->tenant_email === $request->user()->email) {
            $agreement->updateQuietly([
                'tenant_user_id' => $request->user()->id,
            ]);
        }

        $validated = $request->validated();

        if (($validated['status'] ?? null) === RentalAgreementStatus::Signed->value) {
            $agreement = $this->rentalAgreementService->signByTenant($agreement);
        } elseif (! empty($validated['tenant_questions'])) {
            $agreement = $this->rentalAgreementService->submitTenantQuestion(
                $agreement,
                $validated['tenant_questions'],
            );
        }

        return response()->json(['message' => 'Rental agreement updated successfully.', 'agreement' => $agreement]);
    }

    protected function rentalAgreementsQueryForUser(User $user)
    {
        return RentalAgreement::query()
            ->where(function ($query) use ($user): void {
                $query
                    ->where('tenant_user_id', $user->id)
                    ->orWhere(function ($emailQuery) use ($user): void {
                        $emailQuery
                            ->whereNull('tenant_user_id')
                            ->where('tenant_email', $user->email);
                    });
            });
    }

    /**
     * List the authenticated user's unread notifications.
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->unreadNotifications()
            ->latest()
            ->take(20)
            ->get()
            ->map(fn ($n) => [
                'id' => $n->id,
                'type' => class_basename($n->type),
                'data' => $n->data,
                'created_at' => $n->created_at->toISOString(),
            ]);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markNotificationRead(Request $request, string $id): JsonResponse
    {
        $request->user()
            ->unreadNotifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
