<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Support\HtmlSanitizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Public announcement endpoints for the customer storefront.
 *
 * Returns only active, non-expired announcements suitable for display
 * as a top-of-page banner or toast notification.
 */
class AnnouncementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Announcement::query()
            ->active()
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');

        if ($request->filled('audience')) {
            $query->where('audience', $request->input('audience'));
        }

        $announcements = $query->limit(max(1, min((int) $request->input('limit', 5), 10)))
            ->get(['id', 'title', 'content', 'type', 'audience', 'published_at', 'expires_at']);

        return response()->json(
            $announcements->map(fn (Announcement $announcement): array => [
                'id' => $announcement->id,
                'title' => strip_tags((string) $announcement->title),
                'content' => HtmlSanitizer::sanitize($announcement->content),
                'type' => $announcement->type,
                'audience' => $announcement->audience,
                'published_at' => $announcement->published_at,
                'expires_at' => $announcement->expires_at,
            ])
        );
    }
}
