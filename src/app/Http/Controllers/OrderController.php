<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Models\Store;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lunar\Facades\CartSession;

/**
 * Handles order listing, viewing, and placement.
 *
 * Delegates validation and commission logic to OrderService.
 *
 * @see /skills/order-processing.md
 * @see /agent/order-agent.md
 */
class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * List orders visible to the authenticated user.
     *
     * Admins see all orders. Store owners see their store's orders.
     * Customers see only their own orders.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = Order::query()->with('store');

        if ($user->isStoreOwner()) {
            $query->where('store_id', $user->store?->id);
        } elseif ($user->isCustomer()) {
            $query->where('user_id', $user->id);
        }

        return response()->json($query->latest()->paginate(15));
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
     * Place a new order from the current Lunar cart session.
     *
     * Validates the store, cart, and single-store constraint via OrderService.
     * Commission is calculated and persisted within a database transaction.
     *
     * @see /skills/commission-calculation.md
     */
    public function store(PlaceOrderRequest $request): JsonResponse
    {
        $store = Store::query()->findOrFail($request->validated('store_id'));
        $cart = CartSession::current();

        if (! $cart) {
            throw ValidationException::withMessages([
                'cart' => 'Cart is empty. Please add items before placing an order.',
            ]);
        }

        $order = $this->orderService->createFromCart($cart, $store);

        return response()->json([
            'message' => 'Order placed successfully.',
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ], 201);
    }
}
