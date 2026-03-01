<?php

use App\Models\Store;
use App\StoreStatus;
use Laravel\Dusk\Browser;
use Tests\Browser\Concerns\CreatesTestUsers;
use Tests\Browser\Concerns\MigratesDuskDatabase;

uses(CreatesTestUsers::class, MigratesDuskDatabase::class);

// ── Authentication ─────────────────────────────────────────────────────

test('admin can log in to admin panel', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->visit($this->adminPath().'/login')
            ->waitFor('[id="data.email"]')
            ->type('[id="data.email"]', $admin->email)
            ->type('[id="data.password"]', 'password')
            ->press('Sign in')
            ->waitForLocation($this->adminPath())
            ->assertPathBeginsWith($this->adminPath())
            ->assertSee('Marketplace Admin');
    });
});

test('non-admin cannot access admin panel', function () {
    ['user' => $user] = $this->createStoreOwner();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit($this->adminPath())
            ->waitForText('403')
            ->assertSee('403');
    });
});

// ── Dashboard ──────────────────────────────────────────────────────────

test('admin dashboard shows overview widgets', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath())
            ->waitForText('Dashboard')
            ->assertSee('Dashboard');
    });
});

// ── Store Resource ─────────────────────────────────────────────────────

test('admin can view stores list', function () {
    $admin = $this->createAdmin();
    Store::factory()->count(3)->create();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/stores')
            ->waitForText('Stores')
            ->assertSee('Stores');
    });
});

test('admin can view a single store', function () {
    $admin = $this->createAdmin();
    $store = Store::factory()->create(['name' => 'Dusk Test Store']);

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/stores')
            ->waitForText('Stores')
            ->assertSee('Dusk Test Store');
    });
});

test('admin can approve a pending store', function () {
    $admin = $this->createAdmin();
    $store = Store::factory()->pending()->create(['name' => 'Pending Store']);

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/stores')
            ->waitForText('Stores')
            ->assertSee('Pending Store')
            ->assertSee('Pending');
    });

    expect($store->fresh()->status)->toBe(StoreStatus::Pending);
});

// ── User Resource ──────────────────────────────────────────────────────

test('admin can view users list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/users')
            ->waitForText('Users')
            ->assertSee('Users');
    });
});

// ── Sector Resource ────────────────────────────────────────────────────

test('admin can view sectors list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/sectors')
            ->waitForText('Industry Sectors')
            ->assertSee('Industry Sectors');
    });
});

// ── FAQ Resource ───────────────────────────────────────────────────────

test('admin can view faqs list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/faqs')
            ->waitForText('FAQs')
            ->assertSee('FAQs');
    });
});

// ── Announcement Resource ──────────────────────────────────────────────

test('admin can view announcements list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/announcements')
            ->waitForText('Announcements')
            ->assertSee('Announcements');
    });
});

// ── Order Resource ─────────────────────────────────────────────────────

test('admin can view orders list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/orders')
            ->waitForText('Orders')
            ->assertSee('Orders');
    });
});

// ── Payout Resource ────────────────────────────────────────────────────

test('admin can view payouts list', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/payouts')
            ->waitForText('Payouts')
            ->assertSee('Payouts');
    });
});

// ── Security Resources ─────────────────────────────────────────────────

test('admin can view activity logs', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/activity-logs')
            ->waitForText('Activity Log')
            ->assertSee('Activity Log');
    });
});

test('admin can view login history', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/login-histories')
            ->waitForText('Login History')
            ->assertSee('Login History');
    });
});

// ── Support Tickets ────────────────────────────────────────────────────

test('admin can view support tickets', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/support-tickets')
            ->waitForText('Tickets')
            ->assertSee('Tickets');
    });
});

// ── Legal Pages ────────────────────────────────────────────────────────

test('admin can view legal pages', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath().'/legal-pages')
            ->waitForText('Legal Pages')
            ->assertSee('Legal Pages');
    });
});

// ── Navigation ─────────────────────────────────────────────────────────

test('admin panel sidebar shows all navigation groups', function () {
    $admin = $this->createAdmin();

    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
            ->visit($this->adminPath())
            ->waitForText('Dashboard')
            ->assertSee('Marketplace')
            ->assertSee('Platform')
            ->assertSee('Security');
    });
});
