<?php

use App\Livewire\Store\StoreLogin;
use App\Models\Store;
use App\Models\User;
use App\StoreStatus;
use App\UserRole;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'store_owner', 'guard_name' => 'web']);

    $permissions = [
        'settings', 'settings:core', 'settings:manage-staff', 'settings:manage-attributes',
        'catalog:manage-products', 'catalog:manage-collections',
        'sales:manage-orders', 'sales:manage-customers', 'sales:manage-discounts',
    ];
    foreach ($permissions as $perm) {
        Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
    }
    $role->syncPermissions($permissions);
});

/**
 * Build a subdomain URL for a given store slug and path.
 */
function storeUrl(string $slug, string $path = '/'): string
{
    $domain = config('app.domain', 'localhost');

    return "http://{$slug}.{$domain}{$path}";
}

// =========================================================
// Subdomain Resolution
// =========================================================

it('shows the store login page on a valid subdomain', function () {
    $store = Store::factory()->create([
        'slug' => 'nelsons-kitchen',
        'status' => StoreStatus::Approved,
    ]);

    $this->get(storeUrl('nelsons-kitchen', '/login'))
        ->assertOk()
        ->assertSee('Store Owner Login')
        ->assertSee($store->name);
});

it('returns 404 for a non-existent store subdomain', function () {
    $this->get(storeUrl('fake-store', '/login'))
        ->assertNotFound();
});

it('returns 403 for a suspended store subdomain', function () {
    Store::factory()->create([
        'slug' => 'suspended-store',
        'status' => StoreStatus::Suspended,
    ]);

    $this->get(storeUrl('suspended-store', '/login'))
        ->assertForbidden();
});

it('allows pending store subdomain access to login page', function () {
    Store::factory()->create([
        'slug' => 'pending-store',
        'status' => StoreStatus::Pending,
    ]);

    $this->get(storeUrl('pending-store', '/login'))
        ->assertOk()
        ->assertSee('Store Owner Login');
});

// =========================================================
// Authentication
// =========================================================

it('authenticates the store owner on their subdomain', function () {
    $owner = User::factory()->storeOwner()->create();
    $owner->assignRole('store_owner');
    $store = Store::factory()->for($owner, 'owner')->create([
        'status' => StoreStatus::Approved,
    ]);

    app()->instance('currentStore', $store);

    Livewire::withoutLazyLoading()
        ->test(StoreLogin::class)
        ->set('email', $owner->email)
        ->set('password', 'password')
        ->call('authenticate');

    $this->assertAuthenticatedAs($owner);
});

it('rejects login with wrong credentials on subdomain', function () {
    $owner = User::factory()->storeOwner()->create();
    $owner->assignRole('store_owner');
    $store = Store::factory()->for($owner, 'owner')->create([
        'status' => StoreStatus::Approved,
    ]);

    app()->instance('currentStore', $store);

    Livewire::withoutLazyLoading()
        ->test(StoreLogin::class)
        ->set('email', $owner->email)
        ->set('password', 'wrong-password')
        ->call('authenticate')
        ->assertHasErrors('email');

    $this->assertGuest();
});

it('rejects a user who does not own the subdomain store', function () {
    $owner = User::factory()->storeOwner()->create();
    $owner->assignRole('store_owner');
    Store::factory()->for($owner, 'owner')->create([
        'slug' => 'owners-store',
        'status' => StoreStatus::Approved,
    ]);

    // Different store for subdomain
    $otherStore = Store::factory()->create([
        'slug' => 'other-store',
        'status' => StoreStatus::Approved,
    ]);

    // Bind the other store as currentStore (simulating subdomain middleware)
    app()->instance('currentStore', $otherStore);

    Livewire::withoutLazyLoading()
        ->test(StoreLogin::class)
        ->set('email', $owner->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertHasErrors('email');

    $this->assertGuest();
});

it('rejects a customer trying to login on a store subdomain', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);
    $store = Store::factory()->create([
        'slug' => 'some-store',
        'status' => StoreStatus::Approved,
    ]);

    app()->instance('currentStore', $store);

    Livewire::withoutLazyLoading()
        ->test(StoreLogin::class)
        ->set('email', $customer->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertHasErrors('email');

    $this->assertGuest();
});

// =========================================================
// Subdomain Root Redirect
// =========================================================

it('redirects authenticated user from subdomain root to /lunar', function () {
    $owner = User::factory()->storeOwner()->create();
    $owner->assignRole('store_owner');
    $store = Store::factory()->for($owner, 'owner')->create([
        'slug' => 'test-store',
        'status' => StoreStatus::Approved,
    ]);

    $this->actingAs($owner)
        ->get(storeUrl('test-store', '/'))
        ->assertRedirect('/lunar');
});

it('redirects guest from subdomain root to /login', function () {
    Store::factory()->create([
        'slug' => 'test-store',
        'status' => StoreStatus::Approved,
    ]);

    $this->get(storeUrl('test-store', '/'))
        ->assertRedirect('/login');
});
