<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Models\Order;
use App\OrderStatus;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?int $navigationSort = 4;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Order #'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => OrderStatus::tryFrom($state)?->label() ?? $state)
                            ->color(fn (string $state): string => OrderStatus::tryFrom($state)?->color() ?? 'gray'),
                        Infolists\Components\TextEntry::make('store.name')
                            ->label('Store')
                            ->default('—'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Placed At')
                            ->dateTime(),
                    ])->columns(2),

                Infolists\Components\Section::make('Financial Breakdown')
                    ->schema([
                        Infolists\Components\TextEntry::make('total')
                            ->label('Order Total')
                            ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—'),
                        Infolists\Components\TextEntry::make('commission_amount')
                            ->label('Commission')
                            ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—'),
                        Infolists\Components\TextEntry::make('store_earning')
                            ->label('Store Earning')
                            ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—'),
                        Infolists\Components\TextEntry::make('platform_earning')
                            ->label('Platform Earning')
                            ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('Store')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => OrderStatus::tryFrom($state)?->label() ?? $state)
                    ->color(fn (string $state): string => OrderStatus::tryFrom($state)?->color() ?? 'gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_amount')
                    ->label('Commission')
                    ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('store_earning')
                    ->label('Store Earning')
                    ->formatStateUsing(fn ($state) => is_object($state) ? number_format($state->decimal, 2) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Placed At')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(
                        fn (OrderStatus $status) => [$status->value => $status->label()]
                    )),
                Tables\Filters\SelectFilter::make('store_id')
                    ->label('Store')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
