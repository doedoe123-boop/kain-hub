<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\OrderStatus;
use App\PaymentStatus;
use App\Services\OrderService;
use App\Services\PayMongoService;
use App\Services\PayPalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lunar\Facades\CartSession;

/**
 * Handles payment operations for the customer checkout flow.
 *
 * Supports two payment providers:
 *   - PayMongo: intent-based flow (create order → create intent → JS SDK → webhook)
 *   - PayPal:   redirect-based flow (create PP order → redirect → capture on return)
 *
 * @see App\Http\Controllers\Webhooks\PayMongoController
 */
class PaymentController extends Controller
{
    public function __construct(
        private PayMongoService $payMongo,
        private PayPalService $payPal,
        private OrderService $orderService
    ) {}

    // ── PayMongo ────────────────────────────────────────────────────────

    /**
     * Create a PayMongo PaymentIntent for the given order.
     */
    public function intent(Request $request, Order $order): JsonResponse
    {
        $this->authorize('createIntent', $order);

        if ($order->status !== OrderStatus::Pending->value) {
            throw ValidationException::withMessages([
                'status' => 'A payment intent can only be created for a Pending order.',
            ]);
        }

        if ($order->payment_intent_id) {
            return response()->json([
                'payment_intent_id' => $order->payment_intent_id,
                'client_key' => $order->payment_client_key,
                'order_id' => $order->id,
            ]);
        }

        $description = "Order #{$order->id} — ".($order->store?->name ?? 'Negosyo Hub');

        $intent = $this->payMongo->createPaymentIntent(
            $order->total->value,
            $description
        );

        $order->update([
            'payment_intent_id' => $intent['id'],
            'payment_status' => PaymentStatus::Pending->value,
            'payment_client_key' => $intent['client_key'],
        ]);

        return response()->json([
            'payment_intent_id' => $intent['id'],
            'client_key' => $intent['client_key'],
            'order_id' => $order->id,
        ]);
    }

    // ── PayPal ──────────────────────────────────────────────────────────

    /**
     * POST /api/v1/paypal/create-order
     *
     * Create a PayPal order from the current cart session.
     * Returns the PayPal approval URL for customer redirect.
     */
    public function paypalCreateOrder(Request $request): JsonResponse
    {
        $cart = CartSession::current(calculate: true);

        if (! $cart || $cart->lines->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty. Please add items before placing an order.',
            ], 422);
        }

        $result = $this->payPal->createOrder($cart);

        if (! $result['id'] || ! $result['approve_url']) {
            return response()->json([
                'message' => 'Failed to create PayPal order. Please try again.',
            ], 502);
        }

        return response()->json([
            'paypal_order_id' => $result['id'],
            'approve_url' => $result['approve_url'],
        ]);
    }

    /**
     * POST /api/v1/paypal/capture-order
     *
     * Capture a PayPal order after the customer approves it.
     * Creates the Lunar order, applies commission, and clears the cart.
     */
    public function paypalCaptureOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'paypal_order_id' => ['required', 'string', 'max:100'],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
        ]);

        $paypalOrderId = $validated['paypal_order_id'];

        // Verify the PayPal order is approved before capturing.
        $paypalOrder = $this->payPal->getOrder($paypalOrderId);
        $status = $paypalOrder['status'] ?? null;

        if (! in_array($status, ['APPROVED', 'COMPLETED'], true)) {
            return response()->json([
                'message' => 'PayPal order has not been approved by the customer.',
            ], 422);
        }

        // Capture payment on PayPal.
        if ($status === 'APPROVED') {
            $paypalOrder = $this->payPal->captureOrder($paypalOrderId);
        }

        if (($paypalOrder['status'] ?? null) !== 'COMPLETED') {
            return response()->json([
                'message' => 'PayPal payment capture failed. Please try again.',
            ], 422);
        }

        // Create the Lunar order from cart.
        $cart = CartSession::current();

        if (! $cart) {
            return response()->json([
                'message' => 'Cart session expired. Please try again.',
            ], 422);
        }

        $store = Store::query()->findOrFail($validated['store_id']);
        $order = $this->orderService->createFromCart($cart, $store);

        // Record PayPal payment details on the order.
        $captureId = $paypalOrder['purchase_units'][0]['payments']['captures'][0]['id'] ?? $paypalOrderId;

        $order->update([
            'payment_intent_id' => $paypalOrderId,
            'payment_status' => PaymentStatus::Paid->value,
            'paid_at' => now(),
        ]);

        // Create a Lunar transaction record for the capture.
        $order->transactions()->create([
            'success' => true,
            'type' => 'capture',
            'driver' => 'paypal',
            'amount' => $order->total->value,
            'reference' => $captureId,
            'status' => 'COMPLETED',
            'card_type' => 'paypal',
            'captured_at' => now(),
        ]);

        // Clear the cart so retries cannot create duplicate orders.
        CartSession::manager()->clear();

        return response()->json([
            'message' => 'Payment captured and order placed successfully.',
            'order_id' => $order->id,
            'order' => $order,
            'summary' => $this->orderService->summarize($order),
        ], 201);
    }
}
