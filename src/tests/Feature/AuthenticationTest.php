<?php

use App\Models\User;

// --- Logout ---

it('allows an authenticated user to logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from('/')
        ->withSession(['_token' => 'test-token'])
        ->post(route('logout'), ['_token' => 'test-token'])
        ->assertRedirect('/');

    $this->assertGuest();
});

// --- Role Middleware ---

it('allows store owners to access the store dashboard', function () {
    $user = User::factory()->storeOwner()->create();

    $this->actingAs($user)
        ->get(route('store.dashboard'))
        ->assertOk();
});

it('blocks customers from accessing the store dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('store.dashboard'))
        ->assertForbidden();
});

it('blocks guests from accessing the store dashboard', function () {
    $this->get(route('store.dashboard'))
        ->assertRedirect('/');
});

// --- Lunar Panel Access ---

it('blocks non-admin from accessing lunar panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/lunar')
        ->assertStatus(403);
});
