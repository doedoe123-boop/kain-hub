<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LoginHistoryResource\Pages;
use App\Models\LoginHistory;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoginHistoryResource extends Resource
{
    protected static ?string $model = LoginHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?string $navigationGroup = 'Security';

    protected static ?string $navigationLabel = 'Login History';

    protected static ?string $modelLabel = 'Login Attempt';

    protected static ?string $pluralModelLabel = 'Login History';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Login Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('email')
                            ->icon('heroicon-o-envelope'),
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('User')
                            ->default('Unknown / Failed'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'success' ? 'success' : 'danger'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Timestamp')
                            ->dateTime('M d, Y h:i:s A'),
                    ])->columns(2),

                Infolists\Components\Section::make('Request Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->icon('heroicon-o-globe-alt'),
                        Infolists\Components\TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->default('—')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'success' ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'success' => 'Success',
                        'failure' => 'Failure',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoginHistories::route('/'),
            'view' => Pages\ViewLoginHistory::route('/{record}'),
        ];
    }
}
