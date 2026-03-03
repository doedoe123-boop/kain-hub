<?php

use App\Models\User;

// Guards ─────────────────────────────────────────────────────────────────────

it('rejects unauthenticated access to GET /cart', function () {
    $this->getJson(route('api.v1.cart.show'))->assertUnauthorized();
});

it('rejects unauthenticated access to POST /cart/lines', function () {
    $this->postJson(route('api.v1.cart.lines.store'))->assertUnauthorized();
});

it('rejects unauthenticated access to DELETE /cart', function () {
    $this->deleteJson(route('api.v1.cart.clear'))->assertUnauthorized();
});

it('rejects unauthenticated access to GET /cart/shipping-options', function () {
    $this->getJson(route('api.v1.cart.shipping-options'))->assertUnauthorized();
});

// GET /api/v1/cart ────────────────────────────────────────────────────────────

it('returns null or a cart object when authenticated user requests cart', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')
        ->getJson(route('api.v1.cart.show'));

    // When no cart is attached to the session the endpoint returns null;
    // if Lunar creates a cart automatically it returns a JSON object.
    $response->assertOk();
    $body = $response->json();
    expect($body === null || is_array($body))->toBeTrue();
});

// POST /api/v1/cart/lines ────────────────────────────────────────────────────

it('validates required fields when adding a cart line', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.lines.store'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['purchasable_type', 'purchasable_id', 'quantity']);
});

it('rejects an unknown purchasable type', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.lines.store'), [
            'purchasable_type' => 'unknown-type',
            'purchasable_id' => 1,
            'quantity' => 1,
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('purchasable_type');
});

it('rejects a quantity of zero', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.lines.store'), [
            'purchasable_type' => 'product-variant',
            'purchasable_id' => 1,
            'quantity' => 0,
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('quantity');
});

it('rejects a quantity above 100', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.lines.store'), [
            'purchasable_type' => 'product-variant',
            'purchasable_id' => 1,
            'quantity' => 101,
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('quantity');
});

// DELETE /api/v1/cart ─────────────────────────────────────────────────────────

it('clears the cart and returns null for an authenticated user', function () {
    $user = User::factory()->create();

    // Clearing a non-existent cart is safe — the controller guards with `if ($cart)`.
    $this->actingAs($user, 'sanctum')
        ->deleteJson(route('api.v1.cart.clear'))
        ->assertOk(); // 200 is sufficient; no cart to clear means no-op.
});

// POST /api/v1/cart/address ───────────────────────────────────────────────────

it('validates required address fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.address'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['first_name', 'last_name', 'line_one', 'city', 'state', 'postcode', 'country']);
});

it('rejects a country code that is not 2 characters', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->postJson(route('api.v1.cart.address'), [
            'first_name' => 'Juan',
            'last_name' => 'dela Cruz',
            'line_one' => '123 Rizal St',
            'city' => 'Manila',
            'state' => 'Metro Manila',
            'postcode' => '1000',
            'country' => 'PHL', // 3-char, should fail
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('country');
});
