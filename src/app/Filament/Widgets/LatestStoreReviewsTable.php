<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use App\Models\Store;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class LatestStoreReviewsTable extends BaseWidget
{
    protected static ?string $heading = 'Latest Reviews';

    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $store = auth()->user()?->getStoreForPanel();

        return $table
            ->query(
                Review::query()
                    ->where('store_id', $store?->id)
                    ->where('is_published', true)
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('reviewer_name')
                    ->label('Reviewer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('reviewable_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Store::class => 'Store',
                        \Lunar\Models\Product::class => 'Product',
                        default => 'Other',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Store::class => 'info',
                        \Lunar\Models\Product::class => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('content')
                    ->limit(60)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_verified_purchase')
                    ->boolean()
                    ->label('Verified'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable(),
            ])
            ->paginated([5])
            ->defaultSort('created_at', 'desc');
    }
}
