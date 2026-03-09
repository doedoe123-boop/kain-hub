<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaxClassResource\Pages;
use Lunar\Admin\Filament\Resources\TaxClassResource as BaseTaxClassResource;

class TaxClassResource extends BaseTaxClassResource
{
    protected static ?string $permission = null;

    protected static ?string $cluster = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 14;

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListTaxClasses::route('/'),
            'create' => Pages\CreateTaxClass::route('/create'),
            'edit' => Pages\EditTaxClass::route('/{record}/edit'),
        ];
    }
}
