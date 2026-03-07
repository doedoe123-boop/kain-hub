<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;

class CategoryController extends Controller
{
    /**
     * Icon mapping for known category slugs.
     *
     * Managed here so the frontend stays data-driven.
     * Unknown slugs get a generic tag emoji.
     */
    private const ICON_MAP = [
        'electronics' => '📱',
        'fashion' => '👗',
        'food' => '🛒',
        'home-living' => '🛋️',
        'beauty' => '💄',
        'sports' => '⚽',
        'gadgets' => '💻',
        'books' => '📚',
        'automotive' => '🚗',
        'toys' => '🧸',
        'health' => '💊',
        'pets' => '🐾',
        'jewelry' => '💍',
        'music' => '🎵',
        'art' => '🎨',
        'garden' => '🌿',
        'office' => '🖊️',
        'baby' => '👶',
    ];

    /**
     * Return all collections from the "Marketplace Categories" group.
     *
     * GET /api/v1/categories
     *
     * Response shape:
     * [
     *   { "id": 14, "name": "Electronics", "slug": "electronics", "icon": "📱" },
     *   ...
     * ]
     */
    public function index(): JsonResponse
    {
        $group = CollectionGroup::where('handle', 'marketplace-categories')->first();

        if (! $group) {
            return response()->json([]);
        }

        $categories = Collection::where('collection_group_id', $group->id)
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function (Collection $c): array {
                $name = $c->translateAttribute('name');
                $slug = Str::slug($name);

                return [
                    'id' => $c->id,
                    'name' => $name,
                    'slug' => $slug,
                    'icon' => self::ICON_MAP[$slug] ?? '🏷️',
                ];
            })
            ->values();

        return response()->json($categories);
    }
}
