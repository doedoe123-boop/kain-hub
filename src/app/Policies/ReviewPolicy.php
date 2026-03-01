<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Store owners can view reviews for their store
        if ($user->isStoreOwner() && $review->store_id === $user->store?->id) {
            return true;
        }

        return $review->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can update the model.
     *
     * Only admins and the store owner can moderate reviews.
     */
    public function update(User $user, Review $review): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isStoreOwner() && $review->store_id === $user->store?->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // Customers can delete their own reviews
        return $review->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        return $user->isAdmin();
    }
}
