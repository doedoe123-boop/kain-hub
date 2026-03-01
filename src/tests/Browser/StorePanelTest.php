<?php

use Laravel\Dusk\Browser;
use Tests\Browser\Concerns\CreatesTestUsers;
use Tests\Browser\Concerns\MigratesDuskDatabase;

uses(CreatesTestUsers::class, MigratesDuskDatabase::class);

// ── Authentication ─────────────────────────────────────────────────────

test('store owner can access store panel', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath())
            ->waitForLocation($this->storePath())
            ->assertPathBeginsWith($this->storePath());
    });
});

test('admin cannot access store panel', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->driver->manage()->deleteAllCookies();
        $browser->loginAs($admin)
            ->visit($this->storePath())
            ->pause(2000)
            ->assertSee('403');
    });
});

test('realty owner cannot access store panel', function () {
    ['user' => $user] = $this->createRealtyAgent();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath())
            ->assertDontSee('Store Dashboard');
    });
});

// ── Dashboard ──────────────────────────────────────────────────────────

test('store dashboard loads for owner', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath())
            ->waitForText('Dashboard')
            ->assertSee('Dashboard');
    });
});

// ── Products Resource ──────────────────────────────────────────────────

test('store owner can view products list', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/products')
            ->waitForText('Products')
            ->assertSee('Products');
    });
});

// ── Orders Resource ────────────────────────────────────────────────────

test('store owner can view orders list', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/orders')
            ->waitForText('Orders')
            ->assertSee('Orders');
    });
});

// ── Staff Resource ─────────────────────────────────────────────────────

test('store owner can view staff list', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/store-staff')
            ->waitForText('Staff')
            ->assertSee('Staff Members');
    });
});

// ── Reviews Resource ───────────────────────────────────────────────────

test('store owner can view reviews list', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/reviews')
            ->waitForText('Reviews')
            ->assertSee('Reviews');
    });
});

// ── Store Profile Page ─────────────────────────────────────────────────

test('store owner can access store profile page', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/store-profile')
            ->waitForText('Store Profile')
            ->assertSee('Store Profile');
    });
});

// ── Store Earnings Page ────────────────────────────────────────────────

test('store owner can access earnings page', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->storePath().'/store-earnings')
            ->waitForText('Earnings & Payouts')
            ->assertSee('Earnings & Payouts');
    });
});
