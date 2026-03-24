<?php

use App\InquiryStatus;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\RentalAgreement;
use App\Models\Store;
use App\Models\User;
use App\Notifications\LandlordAgreementResponseNotification;
use App\Notifications\RentalAgreementPendingNotification;
use App\Notifications\RentalAgreementQuestionNotification;
use App\Notifications\RentalConfirmedLandlordNotification;
use App\Notifications\RentalConfirmedTenantNotification;
use App\PropertyStatus;
use App\RentalAgreementStatus;
use App\Services\RentalAgreementService;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->landlord = User::factory()->create();
    $this->store = Store::factory()->create([
        'user_id' => $this->landlord->id,
        'sector' => 'real_estate',
    ]);
    $this->tenant = User::factory()->create();
    $this->property = Property::factory()->create([
        'store_id' => $this->store->id,
        'status' => PropertyStatus::Active,
        'published_at' => now(),
    ]);
});

test('creating a rental agreement sends pending notification to tenant', function () {
    Notification::fake();

    $agreement = RentalAgreement::create([
        'property_id' => $this->property->id,
        'store_id' => $this->store->id,
        'tenant_name' => 'Nelson Doe',
        'tenant_email' => 'nelson@example.com',
        'monthly_rent' => 2500000,
        'move_in_date' => '2026-04-01',
        'lease_term_months' => 12,
        'status' => RentalAgreementStatus::Pending,
    ]);

    Notification::assertSentOnDemand(RentalAgreementPendingNotification::class, function ($notification, $channels, $notifiable) {
        return $notifiable->routes['mail'] === 'nelson@example.com';
    });
});

test('tenant signing agreement updates property status and notifies both parties', function () {
    Notification::fake();

    $agreement = RentalAgreement::factory()->create([
        'property_id' => $this->property->id,
        'store_id' => $this->store->id,
        'tenant_email' => $this->tenant->email,
        'status' => RentalAgreementStatus::Pending,
    ]);

    // Simulate tenant signing
    $agreement->update(['status' => RentalAgreementStatus::Signed, 'signed_at' => now()]);

    // Check property status
    $this->property->refresh();
    expect($this->property->status)->toBe(PropertyStatus::Rented);

    // Check notifications
    Notification::assertSentOnDemand(RentalConfirmedTenantNotification::class);
    Notification::assertSentTo($this->landlord, RentalConfirmedLandlordNotification::class);
});

test('tenant asking questions notifies landlord', function () {
    Notification::fake();

    $agreement = RentalAgreement::factory()->create([
        'property_id' => $this->property->id,
        'store_id' => $this->store->id,
        'status' => RentalAgreementStatus::Pending,
    ]);

    $agreement->update([
        'status' => RentalAgreementStatus::Negotiating,
        'tenant_questions' => 'Can I have a pet?',
    ]);

    Notification::assertSentTo($this->landlord, RentalAgreementQuestionNotification::class);
});

test('landlord responding to questions notifies tenant', function () {
    Notification::fake();

    $agreement = RentalAgreement::factory()->create([
        'property_id' => $this->property->id,
        'store_id' => $this->store->id,
        'tenant_email' => 'tenant@example.com',
        'status' => RentalAgreementStatus::Negotiating,
        'tenant_questions' => 'Can I have a pet?',
    ]);

    $agreement->update([
        'landlord_response' => 'Only small pets are allowed.',
    ]);

    Notification::assertSentOnDemand(LandlordAgreementResponseNotification::class, function ($notification) {
        return $notification->agreement->landlord_response === 'Only small pets are allowed.';
    });
});

test('converting an inquiry to an agreement prefills tenant, property, and default deposit', function () {
    $inquiry = PropertyInquiry::factory()->create([
        'property_id' => $this->property->id,
        'store_id' => $this->store->id,
        'user_id' => $this->tenant->id,
        'name' => $this->tenant->name,
        'email' => $this->tenant->email,
        'phone' => $this->tenant->phone,
        'status' => InquiryStatus::Negotiating,
        'message' => 'Can we target move-in next month?',
    ]);

    $agreement = app(RentalAgreementService::class)->convertInquiryToAgreement($inquiry, [
        'move_in_date' => '2026-04-15',
    ]);

    expect($agreement->property_id)->toBe($this->property->id)
        ->and($agreement->store_id)->toBe($this->store->id)
        ->and($agreement->tenant_user_id)->toBe($this->tenant->id)
        ->and($agreement->tenant_email)->toBe($this->tenant->email)
        ->and($agreement->monthly_rent)->toBe((int) round(((float) $this->property->price) * 100))
        ->and($agreement->security_deposit)->toBe((int) round(((float) $this->property->price) * 200))
        ->and($agreement->status)->toBe(RentalAgreementStatus::Pending);

    $inquiry->refresh();
    expect($inquiry->status)->toBe(InquiryStatus::Closed)
        ->and($inquiry->rental_agreement_id)->toBe($agreement->id);
});
