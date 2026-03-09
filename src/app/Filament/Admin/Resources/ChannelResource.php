<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ChannelResource\Pages;
use Lunar\Admin\Filament\Resources\ChannelResource as BaseChannelResource;

class ChannelResource extends BaseChannelResource
{
    protected static ?string $permission = null;

    protected static ?string $navigationGroup = 'E-commerce';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return static::$navigationGroup;
    }

    public static function getDefaultPages(): array
    {
        return [
            'index' => Pages\ListChannels::route('/'),
            'create' => Pages\CreateChannel::route('/create'),
            'edit' => Pages\EditChannel::route('/{record}/edit'),
        ];
    }
}
