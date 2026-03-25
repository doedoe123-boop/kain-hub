<?php

namespace App\Services;

use App\InquiryStatus;
use App\Models\PropertyInquiry;
use App\Models\RentalAgreement;
use App\Models\User;
use App\RentalAgreementStatus;

class RentalAgreementService
{
    public function convertInquiryToAgreement(PropertyInquiry $inquiry, array $overrides = []): RentalAgreement
    {
        if ($inquiry->rentalAgreement !== null) {
            return $inquiry->rentalAgreement;
        }

        $property = $inquiry->property()->firstOrFail();
        $monthlyRent = $this->toCentavos($overrides['monthly_rent'] ?? $property->price);
        $securityDeposit = array_key_exists('security_deposit', $overrides)
            ? $this->toNullableCentavos($overrides['security_deposit'])
            : $monthlyRent * 2;

        $agreement = RentalAgreement::query()->create([
            'property_id' => $property->id,
            'store_id' => $inquiry->store_id,
            'tenant_user_id' => $inquiry->user_id ?? $this->resolveTenantUserId($inquiry->email),
            'tenant_name' => $overrides['tenant_name'] ?? $inquiry->name,
            'tenant_email' => $overrides['tenant_email'] ?? $inquiry->email,
            'tenant_phone' => $overrides['tenant_phone'] ?? $inquiry->phone,
            'monthly_rent' => $monthlyRent,
            'security_deposit' => $securityDeposit,
            'move_in_date' => $overrides['move_in_date']
                ?? $inquiry->viewing_date?->copy()->addWeek()->toDateString()
                ?? now()->addWeek()->toDateString(),
            'lease_term_months' => (int) ($overrides['lease_term_months'] ?? 12),
            'notes' => $overrides['notes'] ?? $inquiry->message,
            'status' => RentalAgreementStatus::Pending,
        ]);

        $inquiry->update([
            'status' => InquiryStatus::Closed,
            'rental_agreement_id' => $agreement->id,
        ]);

        return $agreement->fresh(['property', 'store', 'tenantUser']);
    }

    public function signByTenant(RentalAgreement $agreement): RentalAgreement
    {
        $agreement->update([
            'status' => RentalAgreementStatus::Signed,
            'signed_at' => $agreement->signed_at ?? now(),
        ]);

        return $agreement->fresh(['property', 'store']);
    }

    public function submitTenantQuestion(RentalAgreement $agreement, string $question): RentalAgreement
    {
        $agreement->update([
            'status' => RentalAgreementStatus::Negotiating,
            'tenant_questions' => $question,
        ]);

        return $agreement->fresh(['property', 'store']);
    }

    /**
     * Normalize form data coming from the Filament landlord panel.
     *
     * The landlord should **not** be able to set the status to signed —
     * only the tenant can do that via the API. This method strips any
     * attempt to override the status to signed and always preserves
     * the current signed_at value.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function normalizePanelAgreementData(array $data, ?int $storeId): array
    {
        $data['store_id'] = $storeId;
        $data['tenant_user_id'] = $data['tenant_user_id'] ?? $this->resolveTenantUserId($data['tenant_email'] ?? null);
        $data['monthly_rent'] = $this->toCentavos($data['monthly_rent'] ?? 0);

        if (array_key_exists('security_deposit', $data)) {
            $data['security_deposit'] = $this->toNullableCentavos($data['security_deposit']);
        }

        // Landlord cannot set status to signed — that is a tenant-only action.
        // Strip 'signed' if it slips through; keep pending/negotiating only.
        if (array_key_exists('status', $data)) {
            $statusValue = $data['status'] instanceof RentalAgreementStatus
                ? $data['status']->value
                : (string) $data['status'];

            if ($statusValue === RentalAgreementStatus::Signed->value) {
                unset($data['status']);
            }

            // Never let the landlord override signed_at
            unset($data['signed_at']);
        }

        return $data;
    }

    public function resolveTenantUserId(?string $email): ?int
    {
        if (blank($email)) {
            return null;
        }

        return User::query()
            ->where('email', $email)
            ->value('id');
    }

    protected function toCentavos(int|float|string|null $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    protected function toNullableCentavos(int|float|string|null $amount): ?int
    {
        if ($amount === null || $amount === '') {
            return null;
        }

        return $this->toCentavos($amount);
    }
}
