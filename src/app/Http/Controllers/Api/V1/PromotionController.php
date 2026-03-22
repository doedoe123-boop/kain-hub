<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Support\HtmlSanitizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Public promotion endpoints for the customer storefront.
 *
 * Returns only active, non-expired promotions for display as banners,
 * badges, or sale sections.
 */
class PromotionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $promotions = Promotion::query()
            ->active()
            ->orderByDesc('starts_at')
            ->limit(max(1, min((int) $request->input('limit', 10), 20)))
            ->get([
                'id', 'name', 'description', 'type', 'discount_percentage',
                'discount_amount_cents', 'starts_at', 'ends_at',
            ]);

        return response()->json(
            $promotions->map(fn (Promotion $promotion): array => [
                'id' => $promotion->id,
                'name' => HtmlSanitizer::sanitize($promotion->name),
                'description' => HtmlSanitizer::sanitize($promotion->description),
                'type' => $promotion->type?->value,
                'discount_percentage' => $promotion->discount_percentage,
                'discount_amount_cents' => $promotion->discount_amount_cents,
                'starts_at' => $promotion->starts_at,
                'ends_at' => $promotion->ends_at,
            ])
        );
    }
}
