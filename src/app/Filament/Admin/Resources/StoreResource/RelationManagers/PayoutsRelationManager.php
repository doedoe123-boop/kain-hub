<?php

namespace App\Filament\Admin\Resources\StoreResource\RelationManagers;

use App\Models\Payout;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PayoutsRelationManager extends RelationManager
{
    protected static string $relationship = 'payouts';

    protected static ?string $title = 'Payouts';

    protected static ?string $icon = 'heroicon-o-banknotes';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
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
                    ->default('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Payout::STATUS_PENDING => 'Pending',
                        Payout::STATUS_PAID => 'Paid',
                        Payout::STATUS_FAILED => 'Failed',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
