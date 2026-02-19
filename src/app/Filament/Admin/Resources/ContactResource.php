<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContactResource\Pages;
use App\Models\User;
use App\UserRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'People';

    protected static ?string $navigationLabel = 'Contacts';

    protected static ?string $modelLabel = 'Contact';

    protected static ?string $pluralModelLabel = 'Contacts';

    protected static ?string $slug = 'contacts';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('role')
                            ->options(collect(UserRole::cases())->mapWithKeys(
                                fn (UserRole $role) => [$role->value => ucfirst($role->value)]
                            ))
                            ->required()
                            ->disabled(),
                    ])->columns(2),
                Forms\Components\Section::make('Store Information')
                    ->schema([
                        Forms\Components\Placeholder::make('store_name')
                            ->label('Store')
                            ->content(fn (User $record): string => $record->store?->name ?? 'N/A'),
                        Forms\Components\Placeholder::make('store_status')
                            ->label('Status')
                            ->content(fn (User $record): string => $record->store?->status?->value
                                ? ucfirst($record->store->status->value)
                                : 'N/A'),
                    ])->columns(2)
                    ->visibleOn(['view', 'edit'])
                    ->visible(fn (?User $record): bool => $record?->isStoreOwner() === true),
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
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (UserRole $state): string => match ($state) {
                        UserRole::Admin => 'primary',
                        UserRole::StoreOwner => 'success',
                        UserRole::Customer => 'info',
                    })
                    ->formatStateUsing(fn (UserRole $state): string => ucfirst($state->value))
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label('Store')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(collect(UserRole::cases())->mapWithKeys(
                        fn (UserRole $role) => [$role->value => ucfirst($role->value)]
                    )),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Show all non-admin users (customers and store owners).
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('role', '!=', UserRole::Admin)
            ->with('store');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view' => Pages\ViewContact::route('/{record}'),
        ];
    }
}
