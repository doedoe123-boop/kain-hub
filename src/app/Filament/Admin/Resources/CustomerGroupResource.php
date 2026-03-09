<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerGroupResource\Pages;
use Lunar\Admin\Filament\Resources\CustomerGroupResource as BaseCustomerGroupResource;

class CustomerGroupResource extends BaseCustomerGroupResource
{
    protected static ?string $permission = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 12;

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup;
    }

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListCustomerGroups::route('/'),
            'create' => Pages\CreateCustomerGroup::route('/create'),
            'edit' => Pages\EditCustomerGroup::route('/{record}/edit'),
        ];
    }
}
