<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Models\Store;
use App\StoreStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?int $navigationSort = 1;

    /**
     * Only admins can access the store management resource.
     */
    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user?->isAdmin() === true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Store Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->options(collect(StoreStatus::cases())->mapWithKeys(
                                fn (StoreStatus $status) => [$status->value => ucfirst($status->value)]
                            ))
                            ->required(),
                        Forms\Components\TextInput::make('commission_rate')
                            ->numeric()
                            ->suffix('%')
                            ->default(15.00)
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.01),
                    ])->columns(2),
                Forms\Components\Section::make('Owner')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (StoreStatus $state): string => match ($state) {
                        StoreStatus::Pending => 'warning',
                        StoreStatus::Approved => 'success',
                        StoreStatus::Suspended => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_rate')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(StoreStatus::cases())->mapWithKeys(
                        fn (StoreStatus $status) => [$status->value => ucfirst($status->value)]
                    )),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Store $record): bool => $record->status !== StoreStatus::Approved)
                    ->action(fn (Store $record) => $record->update(['status' => StoreStatus::Approved])),
                Tables\Actions\Action::make('suspend')
                    ->label('Suspend')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Store $record): bool => $record->status !== StoreStatus::Suspended)
                    ->action(fn (Store $record) => $record->update(['status' => StoreStatus::Suspended])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'view' => Pages\ViewStore::route('/{record}'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
