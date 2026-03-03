<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Models\Store;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lunar\Facades\CartSession;

/**
 * Thin HTTP handler for customer order operations.
 *
 * Role-scoped querying, validation, and commission logic
 * all live in OrderService.
 *
 * @see /skills/order-processing.md
 */
class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * List orders visible to the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->orderService->listForUser($request->user())
        );
    }

    /**
     * Show a single order with its summary.
     */
    public function show(Request $request, Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $order->load(['store', 'lines', 'addresses']);

        return response()->json([
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ]);
    }

    /**
     * Cancel a pending or confirmed order.
     */
    public function cancel(Request $request, Order $order): JsonResponse
    {
        $this->authorize('cancel', $order);

        $order = $this->orderService->cancel($order);

        return response()->json([
            'message' => 'Order cancelled successfully.',
            'order' => $order,
        ]);
    }

    /**
     * Place a new order from the current Lunar cart session.
     *
     * Guard order: validate cart exists (422) before touching the DB.
     * After a successful order the cart is cleared so that a page-refresh,
     * network retry, or double-click cannot create a duplicate order.
     */
    public function store(PlaceOrderRequest $request): JsonResponse
    {
        // #3 — return a clean 422 instead of a fatal TypeError when no cart exists.
        $cart = CartSession::current();

        if (! $cart) {
            return response()->json([
                'message' => 'Your cart is empty. Please add items before placing an order.',
            ], 422);
        }

        // #10 — store resolution lives in the service; controller only passes
        // the validated primitive so the service owns the full domain flow.
        $store = Store::query()->findOrFail($request->validated('store_id'));

        $order = $this->orderService->createFromCart($cart, $store);

        // #4 — clear the cart so retries cannot create duplicate orders.
        CartSession::manager()->clear();

        return response()->json([
            'message' => 'Order placed successfully.',
            'order_id' => $order->id,
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ], 201);
    }

    // ── Store-owner order progression ─────────────────────────────────

    /**
     * Confirm a pending order (store owner / admin only).
     */
    public function confirm(Request $request, Order $order): JsonResponse
    {
        $this->authorize('confirm', $order);

        $order = $this->orderService->confirm($order);

        return response()->json([
            'message' => 'Order confirmed.',
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ]);
    }

    /**
     * Mark a confirmed order as preparing (store owner / admin only).
     */
    public function prepare(Request $request, Order $order): JsonResponse
    {
        $this->authorize('prepare', $order);

        $order = $this->orderService->markPreparing($order);

        return response()->json([
            'message' => 'Order is now being prepared.',
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ]);
    }

    /**
     * Mark an order as ready for pickup / delivery (store owner / admin only).
     */
    public function markReady(Request $request, Order $order): JsonResponse
    {
        $this->authorize('markReady', $order);

        $order = $this->orderService->markReady($order);

        return response()->json([
            'message' => 'Order is ready for pickup.',
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ]);
    }

    /**
     * Mark a ready order as delivered (store owner / admin only).
     */
    public function deliver(Request $request, Order $order): JsonResponse
    {
        $this->authorize('deliver', $order);

        $order = $this->orderService->markDelivered($order);

        return response()->json([
            'message' => 'Order marked as delivered.',
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ]);
    }
}
