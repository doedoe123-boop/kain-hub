<?php

namespace App\Http\Requests;

use App\Models\Store;
use App\TicketCategory;
use App\TicketPriority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreSupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'category' => ['required', Rule::enum(TicketCategory::class)],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'sector' => ['nullable', 'string', 'max:50'],
            'store_id' => ['nullable', 'integer', 'exists:stores,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->isNotEmpty() || ! $this->filled('store_id')) {
                    return;
                }

                $store = Store::query()->find($this->integer('store_id'));

                if (! $store) {
                    return;
                }

                if ($this->filled('sector') && $this->string('sector')->toString() !== (string) $store->sector) {
                    $validator->errors()->add(
                        'sector',
                        'The selected sector does not match the referenced store.'
                    );
                }
            },
        ];
    }
}
