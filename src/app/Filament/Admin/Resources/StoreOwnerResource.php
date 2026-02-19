<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StoreOwnerResource\Pages;
use App\Models\User;
use App\StoreStatus;
use App\UserRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreOwnerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?string $navigationLabel = 'Store Owners';

    protected static ?string $modelLabel = 'Store Owner';

    protected static ?string $pluralModelLabel = 'Store Owners';

    protected static ?string $slug = 'store-owners';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Owner Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])->columns(2),
                Forms\Components\Section::make('Store')
                    ->schema([
                        Forms\Components\Placeholder::make('store_name')
                            ->label('Store Name')
                            ->content(fn (User $record): string => $record->store?->name ?? 'N/A'),
                        Forms\Components\Placeholder::make('store_status')
                            ->label('Store Status')
                            ->content(fn (User $record): string => $record->store?->status?->value
                                ? ucfirst($record->store->status->value)
                                : 'N/A'),
                        Forms\Components\Placeholder::make('store_created')
                            ->label('Store Created')
                            ->content(fn (User $record): string => $record->store?->created_at?->diffForHumans() ?? 'N/A'),
                    ])->columns(3)
                    ->visibleOn(['view', 'edit']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('Store')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.status')
                    ->label('Store Status')
                    ->badge()
                    ->color(fn (?StoreStatus $state): string => match ($state) {
                        StoreStatus::Pending => 'warning',
                        StoreStatus::Approved => 'success',
                        StoreStatus::Suspended => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('store_status')
                    ->label('Store Status')
                    ->options(collect(StoreStatus::cases())->mapWithKeys(
                        fn (StoreStatus $status) => [$status->value => ucfirst($status->value)]
                    ))
                    ->query(fn ($query, array $data) => $data['value']
                        ? $query->whereHas('store', fn ($q) => $q->where('status', $data['value']))
                        : $query
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Scope to only show store owners.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('role', UserRole::StoreOwner)
            ->with('store');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreOwners::route('/'),
            'view' => Pages\ViewStoreOwner::route('/{record}'),
            'edit' => Pages\EditStoreOwner::route('/{record}/edit'),
        ];
    }
}
