<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @see /skills/store-management.md
 * @see /agent/store-agent.md
 */
class StoreController extends Controller
{
    public function __construct(
        private StoreService $storeService
    ) {}

    /**
     * List all approved stores (public) or all stores (admin).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Store::query();

        if (! $request->user()?->isAdmin()) {
            $query->where('status', 'approved');
        }

        return response()->json($query->paginate(15));
    }

    /**
     * Show a single store.
     */
    public function show(Store $store): JsonResponse
    {
        return response()->json($store);
    }

    /**
     * Register a new store.
     */
    public function store(StoreStoreRequest $request): JsonResponse
    {
        $store = $this->storeService->register(
            $request->user(),
            $request->validated()
        );

        return response()->json($store, 201);
    }

    /**
     * Approve a pending store (admin only).
     */
    public function approve(Request $request, Store $store): JsonResponse
    {
        $this->authorize('approve', $store);

        $store = $this->storeService->approve($store);

        return response()->json($store);
    }

    /**
     * Suspend an active store (admin only).
     */
    public function suspend(Request $request, Store $store): JsonResponse
    {
        $this->authorize('approve', $store);

        $store = $this->storeService->suspend($store);

        return response()->json($store);
    }
}
