<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PayoutResource\Pages;
use App\Models\Payout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PayoutResource extends Resource
{
    protected static ?string $model = Payout::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Marketplace';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payout Details')
                    ->schema([
                        Forms\Components\Select::make('store_id')
                            ->relationship('store', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('₱')
                            ->required()
                            ->minValue(0),
                    ])->columns(2),

                Forms\Components\Section::make('Period')
                    ->schema([
                        Forms\Components\DatePicker::make('period_start')
                            ->required(),
                        Forms\Components\DatePicker::make('period_end')
                            ->required()
                            ->afterOrEqual('period_start'),
                    ])->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                Payout::STATUS_PENDING => 'Pending',
                                Payout::STATUS_PROCESSING => 'Processing',
                                Payout::STATUS_PAID => 'Paid',
                                Payout::STATUS_FAILED => 'Failed',
                            ])
                            ->required()
                            ->default(Payout::STATUS_PENDING)
                            ->native(false),
                        Forms\Components\TextInput::make('reference')
                            ->maxLength(255)
                            ->placeholder('Payment reference / transaction ID'),
                    ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Payout Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('store.name')
                            ->label('Store'),
                        Infolists\Components\TextEntry::make('amount')
                            ->money('PHP'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                Payout::STATUS_PENDING => 'warning',
                                Payout::STATUS_PROCESSING => 'info',
                                Payout::STATUS_PAID => 'success',
                                Payout::STATUS_FAILED => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('reference')
                            ->default('—'),
                    ])->columns(2),

                Infolists\Components\Section::make('Period')
                    ->schema([
                        Infolists\Components\TextEntry::make('period_start')
                            ->date(),
                        Infolists\Components\TextEntry::make('period_end')
                            ->date(),
                        Infolists\Components\TextEntry::make('paid_at')
                            ->dateTime()
                            ->default('—'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('period_start')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('period_end')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Payout::STATUS_PENDING => 'warning',
                        Payout::STATUS_PROCESSING => 'info',
                        Payout::STATUS_PAID => 'success',
                        Payout::STATUS_FAILED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Payout::STATUS_PENDING => 'Pending',
                        Payout::STATUS_PROCESSING => 'Processing',
                        Payout::STATUS_PAID => 'Paid',
                        Payout::STATUS_FAILED => 'Failed',
                    ]),
                Tables\Filters\SelectFilter::make('store_id')
                    ->label('Store')
                    ->relationship('store', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markPaid')
                    ->label('Mark Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\TextInput::make('reference')
                            ->label('Payment Reference')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->action(function (Payout $record, array $data): void {
                        $record->markPaid($data['reference']);

                        Notification::make()
                            ->title('Payout marked as paid')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Payout $record): bool => $record->isPending()),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayouts::route('/'),
            'create' => Pages\CreatePayout::route('/create'),
            'view' => Pages\ViewPayout::route('/{record}'),
            'edit' => Pages\EditPayout::route('/{record}/edit'),
        ];
    }
}
