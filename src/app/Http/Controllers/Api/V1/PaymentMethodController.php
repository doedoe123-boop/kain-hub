<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentMethodController extends Controller
{
    /**
     * List saved payment methods for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $methods = $request->user()
            ->paymentMethods()
            ->orderByDesc('is_default')
            ->orderBy('created_at')
            ->get();

        return response()->json(['data' => $methods]);
    }

    /**
     * Attach a PayMongo payment method to the user and save it locally.
     *
     * The frontend should create the PaymentMethod via PayMongo.js first,
     * then pass the resulting payment_method_id here.
     */
    public function store(StorePaymentMethodRequest $request): JsonResponse
    {
        $user = $request->user();
        $paymongoMethodId = $request->validated('paymongo_payment_method_id');

        $customerId = $this->ensurePaymongoCustomer($user);

        // Attach the payment method to the PayMongo customer.
        $attachResponse = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->post("https://api.paymongo.com/v1/customers/{$customerId}/payment_methods", [
                'data' => ['id' => $paymongoMethodId],
            ]);

        if (! $attachResponse->successful()) {
            return response()->json(['message' => 'Failed to attach payment method.'], 422);
        }

        $pmData = $attachResponse->json('data.attributes');
        $isFirstMethod = $user->paymentMethods()->count() === 0;

        $method = DB::transaction(function () use ($user, $paymongoMethodId, $customerId, $pmData, $isFirstMethod) {
            if ($isFirstMethod) {
                $user->paymentMethods()->update(['is_default' => false]);
            }

            return $user->paymentMethods()->create([
                'paymongo_id'           => $paymongoMethodId,
                'paymongo_customer_id'  => $customerId,
                'brand'                 => $pmData['details']['brand'] ?? null,
                'last4'                 => $pmData['details']['last4'] ?? null,
                'exp_month'             => $pmData['details']['exp_month'] ?? null,
                'exp_year'              => $pmData['details']['exp_year'] ?? null,
                'is_default'            => $isFirstMethod,
            ]);
        });

        return response()->json($method, 201);
    }

    /**
     * Remove a saved payment method.
     */
    public function destroy(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('delete', $paymentMethod);

        $wasDefault = $paymentMethod->is_default;
        $paymentMethod->delete();

        if ($wasDefault) {
            $request->user()->paymentMethods()->oldest()->first()?->update(['is_default' => true]);
        }

        return response()->json(null, 204);
    }

    /**
     * Set a payment method as the user's default.
     */
    public function setDefault(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        $this->authorize('update', $paymentMethod);

        DB::transaction(function () use ($request, $paymentMethod) {
            $request->user()->paymentMethods()->update(['is_default' => false]);
            $paymentMethod->update(['is_default' => true]);
        });

        return response()->json($paymentMethod->fresh());
    }

    /**
     * Retrieve the user's PayMongo customer ID, creating one if it doesn't exist.
     */
    private function ensurePaymongoCustomer(\App\Models\User $user): string
    {
        if ($user->paymongo_customer_id) {
            return $user->paymongo_customer_id;
        }

        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->post('https://api.paymongo.com/v1/customers', [
                'data' => [
                    'attributes' => [
                        'email' => $user->email,
                        'first_name' => $user->name,
                    ],
                ],
            ]);

        $customerId = $response->json('data.id');
        $user->update(['paymongo_customer_id' => $customerId]);

        return $customerId;
    }
}
