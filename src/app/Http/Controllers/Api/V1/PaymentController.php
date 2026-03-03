<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\OrderStatus;
use App\PaymentStatus;
use App\Services\PayMongoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Handles payment intent creation for the customer checkout flow.
 *
 * Step 1 of the two-step payment flow:
 *   1. POST /api/v1/orders/{order}/intent  → returns client_key  (this controller)
 *   2. Frontend collects card/GCash via PayMongo JS SDK
 *   3. PayMongo fires webhook → WebhookController transitions the order
 *
 * @see App\Http\Controllers\Webhooks\PayMongoController
 */
class PaymentController extends Controller
{
    public function __construct(
        private PayMongoService $payMongo
    ) {}

    /**
     * Create a PayMongo PaymentIntent for the given order.
     *
     * - Order must be owned by the authenticated user.
     * - Order must be in Pending status (not already paid or failed).
     * - Idempotent: if the order already has a payment_intent_id, returns the
     *   existing client_key so the frontend can safely retry.
     */
    public function intent(Request $request, Order $order): JsonResponse
    {
        $this->authorize('createIntent', $order);

        // Guard: only Pending orders may initiate payment.
        if ($order->status !== OrderStatus::Pending->value) {
            throw ValidationException::withMessages([
                'status' => 'A payment intent can only be created for a Pending order.',
            ]);
        }

        // Idempotency: return the existing intent if one was already created.
        if ($order->payment_intent_id) {
            return response()->json([
                'payment_intent_id' => $order->payment_intent_id,
                'client_key' => $order->payment_client_key,
                'order_id' => $order->id,
            ]);
        }

        $description = "Order #{$order->id} — ".($order->store?->name ?? 'Kain Hub');

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
}
