<?php

namespace App\Services;

use App\Models\Property;
use App\PropertyStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Read-only property browsing service for the customer storefront.
 *
 * Only active, published properties are ever surfaced publicly.
 *
 * @see /skills/store-management.md
 */
class PropertyService
{
    /**
     * Browse active published properties with optional filters.
     *
     * @param  array{search?: string, type?: string, listing_type?: string, min_price?: numeric, max_price?: numeric, bedrooms?: int, city?: string, featured?: bool, per_page?: int}  $params
     */
    public function browse(array $params = []): LengthAwarePaginator
    {
        $query = Property::query()
            ->with('store:id,name,slug,logo')
            ->where('status', PropertyStatus::Active)
            ->whereNotNull('published_at')
            ->latest('published_at');

        if (! empty($params['search'])) {
            $search = $params['search'];
            // LIKE is case-insensitive by default in both SQLite (tests) and
            // PostgreSQL (production) for ASCII characters.
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address_line', 'like', "%{$search}%");
            });
        }

        if (! empty($params['type'])) {
            $query->where('property_type', $params['type']);
        }

        if (! empty($params['listing_type'])) {
            $query->where('listing_type', $params['listing_type']);
        }

        if (isset($params['min_price']) && $params['min_price'] !== '') {
            $query->where('price', '>=', $params['min_price']);
        }

        if (isset($params['max_price']) && $params['max_price'] !== '') {
            $query->where('price', '<=', $params['max_price']);
        }

        if (! empty($params['bedrooms'])) {
            $query->where('bedrooms', '>=', (int) $params['bedrooms']);
        }

        if (! empty($params['city'])) {
            $query->where('city', 'like', "%{$params['city']}%");
        }

        if (! empty($params['featured'])) {
            $query->where('is_featured', true);
        }

        return $query->paginate($params['per_page'] ?? 12);
    }

    /**
     * Return the N most recently published featured (or just latest) active properties.
     *
     * @return Collection<int, Property>
     */
    public function featured(int $limit = 4): Collection
    {
        return Property::query()
            ->where('status', PropertyStatus::Active)
            ->whereNotNull('published_at')
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Find a single active property by slug, increment its view count, and return it.
     */
    public function findBySlugOrFail(string $slug): Property
    {
        $property = Property::query()
            ->with('store:id,name,slug,logo,agent_bio,agent_photo,phone')
            ->where('slug', $slug)
            ->where('status', PropertyStatus::Active)
            ->firstOrFail();

        $property->increment('views_count');

        return $property->fresh(['store']);
    }
}
