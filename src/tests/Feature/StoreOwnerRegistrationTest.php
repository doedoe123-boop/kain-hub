<?php

use App\IndustrySector;
use App\Livewire\SectorBrowse;
use App\Livewire\Store\SectorSelection;
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

// --- Sector Selection Page ---

it('shows the sector selection page to guests', function () {
    $this->get(route('register.sector'))
        ->assertStatus(200)
        ->assertSee('Choose Your Industry');
});

it('shows all industry sectors on the selection page', function () {
    Livewire::test(SectorSelection::class)
        ->assertSee('Construction & Building')
        ->assertSee('IT & Technology')
        ->assertSee('Food & Beverage')
        ->assertSee('Healthcare & Pharma')
        ->assertSee('Chemicals & Raw Materials')
        ->assertSee('Logistics & Transport')
        ->assertSee('Real Estate & Property')
        ->assertSee('Agriculture & Farming');
});

it('redirects to registration with selected sector', function () {
    Livewire::test(SectorSelection::class)
        ->call('selectSector', 'technology')
        ->assertRedirect(route('register.store-owner', ['sector' => 'technology']));
});

it('rejects invalid sector selection', function () {
    Livewire::test(SectorSelection::class)
        ->call('selectSector', 'invalid_sector')
        ->assertHasErrors('sector');
});

// --- Public Sector Browse Page ---

it('shows the public sector browse page', function () {
    $this->get(route('sector.browse'))
        ->assertStatus(200)
        ->assertSee('Industry Sectors');
});

it('displays sector information with compliance requirements', function () {
    Livewire::test(SectorBrowse::class)
        ->assertSee('Construction & Building')
        ->assertSee('Food & Beverage')
        ->assertSee('required');
});

it('filters sectors by search query', function () {
    Livewire::test(SectorBrowse::class)
        ->set('search', 'food')
        ->assertSee('Food & Beverage')
        ->assertDontSee('Construction & Building');
});

// --- Registration Page Access ---

it('shows the store owner registration page to guests', function () {
    $this->get(route('register.store-owner', ['sector' => 'food_and_beverage']))
        ->assertStatus(200)
        ->assertSee('Become a Supplier');
});

it('redirects authenticated users away from registration', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('register.store-owner', ['sector' => 'food_and_beverage']))
        ->assertRedirect('/');
});

it('redirects to sector selection for invalid sector in URL', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'nonexistent'])
        ->assertRedirect(route('register.sector'));
});

// --- 5-Step Form Navigation ---

it('shows 5-step progress indicator', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->assertSee('Account')
        ->assertSee('Store')
        ->assertSee('Address')
        ->assertSee('Identity')
        ->assertSee('Compliance');
});

it('shows sector-specific compliance documents on step 5', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('step', 5)
        ->assertSee('FDA License to Operate (LTO)')
        ->assertSee('Sanitary Permit')
        ->assertSee('DTI / SEC Registration')
        ->assertSee('BIR Certificate of Registration');
});

it('shows construction-specific docs for construction sector', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'construction'])
        ->set('step', 5)
        ->assertSee('PCAB License')
        ->assertDontSee('FDA License to Operate');
});

it('shows healthcare-specific docs for healthcare sector', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'healthcare'])
        ->set('step', 5)
        ->assertSee('DOH License')
        ->assertSee('PRC Professional License')
        ->assertDontSee('PCAB License');
});

// --- Successful Registration with Compliance Docs ---

it('creates a user and store with compliance documents on registration', function () {
    $dtiFile = UploadedFile::fake()->create('dti.pdf', 1024, 'application/pdf');
    $permitFile = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');
    $birFile = UploadedFile::fake()->create('bir.pdf', 1024, 'application/pdf');
    $fdaFile = UploadedFile::fake()->create('fda.pdf', 1024, 'application/pdf');
    $sanitaryFile = UploadedFile::fake()->create('sanitary.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Juan Dela Cruz')
        ->set('email', 'juan@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'Juan Kitchen')
        ->set('slug', 'juan-kitchen')
        ->set('description', 'Best Filipino food in town')
        ->set('addressLine', '123 Rizal Ave')
        ->set('city', 'Manila')
        ->set('postcode', '1000')
        ->set('idType', 'passport')
        ->set('idNumber', 'P1234567')
        ->set('complianceFiles.dti_sec_registration', $dtiFile)
        ->set('complianceFiles.business_permit', $permitFile)
        ->set('complianceFiles.bir_registration', $birFile)
        ->set('complianceFiles.fda_lto', $fdaFile)
        ->set('complianceFiles.sanitary_permit', $sanitaryFile)
        ->call('register')
        ->assertRedirect(route('register.store-owner.success'));

    // User was created
    $user = User::where('email', 'juan@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::StoreOwner)
        ->and($user->phone)->toBe('09171234567')
        ->and($user->hasRole('store_owner'))->toBeTrue();

    // Store was created with compliance documents
    $store = Store::where('slug', 'juan-kitchen')->first();
    expect($store)->not->toBeNull()
        ->and($store->user_id)->toBe($user->id)
        ->and($store->name)->toBe('Juan Kitchen')
        ->and($store->status)->toBe(StoreStatus::Pending)
        ->and($store->sector)->toBe(IndustrySector::FoodAndBeverage)
        ->and($store->id_type)->toBe('passport')
        ->and($store->id_number)->toBe('P1234567')
        ->and($store->compliance_documents)->toBeArray()
        ->and($store->compliance_documents)->toHaveKeys(['dti_sec_registration', 'business_permit', 'bir_registration', 'fda_lto', 'sanitary_permit'])
        ->and($store->address)->toMatchArray([
            'line_one' => '123 Rizal Ave',
            'city' => 'Manila',
            'postcode' => '1000',
        ]);
});

it('auto-generates slug from store name', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('storeName', "Juan's Kitchen")
        ->assertSet('slug', 'juans-kitchen');
});

// --- Validation ---

it('validates required account fields', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->call('register')
        ->assertHasErrors(['name', 'email', 'phone', 'password', 'storeName', 'slug', 'description', 'addressLine', 'city', 'postcode', 'idType', 'idNumber']);
});

it('validates required compliance documents', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'My Store')
        ->set('slug', 'my-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'national_id')
        ->set('idNumber', '1234-5678-9012-3456')
        ->call('register')
        ->assertHasErrors([
            'complianceFiles.dti_sec_registration',
            'complianceFiles.business_permit',
            'complianceFiles.bir_registration',
            'complianceFiles.fda_lto',
            'complianceFiles.sanitary_permit',
        ]);
});

it('does not require optional compliance documents', function () {
    $dtiFile = UploadedFile::fake()->create('dti.pdf', 1024, 'application/pdf');
    $permitFile = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');
    $birFile = UploadedFile::fake()->create('bir.pdf', 1024, 'application/pdf');
    $fdaFile = UploadedFile::fake()->create('fda.pdf', 1024, 'application/pdf');
    $sanitaryFile = UploadedFile::fake()->create('sanitary.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'optional@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'Optional Store')
        ->set('slug', 'optional-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'passport')
        ->set('idNumber', 'P1234567')
        ->set('complianceFiles.dti_sec_registration', $dtiFile)
        ->set('complianceFiles.business_permit', $permitFile)
        ->set('complianceFiles.bir_registration', $birFile)
        ->set('complianceFiles.fda_lto', $fdaFile)
        ->set('complianceFiles.sanitary_permit', $sanitaryFile)
        // halal_certification is optional — not set
        ->call('register')
        ->assertHasNoErrors('complianceFiles.halal_certification')
        ->assertRedirect(route('register.store-owner.success'));
});

it('validates unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'taken@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'My Store')
        ->set('slug', 'my-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'national_id')
        ->set('idNumber', '1234-5678-9012-3456')
        ->call('register')
        ->assertHasErrors('email');
});

it('validates unique slug', function () {
    Store::factory()->create(['slug' => 'taken-slug']);

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'My Store')
        ->set('slug', 'taken-slug')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'sss')
        ->set('idNumber', '01-2345678-9')
        ->call('register')
        ->assertHasErrors('slug');
});

it('validates password confirmation', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'different')
        ->call('register')
        ->assertHasErrors('password');
});

it('validates password minimum length', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('register')
        ->assertHasErrors('password');
});

it('rejects password without uppercase letters', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('password', 'str0ng#pass9')
        ->set('password_confirmation', 'str0ng#pass9')
        ->call('register')
        ->assertHasErrors('password');
});

it('rejects password without symbols', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('password', 'Str0ngPass9')
        ->set('password_confirmation', 'Str0ngPass9')
        ->call('register')
        ->assertHasErrors('password');
});

it('rejects password without numbers', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('password', 'Strong#Pass')
        ->set('password_confirmation', 'Strong#Pass')
        ->call('register')
        ->assertHasErrors('password');
});

it('rejects invalid id type', function () {
    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'My Store')
        ->set('slug', 'my-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'invalid_type')
        ->set('idNumber', '123456')
        ->call('register')
        ->assertHasErrors('idType');
});

it('validates SSS ID number format', function () {
    $dtiFile = UploadedFile::fake()->create('dti.pdf', 1024, 'application/pdf');
    $permitFile = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');
    $birFile = UploadedFile::fake()->create('bir.pdf', 1024, 'application/pdf');
    $fdaFile = UploadedFile::fake()->create('fda.pdf', 1024, 'application/pdf');
    $sanitaryFile = UploadedFile::fake()->create('sanitary.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'My Store')
        ->set('slug', 'my-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'sss')
        ->set('idNumber', '12345')
        ->set('complianceFiles.dti_sec_registration', $dtiFile)
        ->set('complianceFiles.business_permit', $permitFile)
        ->set('complianceFiles.bir_registration', $birFile)
        ->set('complianceFiles.fda_lto', $fdaFile)
        ->set('complianceFiles.sanitary_permit', $sanitaryFile)
        ->call('register')
        ->assertHasErrors('idNumber');
});

it('accepts valid SSS ID number format', function () {
    $dtiFile = UploadedFile::fake()->create('dti.pdf', 1024, 'application/pdf');
    $permitFile = UploadedFile::fake()->create('permit.pdf', 1024, 'application/pdf');
    $birFile = UploadedFile::fake()->create('bir.pdf', 1024, 'application/pdf');
    $fdaFile = UploadedFile::fake()->create('fda.pdf', 1024, 'application/pdf');
    $sanitaryFile = UploadedFile::fake()->create('sanitary.pdf', 1024, 'application/pdf');

    Livewire::test(StoreOwnerRegistration::class, ['sector' => 'food_and_beverage'])
        ->set('name', 'Test User')
        ->set('email', 'sss-test@example.com')
        ->set('phone', '09171234567')
        ->set('password', 'Str0ng#Pass9')
        ->set('password_confirmation', 'Str0ng#Pass9')
        ->set('storeName', 'SSS Test Store')
        ->set('slug', 'sss-test-store')
        ->set('description', 'A great store')
        ->set('addressLine', '123 St')
        ->set('city', 'City')
        ->set('postcode', '1000')
        ->set('idType', 'sss')
        ->set('idNumber', '01-2345678-9')
        ->set('complianceFiles.dti_sec_registration', $dtiFile)
        ->set('complianceFiles.business_permit', $permitFile)
        ->set('complianceFiles.bir_registration', $birFile)
        ->set('complianceFiles.fda_lto', $fdaFile)
        ->set('complianceFiles.sanitary_permit', $sanitaryFile)
        ->call('register')
        ->assertHasNoErrors('idNumber')
        ->assertRedirect(route('register.store-owner.success'));
});

// --- Sector-Specific Document Requirements ---

it('has different required documents per sector', function () {
    $foodDocs = IndustrySector::FoodAndBeverage->requiredDocuments();
    $constructionDocs = IndustrySector::Construction->requiredDocuments();

    // Food needs FDA and Sanitary Permit
    $foodKeys = array_column($foodDocs, 'key');
    expect($foodKeys)->toContain('fda_lto')
        ->toContain('sanitary_permit');

    // Construction needs PCAB License
    $constructionKeys = array_column($constructionDocs, 'key');
    expect($constructionKeys)->toContain('pcab_license')
        ->not->toContain('fda_lto');

    // Both share common documents
    expect($foodKeys)->toContain('dti_sec_registration')
        ->toContain('business_permit')
        ->toContain('bir_registration');
    expect($constructionKeys)->toContain('dti_sec_registration')
        ->toContain('business_permit')
        ->toContain('bir_registration');
});

it('returns required document keys for a sector', function () {
    $required = IndustrySector::FoodAndBeverage->requiredDocumentKeys();

    expect($required)->toContain('dti_sec_registration')
        ->toContain('business_permit')
        ->toContain('bir_registration')
        ->toContain('fda_lto')
        ->toContain('sanitary_permit')
        ->not->toContain('halal_certification');
});

// --- Success Page ---

it('shows the registration success page', function () {
    $this->get(route('register.store-owner.success'))
        ->assertStatus(200)
        ->assertSee('Application Submitted')
        ->assertSee('3–5 business days');
});

// --- Login Route ---

it('returns 404 for login route', function () {
    $this->get('/login')
        ->assertStatus(404);
});

// --- Navigation Links ---

it('shows Register as Seller link for customers', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)
        ->get(route('home'))
        ->assertSee('Become a Seller');
});

it('shows Dashboard link instead of top-bar seller CTA for store owners', function () {
    $owner = User::factory()->storeOwner()->create();
    Store::factory()->for($owner, 'owner')->create([
        'status' => StoreStatus::Approved,
    ]);

    $this->actingAs($owner)
        ->get(route('home'))
        ->assertSee('Dashboard');
});
