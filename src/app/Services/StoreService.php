<?php

namespace App\Services;

use App\Models\Store;
use App\Models\User;
use App\StoreStatus;
use App\UserRole;

/**
 * Handles store registration, approval, and management.
 *
 * @see /skills/store-management.md
 * @see /agent/store-agent.md
 */
class StoreService
{
    /**
     * Register a new store for a user.
     */
    public function register(User $user, array $data): Store
    {
        $user->update(['role' => UserRole::StoreOwner]);

        return Store::query()->create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'logo' => $data['logo'] ?? null,
            'address' => $data['address'] ?? null,
            'commission_rate' => $data['commission_rate'] ?? 15.00,
            'status' => StoreStatus::Pending,
        ]);
    }

    /**
     * Approve a pending store.
     */
    public function approve(Store $store): Store
    {
        $store->update(['status' => StoreStatus::Approved]);

        return $store->refresh();
    }

    /**
     * Suspend an active store with a reason.
     */
    public function suspend(Store $store, string $reason): Store
    {
        $store->update([
            'status' => StoreStatus::Suspended,
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);

        return $store->refresh();
    }

    /**
     * Reinstate a suspended store.
     */
    public function reinstate(Store $store): Store
    {
        $store->update([
            'status' => StoreStatus::Approved,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);

        return $store->refresh();
    }
}
