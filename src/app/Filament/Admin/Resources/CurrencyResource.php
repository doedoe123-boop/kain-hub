<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CurrencyResource\Pages;
use Lunar\Admin\Filament\Resources\CurrencyResource as BaseCurrencyResource;

class CurrencyResource extends BaseCurrencyResource
{
    protected static ?string $permission = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 11;

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup;
    }

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}
