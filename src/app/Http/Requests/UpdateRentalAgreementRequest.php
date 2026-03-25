<?php

namespace App\Http\Requests;

use App\RentalAgreementStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRentalAgreementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        $allowedStatuses = implode(',', [
            RentalAgreementStatus::Signed->value,
            RentalAgreementStatus::Negotiating->value,
        ]);

        return [
            'status' => ['sometimes', 'string', "in:{$allowedStatuses}"],
            'tenant_questions' => ['sometimes', 'nullable', 'string', 'max:3000'],
        ];
    }

    /**
     * @return array<int, \Closure(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->input('status') === 'negotiating' && blank($this->input('tenant_questions'))) {
                    $validator->errors()->add('tenant_questions', 'Please add your question before sending this agreement back for review.');
                }
            },
        ];
    }
}
