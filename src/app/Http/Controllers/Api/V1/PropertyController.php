<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Read-only property browsing endpoints for the customer storefront.
 *
 * Properties belong to real estate stores and are managed in the Realty panel.
 * This controller surfaces only active, published listings.
 */
class PropertyController extends Controller
{
    public function __construct(
        private PropertyService $propertyService
    ) {}

    /**
     * List active published properties with optional filters.
     *
     * Supported query params:
     *   search, type, listing_type, min_price, max_price, bedrooms, city, featured, per_page
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->propertyService->browse(
                $request->only([
                    'search',
                    'type',
                    'listing_type',
                    'min_price',
                    'max_price',
                    'bedrooms',
                    'city',
                    'featured',
                    'per_page',
                ])
            )
        );
    }

    /**
     * Show a single active property by slug, incrementing its view counter.
     */
    public function show(string $slug): JsonResponse
    {
        return response()->json(
            $this->propertyService->findBySlugOrFail($slug)
        );
    }
}
