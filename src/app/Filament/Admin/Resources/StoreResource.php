<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StoreResource\Pages;
use App\Mail\StoreApproved;
use App\Models\Store;
use App\PhilippineIdType;
use App\StoreStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?int $navigationSort = 1;

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
                Forms\Components\Section::make('Verification Documents')
                    ->schema([
                        Forms\Components\TextInput::make('id_type')
                            ->label('ID Type')
                            ->formatStateUsing(fn (?string $state): string => PhilippineIdType::tryFrom($state ?? '')?->label() ?? ($state ?? '—'))
                            ->disabled(),
                        Forms\Components\TextInput::make('id_number')
                            ->label('ID Number')
                            ->disabled(),
                        Forms\Components\Placeholder::make('business_permit_link')
                            ->label('Business Permit')
                            ->content(function (Store $record): string {
                                if (! $record->business_permit) {
                                    return 'No document uploaded';
                                }

                                return $record->business_permit;
                            }),
                    ])->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Store Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('slug'),
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (StoreStatus $state): string => match ($state) {
                                StoreStatus::Pending => 'warning',
                                StoreStatus::Approved => 'success',
                                StoreStatus::Suspended => 'danger',
                            }),
                        Infolists\Components\TextEntry::make('commission_rate')
                            ->suffix('%'),
                    ])->columns(2),
                Infolists\Components\Section::make('Owner')
                    ->schema([
                        Infolists\Components\TextEntry::make('owner.name')
                            ->label('Name'),
                        Infolists\Components\TextEntry::make('owner.email')
                            ->label('Email'),
                        Infolists\Components\TextEntry::make('owner.phone')
                            ->label('Phone')
                            ->default('—'),
                    ])->columns(3),
                Infolists\Components\Section::make('Address')
                    ->schema([
                        Infolists\Components\TextEntry::make('address.line_one')
                            ->label('Street'),
                        Infolists\Components\TextEntry::make('address.city')
                            ->label('City'),
                        Infolists\Components\TextEntry::make('address.postcode')
                            ->label('Postcode'),
                    ])->columns(3),
                Infolists\Components\Section::make('Verification Documents')
                    ->schema([
                        Infolists\Components\TextEntry::make('id_type')
                            ->label('ID Type')
                            ->formatStateUsing(fn (?string $state): string => PhilippineIdType::tryFrom($state ?? '')?->label() ?? '—'),
                        Infolists\Components\TextEntry::make('id_number')
                            ->label('ID Number')
                            ->default('—'),
                        Infolists\Components\TextEntry::make('business_permit')
                            ->label('Business Permit')
                            ->formatStateUsing(function (?string $state): string {
                                if (! $state) {
                                    return 'No document uploaded';
                                }

                                return basename($state);
                            })
                            ->url(fn (Store $record): ?string => $record->business_permit
                                ? route('admin.stores.document', ['store' => $record, 'field' => 'business_permit'])
                                : null)
                            ->openUrlInNewTab()
                            ->color('primary'),
                    ])->columns(3),
                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])->columns(2)
                    ->collapsed(),
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
                Tables\Columns\TextColumn::make('owner.email')
                    ->label('Owner Email')
                    ->searchable()
                    ->toggleable(),
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
                    ->action(function (Store $record): void {
                        $record->update(['status' => StoreStatus::Approved]);

                        Mail::to($record->owner->email)->send(new StoreApproved($record));
                    }),
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
