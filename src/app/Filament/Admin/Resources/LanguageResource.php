<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LanguageResource\Pages;
use Lunar\Admin\Filament\Resources\LanguageResource as BaseLanguageResource;

class LanguageResource extends BaseLanguageResource
{
    protected static ?string $permission = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 13;

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup;
    }

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
