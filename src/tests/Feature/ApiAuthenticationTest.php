<?php

use App\Models\User;
use App\UserRole;

// --- Registration ---

it('registers a new customer via API', function () {
    $response = $this->postJson(route('api.auth.register.customer'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'device_name' => 'iPhone 15',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['user', 'token'])
        ->assertJsonPath('user.name', 'John Doe')
        ->assertJsonPath('user.email', 'john@example.com');

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'role' => UserRole::Customer->value,
    ]);
});

it('rejects registration with duplicate email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->postJson(route('api.auth.register.customer'), [
        'name' => 'Jane Doe',
        'email' => 'taken@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'device_name' => 'Android',
    ])->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

it('rejects registration with missing fields', function () {
    $this->postJson(route('api.auth.register.customer'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email', 'password', 'device_name']);
});

it('rejects registration when password is too short', function () {
    $this->postJson(route('api.auth.register.customer'), [
        'name' => 'Short Pass',
        'email' => 'short@example.com',
        'password' => 'abc',
        'password_confirmation' => 'abc',
        'device_name' => 'Test',
    ])->assertStatus(422)
        ->assertJsonValidationErrors('password');
});

// --- Login ---

it('logs in a user via API and returns a token', function () {
    User::factory()->create([
        'email' => 'login@example.com',
    ]);

    $response = $this->postJson(route('api.auth.login'), [
        'email' => 'login@example.com',
        'password' => 'password',
        'device_name' => 'Test Device',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['user', 'token'])
        ->assertJsonPath('user.email', 'login@example.com');
});

it('rejects login with invalid credentials', function () {
    User::factory()->create(['email' => 'user@example.com']);

    $this->postJson(route('api.auth.login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-password',
        'device_name' => 'Test',
    ])->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

it('rejects login with missing fields', function () {
    $this->postJson(route('api.auth.login'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password', 'device_name']);
});

// --- Authenticated Endpoints ---

it('returns the authenticated user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $this->getJson(route('api.auth.user'), [
        'Authorization' => "Bearer {$token}",
    ])->assertOk()
        ->assertJsonPath('email', $user->email);
});

it('logs out and revokes the token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test')->plainTextToken;

    $this->postJson(route('api.auth.logout'), [], [
        'Authorization' => "Bearer {$token}",
    ])->assertOk()
        ->assertJsonPath('message', 'Logged out successfully.');

    // Refresh the auth guard so cached user is cleared
    auth('sanctum')->forgetUser();

    // Token should no longer work
    $this->getJson(route('api.auth.user'), [
        'Authorization' => "Bearer {$token}",
    ])->assertUnauthorized();
});

it('rejects unauthenticated access to protected endpoints', function () {
    $this->getJson(route('api.auth.user'))
        ->assertUnauthorized();

    $this->postJson(route('api.auth.logout'))
        ->assertUnauthorized();
});

// --- Role Assignment ---

it('always assigns customer role on API registration', function () {
    $this->postJson(route('api.auth.register.customer'), [
        'name' => 'New Customer',
        'email' => 'customer@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'device_name' => 'Mobile',
    ])->assertStatus(201);

    $user = User::where('email', 'customer@example.com')->first();
    expect($user->role)->toBe(UserRole::Customer);
});
