<?php

use App\Models\Store;
use App\Models\User;
use App\UserRole;

describe('Support ticket API', function () {
    it('creates a support ticket for the authenticated customer', function () {
        $user = User::factory()->create(['role' => UserRole::Customer]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/user/support-tickets', [
                'subject' => 'Need help with my order',
                'message' => 'I need help with my order status and delivery timeline.',
                'category' => 'order_issue',
                'priority' => 'medium',
            ])
            ->assertCreated()
            ->assertJsonPath('data.user_id', $user->id);
    });

    it('rejects a support ticket when sector does not match the referenced store', function () {
        $user = User::factory()->create(['role' => UserRole::Customer]);
        $store = Store::factory()->sector('ecommerce')->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/user/support-tickets', [
                'subject' => 'Wrong sector test',
                'message' => 'This message is long enough to pass the minimum length.',
                'category' => 'general',
                'priority' => 'medium',
                'sector' => 'real_estate',
                'store_id' => $store->id,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('sector');
    });

    it('uses the store sector when none is provided', function () {
        $user = User::factory()->create(['role' => UserRole::Customer]);
        $store = Store::factory()->sector('real_estate')->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/user/support-tickets', [
                'subject' => 'Store issue',
                'message' => 'This message is long enough to pass the minimum length.',
                'category' => 'general',
                'priority' => 'high',
                'store_id' => $store->id,
            ])
            ->assertCreated();

        $this->assertDatabaseHas('support_tickets', [
            'user_id' => $user->id,
            'store_id' => $store->id,
            'sector' => 'real_estate',
        ]);
    });
});
