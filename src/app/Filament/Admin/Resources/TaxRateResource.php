<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaxRateResource\Pages;
use Lunar\Admin\Filament\Resources\TaxRateResource as BaseTaxRateResource;

class TaxRateResource extends BaseTaxRateResource
{
    protected static ?string $permission = null;

    protected static ?string $cluster = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 15;

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListTaxRates::route('/'),
            'create' => Pages\CreateTaxRate::route('/create'),
            'edit' => Pages\EditTaxRate::route('/{record}/edit'),
        ];
    }
}
