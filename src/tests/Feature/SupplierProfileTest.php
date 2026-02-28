<?php

use App\Models\Store;

// --- Approved Store ---

it('displays the supplier profile for an approved store', function () {
    $store = Store::factory()->create([
        'name' => 'Acme Supplies',
        'slug' => 'acme-supplies',
        'description' => 'Premium industrial supplier.',
    ]);

    $this->get(route('suppliers.show', 'acme-supplies'))
        ->assertStatus(200)
        ->assertSee('Acme Supplies')
        ->assertSee('Premium industrial supplier.');
});

it('shows verification badges when store has KYC documents', function () {
    $store = Store::factory()->create([
        'slug' => 'verified-store',
        'id_type' => 'passport',
        'id_number' => 'P1234567',
        'business_permit' => 'permits/test.pdf',
    ]);

    $this->get(route('suppliers.show', 'verified-store'))
        ->assertStatus(200)
        ->assertSee('Corporate ID Verified')
        ->assertSee('Operating License Valid');
});

it('shows the store location on the profile', function () {
    $store = Store::factory()->create([
        'slug' => 'local-store',
        'address' => [
            'line_one' => '123 Rizal Ave',
            'city' => 'Manila',
            'postcode' => '1000',
        ],
    ]);

    $this->get(route('suppliers.show', 'local-store'))
        ->assertStatus(200)
        ->assertSee('Manila')
        ->assertSee('1000');
});

// --- Non-Approved Stores ---

it('returns 404 for a pending store', function () {
    Store::factory()->pending()->create(['slug' => 'pending-store']);

    $this->get(route('suppliers.show', 'pending-store'))
        ->assertStatus(404);
});

it('returns 404 for a suspended store', function () {
    Store::factory()->suspended()->create(['slug' => 'suspended-store']);

    $this->get(route('suppliers.show', 'suspended-store'))
        ->assertStatus(404);
});

it('returns 404 for a non-existent slug', function () {
    $this->get(route('suppliers.show', 'does-not-exist'))
        ->assertStatus(404);
});
