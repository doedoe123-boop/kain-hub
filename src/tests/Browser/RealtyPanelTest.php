<?php

use App\Models\Property;
use App\PropertyStatus;
use Laravel\Dusk\Browser;
use Tests\Browser\Concerns\CreatesTestUsers;
use Tests\Browser\Concerns\MigratesDuskDatabase;

uses(CreatesTestUsers::class, MigratesDuskDatabase::class);

// ── Authentication ─────────────────────────────────────────────────────

test('realty agent can access realty panel', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath())
            ->waitForLocation($this->realtyPath())
            ->assertPathBeginsWith($this->realtyPath());
    });
});

test('non-realty store owner cannot access realty panel', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->driver->manage()->deleteAllCookies();
        $browser->loginAs($user)
            ->visit($this->realtyPath())
            ->pause(2000)
            ->assertDontSee('Property Dashboard');
    });
});

// ── Dashboard ──────────────────────────────────────────────────────────

test('realty dashboard shows stats overview', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath())
            ->waitForText('Dashboard')
            ->assertSee('Dashboard');
    });
});

// ── Property Resource ──────────────────────────────────────────────────

test('agent can view properties list', function () {
    ['user' => $user, 'store' => $store] = $this->createRealtyAgent();

    Property::factory()->count(3)->create([
        'store_id' => $store->id,
        'status' => PropertyStatus::Active,
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/properties')
            ->waitForText('Properties')
            ->assertSee('Properties');
    });
});

test('agent can create a new property', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/properties/create')
            ->waitForText('Create Property')
            ->assertSee('Create Property');
    });
});

// ── Property Inquiry Resource ──────────────────────────────────────────

test('agent can view inquiries list', function () {
    ['user' => $user, 'store' => $store] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/property-inquiries')
            ->waitForText('Inquiries')
            ->assertSee('Inquiries');
    });
});

// ── Testimonial Resource ───────────────────────────────────────────────

test('agent can view testimonials list', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/testimonials')
            ->waitForText('Testimonials')
            ->assertSee('Testimonials');
    });
});

// ── Open House Resource ────────────────────────────────────────────────

test('agent can view open houses list', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/open-houses')
            ->waitForText('Open Houses')
            ->assertSee('Open Houses');
    });
});

// ── Development Resource ───────────────────────────────────────────────

test('agent can view developments list', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath().'/developments')
            ->waitForText('Developments')
            ->assertSee('Developments');
    });
});

// ── Navigation ─────────────────────────────────────────────────────────

test('realty sidebar shows listings and engagement groups', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->realtyPath())
            ->waitForText('Dashboard')
            ->assertSee('Listings')
            ->assertSee('Engagement');
    });
});
