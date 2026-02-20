<?php

namespace App\Rules;

use App\PhilippineIdType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class PhilippineIdNumber implements DataAwareRule, ValidationRule
{
    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $idType = PhilippineIdType::tryFrom($this->data['idType'] ?? '');

        if (! $idType) {
            return;
        }

        if (! preg_match($idType->pattern(), $value)) {
            $fail("The :attribute format is invalid for {$idType->label()}. Expected format: {$idType->formatHint()}");
        }
    }
}
