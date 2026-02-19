<?php

use App\Models\User;
use App\UserRole;

// --- Login ---

it('shows the login page', function () {
    $this->get(route('login'))
        ->assertStatus(200)
        ->assertSee('Sign in to your account');
});

it('allows a user to login with valid credentials', function () {
    $user = User::factory()->create();

    \Livewire\Livewire::test(\App\Livewire\Auth\Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertHasNoErrors();

    $this->assertAuthenticatedAs($user);
});

it('rejects login with invalid credentials', function () {
    User::factory()->create(['email' => 'test@example.com']);

    \Livewire\Livewire::test(\App\Livewire\Auth\Login::class)
        ->set('email', 'test@example.com')
        ->set('password', 'wrong-password')
        ->call('authenticate')
        ->assertHasErrors('email');

    $this->assertGuest();
});

it('redirects authenticated users away from login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('login'))
        ->assertRedirect('/');
});

// --- Registration ---

it('shows the registration page', function () {
    $this->get(route('register'))
        ->assertStatus(200)
        ->assertSee('Create your account');
});

it('allows a new user to register', function () {
    \Livewire\Livewire::test(\App\Livewire\Auth\Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasNoErrors();

    $this->assertAuthenticated();

    $user = User::query()->where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::Customer)
        ->and($user->name)->toBe('John Doe');
});

it('rejects registration with duplicate email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    \Livewire\Livewire::test(\App\Livewire\Auth\Register::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'taken@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors('email');
});

it('rejects registration with short password', function () {
    \Livewire\Livewire::test(\App\Livewire\Auth\Register::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('register')
        ->assertHasErrors('password');
});

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
        ->assertRedirect(route('login'));
});

// --- Lunar Panel Access ---

it('blocks non-admin from accessing lunar panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/lunar')
        ->assertStatus(403);
});
