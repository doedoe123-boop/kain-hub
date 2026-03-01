<?php

namespace App\Filament\Admin\Resources\StoreResource\RelationManagers;

use App\UserRole;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StaffRelationManager extends RelationManager
{
    protected static string $relationship = 'staffMembers';

    protected static ?string $title = 'Staff Members';

    protected static ?string $icon = 'heroicon-o-user-group';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn (?UserRole $state): string => $state ? str($state->name)->headline()->toString() : '—')
                    ->badge()
                    ->color(fn (?UserRole $state): string => match ($state) {
                        UserRole::StoreOwner => 'warning',
                        UserRole::Staff => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('name');
    }
}
