<?php

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\OrderStatus;
use App\UserRole;
use Lunar\Models\Currency;

// ── Helper ────────────────────────────────────────────────────────────────────

beforeEach(function () {
    // Lunar's Price cast requires a default Currency in the DB
    Currency::factory()->create(['default' => true, 'code' => 'PHP']);
});

// ── #3 — Null cart guard ──────────────────────────────────────────────────────

describe('#3 — null cart guard', function () {

    it('returns 422 when no cart exists for an approved store', function () {
        $user = User::factory()->create();
        $store = Store::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/v1/orders', ['store_id' => $store->id])
            ->assertStatus(422)
            ->assertJsonPath('message', 'Your cart is empty. Please add items before placing an order.');
    });

});

// ── #8 — Cancel restrictions ──────────────────────────────────────────────────

describe('#8 — cancel restrictions', function () {

    it('allows a customer to cancel their own Pending order', function () {
        $customer = User::factory()->create();
        $store = Store::factory()->create();
        $order = Order::factory()->for($store)->create([
            'user_id' => $customer->id,
            'status' => OrderStatus::Pending->value,
        ]);

        $this->actingAs($customer)
            ->patchJson("/api/v1/orders/{$order->id}/cancel")
            ->assertOk();

        expect($order->fresh()->status)->toBe(OrderStatus::Cancelled->value);
    });

    it('forbids a customer from cancelling a Confirmed order', function () {
        $customer = User::factory()->create();
        $store = Store::factory()->create();
        $order = Order::factory()->for($store)->create([
            'user_id' => $customer->id,
            'status' => OrderStatus::Confirmed->value,
        ]);

        $this->actingAs($customer)
            ->patchJson("/api/v1/orders/{$order->id}/cancel")
            ->assertForbidden();
    });

    it('allows a store owner to cancel a Confirmed order on their store', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $store = Store::factory()->create(['user_id' => $owner->id]);
        $order = Order::factory()->for($store)->create([
            'status' => OrderStatus::Confirmed->value,
        ]);

        $this->actingAs($owner)
            ->patchJson("/api/v1/orders/{$order->id}/cancel")
            ->assertOk();

        expect($order->fresh()->status)->toBe(OrderStatus::Cancelled->value);
    });

    it('forbids a store owner from cancelling an order on a different store', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $otherStore = Store::factory()->create();
        $order = Order::factory()->for($otherStore)->create([
            'status' => OrderStatus::Pending->value,
        ]);

        $this->actingAs($owner)
            ->patchJson("/api/v1/orders/{$order->id}/cancel")
            ->assertForbidden();
    });

});

// ── #8 — OrderStatus::canTransitionTo() matrix ───────────────────────────────

describe('#8 — OrderStatus state machine', function () {

    it('allows valid forward transitions', function (OrderStatus $from, OrderStatus $to) {
        expect($from->canTransitionTo($to))->toBeTrue();
    })->with([
        'pending → confirmed' => [OrderStatus::Pending,    OrderStatus::Confirmed],
        'pending → payment_failed' => [OrderStatus::Pending,    OrderStatus::PaymentFailed],
        'pending → cancelled' => [OrderStatus::Pending,    OrderStatus::Cancelled],
        'confirmed → preparing' => [OrderStatus::Confirmed,  OrderStatus::Preparing],
        'confirmed → cancelled' => [OrderStatus::Confirmed,  OrderStatus::Cancelled],
        'preparing → ready' => [OrderStatus::Preparing,  OrderStatus::Ready],
        'preparing → cancelled' => [OrderStatus::Preparing,  OrderStatus::Cancelled],
        'ready → delivered' => [OrderStatus::Ready,      OrderStatus::Delivered],
        'ready → cancelled' => [OrderStatus::Ready,      OrderStatus::Cancelled],
        'delivered → refund_pending' => [OrderStatus::Delivered,  OrderStatus::RefundPending],
        'cancelled → refund_pending' => [OrderStatus::Cancelled,  OrderStatus::RefundPending],
        'refund_pending → refunded' => [OrderStatus::RefundPending, OrderStatus::Refunded],
    ]);

    it('blocks invalid / reverse transitions', function (OrderStatus $from, OrderStatus $to) {
        expect($from->canTransitionTo($to))->toBeFalse();
    })->with([
        'pending → delivered' => [OrderStatus::Pending,       OrderStatus::Delivered],
        'confirmed → pending' => [OrderStatus::Confirmed,     OrderStatus::Pending],
        'delivered → confirmed' => [OrderStatus::Delivered,     OrderStatus::Confirmed],
        'cancelled → confirmed' => [OrderStatus::Cancelled,     OrderStatus::Confirmed],
        'payment_failed → confirmed' => [OrderStatus::PaymentFailed, OrderStatus::Confirmed],
        'refunded → pending' => [OrderStatus::Refunded,      OrderStatus::Pending],
    ]);

    it('exposes new terminal statuses in label and color', function () {
        expect(OrderStatus::PaymentFailed->label())->toBe('Payment Failed');
        expect(OrderStatus::RefundPending->label())->toBe('Refund Pending');
        expect(OrderStatus::Refunded->label())->toBe('Refunded');

        expect(OrderStatus::PaymentFailed->color())->toBe('danger');
        expect(OrderStatus::RefundPending->color())->toBe('warning');
        expect(OrderStatus::Refunded->color())->toBe('info');
    });

    it('does not include terminal statuses in active()', function () {
        $active = OrderStatus::active();

        expect($active)->not->toContain(OrderStatus::Delivered)
            ->and($active)->not->toContain(OrderStatus::Cancelled)
            ->and($active)->not->toContain(OrderStatus::PaymentFailed)
            ->and($active)->not->toContain(OrderStatus::RefundPending)
            ->and($active)->not->toContain(OrderStatus::Refunded);
    });

});

// ── #9 — Store-owner order progression endpoints ─────────────────────────────

describe('#9 — store owner order progression', function () {

    it('allows store owner to confirm a pending order', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $store = Store::factory()->create(['user_id' => $owner->id]);
        $order = Order::factory()->for($store)->create([
            'status' => OrderStatus::Pending->value,
        ]);

        $this->actingAs($owner)
            ->patchJson("/api/v1/orders/{$order->id}/confirm")
            ->assertOk()
            ->assertJsonPath('message', 'Order confirmed.');

        expect($order->fresh()->status)->toBe(OrderStatus::Confirmed->value);
    });

    it('forbids customer from confirming an order', function () {
        $customer = User::factory()->create();
        $store = Store::factory()->create();
        $order = Order::factory()->for($store)->create([
            'user_id' => $customer->id,
            'status' => OrderStatus::Pending->value,
        ]);

        $this->actingAs($customer)
            ->patchJson("/api/v1/orders/{$order->id}/confirm")
            ->assertForbidden();
    });

    it('allows store owner to walk the full lifecycle', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $store = Store::factory()->create(['user_id' => $owner->id]);
        $order = Order::factory()->for($store)->create([
            'status' => OrderStatus::Pending->value,
        ]);

        $this->actingAs($owner)->patchJson("/api/v1/orders/{$order->id}/confirm")->assertOk();
        $this->actingAs($owner)->patchJson("/api/v1/orders/{$order->id}/prepare")->assertOk();
        $this->actingAs($owner)->patchJson("/api/v1/orders/{$order->id}/ready")->assertOk();
        $this->actingAs($owner)->patchJson("/api/v1/orders/{$order->id}/deliver")->assertOk();

        expect($order->fresh()->status)->toBe(OrderStatus::Delivered->value);
    });

    it('forbids a store owner from progressing an order on a different store', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $otherStore = Store::factory()->create();
        $order = Order::factory()->for($otherStore)->create([
            'status' => OrderStatus::Confirmed->value,
        ]);

        $this->actingAs($owner)
            ->patchJson("/api/v1/orders/{$order->id}/prepare")
            ->assertForbidden();
    });

    it('returns 422 when a transition is invalid', function () {
        $owner = User::factory()->create(['role' => UserRole::StoreOwner]);
        $store = Store::factory()->create(['user_id' => $owner->id]);
        $order = Order::factory()->for($store)->create([
            'status' => OrderStatus::Pending->value,
        ]);

        // Cannot call prepare() on a Pending order (must confirm first)
        $this->actingAs($owner)
            ->patchJson("/api/v1/orders/{$order->id}/prepare")
            ->assertUnprocessable();
    });

    it('returns unauthenticated for guests on all progression endpoints', function () {
        $store = Store::factory()->create();
        $order = Order::factory()->for($store)->create([
            'status' => OrderStatus::Pending->value,
        ]);

        $this->patchJson("/api/v1/orders/{$order->id}/confirm")->assertUnauthorized();
        $this->patchJson("/api/v1/orders/{$order->id}/prepare")->assertUnauthorized();
        $this->patchJson("/api/v1/orders/{$order->id}/ready")->assertUnauthorized();
        $this->patchJson("/api/v1/orders/{$order->id}/deliver")->assertUnauthorized();
    });

});
