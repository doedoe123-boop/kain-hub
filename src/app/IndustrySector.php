<?php

namespace App;

use App\Models\Sector;

/**
 * Thin compatibility shim — delegates to the Sector model.
 *
 * @deprecated Use App\Models\Sector directly. This class is kept only
 *             to avoid breaking any external references during migration.
 */
enum IndustrySector: string
{
    case FoodAndBeverage = 'food_and_beverage';
    case RealEstate      = 'real_estate';

    public function label(): string
    {
        return Sector::where('slug', $this->value)->value('name') ?? $this->value;
    }

    public function description(): string
    {
        return Sector::where('slug', $this->value)->value('description') ?? '';
    }

    public function icon(): string
    {
        return Sector::where('slug', $this->value)->value('icon') ?? 'heroicon-o-building-storefront';
    }

    public function color(): string
    {
        return Sector::where('slug', $this->value)->value('color') ?? 'indigo';
    }

    /** @return array<int, array{key: string, label: string, description: string, required: bool, mimes: string}> */
    public function requiredDocuments(): array
    {
        $sector = Sector::where('slug', $this->value)->first();

        return $sector ? $sector->documentsArray() : [];
    }

    /** @return list<string> */
    public function requiredDocumentKeys(): array
    {
        $sector = Sector::where('slug', $this->value)->first();

        return $sector ? $sector->requiredDocumentKeys() : [];
    }
}
