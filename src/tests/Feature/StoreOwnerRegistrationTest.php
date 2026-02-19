<?php

use App\Livewire\Store\StoreOwnerRegistration;
use App\Models\Store;
use App\Models\User;
use App\StoreStatus;
use App\UserRole;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'store_owner', 'guard_name' => 'web']);
    Storage::fake('local');
});

// --- Page Access ---

it('shows the store owner registration page to guests', function () {
    $this->get(route('register.store-owner'))
        ->assertStatus(200)
        ->assertSee('Register as a Store Owner');
});

it('redirects authenticated users away from registration', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('register.store-owner'))
        ->assertRedirect('/');
});

// --- Successful Registration ---

it('creates a user and store with KYC details on registration', function () {
    $file = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class)
        ->set('name', 'Juan Dela Cruz')
        ->set('email', 'juan@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('storeName', 'Juan Kitchen')
        ->set('slug', 'juan-kitchen')
        ->set('description', 'Best Filipino food in town')
        ->set('addressLine', '123 Rizal Ave')
        ->set('city', 'Manila')
        ->set('postcode', '1000')
        ->set('idType', 'passport')
        ->set('idNumber', 'P1234567')
        ->set('businessPermit', $file)
        ->call('register')
        ->assertRedirect(route('register.store-owner.success'));

    // User was created as store owner
    $user = User::where('email', 'juan@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::StoreOwner)
        ->and($user->phone)->toBe('09171234567')
        ->and($user->hasRole('store_owner'))->toBeTrue();

    // Store was created with pending status and KYC
    $store = Store::where('slug', 'juan-kitchen')->first();
    expect($store)->not->toBeNull()
        ->and($store->user_id)->toBe($user->id)
        ->and($store->name)->toBe('Juan Kitchen')
        ->and($store->status)->toBe(StoreStatus::Pending)
        ->and($store->id_type)->toBe('passport')
        ->and($store->id_number)->toBe('P1234567')
        ->and($store->business_permit)->not->toBeNull()
        ->and($store->address)->toMatchArray([
            'line_one' => '123 Rizal Ave',
            'city' => 'Manila',
            'postcode' => '1000',
        ]);

    // Business permit file was stored
    Storage::disk('local')->assertExists($store->business_permit);
});

it('auto-generates slug from store name', function () {
    Livewire::test(StoreOwnerRegistration::class)
        ->set('storeName', "Juan's Kitchen")
        ->assertSet('slug', 'juans-kitchen');
});

// --- Validation ---

it('validates required account fields', function () {
    Livewire::test(StoreOwnerRegistration::class)
        ->call('register')
        ->assertHasErrors(['name', 'email', 'phone', 'password', 'storeName', 'slug', 'description', 'addressLine', 'city', 'postcode', 'idType', 'idNumber', 'businessPermit']);
});

it('validates unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $file = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class)
        ->set('name', 'Test User')
        ->set('email', 'taken@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('storeName', 'My Store')
        ->set('slug', 'my-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'national_id')
        ->set('idNumber', '123456')
        ->set('businessPermit', $file)
        ->call('register')
        ->assertHasErrors('email');
});

it('validates unique slug', function () {
    Store::factory()->create(['slug' => 'taken-slug']);

    $file = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('storeName', 'My Store')
        ->set('slug', 'taken-slug')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'national_id')
        ->set('idNumber', '123456')
        ->set('businessPermit', $file)
        ->call('register')
        ->assertHasErrors('slug');
});

it('validates password confirmation', function () {
    Livewire::test(StoreOwnerRegistration::class)
        ->set('password', 'password123')
        ->set('password_confirmation', 'different')
        ->call('register')
        ->assertHasErrors('password');
});

it('validates password minimum length', function () {
    Livewire::test(StoreOwnerRegistration::class)
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('register')
        ->assertHasErrors('password');
});

it('validates business permit file type', function () {
    $file = UploadedFile::fake()->create('permit.exe', 1024, 'application/x-msdownload');

    Livewire::test(StoreOwnerRegistration::class)
        ->set('businessPermit', $file)
        ->call('register')
        ->assertHasErrors('businessPermit');
});

it('validates business permit max file size', function () {
    $file = UploadedFile::fake()->create('permit.pdf', 6000, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class)
        ->set('businessPermit', $file)
        ->call('register')
        ->assertHasErrors('businessPermit');
});

// --- Success Page ---

it('shows the registration success page', function () {
    $this->get(route('register.store-owner.success'))
        ->assertStatus(200)
        ->assertSee('Application Submitted')
        ->assertSee('3–5 business days');
});

// --- Navigation Links ---

it('shows Open a Store link for customers', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)
        ->get(route('home'))
        ->assertSee('Open a Store');
});

it('does not show Open a Store link for store owners', function () {
    $owner = User::factory()->storeOwner()->create();
    Store::factory()->for($owner, 'owner')->create([
        'status' => StoreStatus::Approved,
    ]);

    $this->actingAs($owner)
        ->get(route('home'))
        ->assertDontSee('Open a Store')
        ->assertSee('Store Dashboard');
});

it('shows store owner registration link on customer register page', function () {
    $this->get(route('register'))
        ->assertSee('Register as a Store Owner');
});
