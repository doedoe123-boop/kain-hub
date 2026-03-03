<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Thin wrapper around the PayMongo v1 API.
 *
 * Responsibility: HTTP transport only.  Business rules (which order to charge,
 * what to do on success/failure) live in OrderService.
 *
 * @see https://developers.paymongo.com/reference
 */
class PayMongoService
{
    private const BASE_URL = 'https://api.paymongo.com/v1';

    /**
     * Create a PayMongo PaymentIntent.
     *
     * Returns the key fields needed by the frontend SDK.
     *
     * @return array{id: string, client_key: string, status: string}
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function createPaymentIntent(int $amountCentavos, string $description = ''): array
    {
        $response = Http::withBasicAuth(config('services.paymongo.secret_key'), '')
            ->post(self::BASE_URL.'/payment_intents', [
                'data' => [
                    'attributes' => [
                        'amount' => $amountCentavos,
                        'payment_method_allowed' => ['card', 'gcash', 'paymaya'],
                        'payment_method_options' => [
                            'card' => ['request_three_d_secure' => 'any'],
                        ],
                        'currency' => 'PHP',
                        'capture_type' => 'automatic',
                        'description' => $description,
                    ],
                ],
            ]);

        $response->throw();

        $attrs = $response->json('data.attributes');

        return [
            'id' => $response->json('data.id'),
            'client_key' => $attrs['client_key'],
            'status' => $attrs['status'],
        ];
    }

    /**
     * Verify a PayMongo webhook signature.
     *
     * PayMongo sends a `Paymongo-Signature` header in the format:
     *   t=<timestamp>,te=<test-hmac>,li=<live-hmac>
     *
     * We rebuild the signed payload as "<timestamp>.<rawBody>" and compare
     * HMAC-SHA256 against the appropriate secret.
     *
     * @see https://developers.paymongo.com/docs/webhook-signature-verification
     */
    public function verifyWebhookSignature(string $rawPayload, string $signatureHeader): bool
    {
        $parts = [];
        foreach (explode(',', $signatureHeader) as $part) {
            [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
            $parts[$key] = $value;
        }

        $timestamp = $parts['t'] ?? '';
        $isTestMode = app()->environment('testing', 'local', 'staging');
        $receivedHmac = $isTestMode ? ($parts['te'] ?? '') : ($parts['li'] ?? '');

        if (! $timestamp || ! $receivedHmac) {
            return false;
        }

        $secret = $isTestMode
            ? config('services.paymongo.webhook_secret_test')
            : config('services.paymongo.webhook_secret_live');

        $signedPayload = "{$timestamp}.{$rawPayload}";
        $expected = hash_hmac('sha256', $signedPayload, $secret);

        return hash_equals($expected, $receivedHmac);
    }

    /**
     * Extract the canonical event type and payment intent ID from a webhook payload.
     *
     * @param  array<string, mixed>  $payload
     * @return array{event: string, payment_intent_id: string|null, status: string|null}
     */
    public function parseWebhookEvent(array $payload): array
    {
        $eventType = $payload['data']['attributes']['type'] ?? '';
        $piId = $payload['data']['attributes']['data']['attributes']['payment_intent_id']
            ?? $payload['data']['attributes']['data']['id']
            ?? null;
        $status = $payload['data']['attributes']['data']['attributes']['status'] ?? null;

        return [
            'event' => $eventType,
            'payment_intent_id' => $piId,
            'status' => $status,
        ];
    }
}
