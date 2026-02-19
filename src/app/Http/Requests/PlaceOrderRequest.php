<?php

namespace App\Http\Requests;

use App\StoreStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Validates order placement requests.
 *
 * Ensures the store exists, is approved, and the customer is authorised.
 *
 * @see /skills/order-processing.md
 * @see /agent/order-agent.md
 */
class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Order::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * Adds an after-validation hook to verify the store is approved.
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $store = \App\Models\Store::query()->find($this->validated('store_id'));

                if ($store && $store->status !== StoreStatus::Approved) {
                    $validator->errors()->add(
                        'store_id',
                        'This store is not currently accepting orders.'
                    );
                }
            },
        ];
    }

    /**
     * Get custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'store_id.required' => 'A store must be selected for this order.',
            'store_id.exists' => 'The selected store does not exist.',
            'store_id.integer' => 'The store identifier must be valid.',
        ];
    }
}
