<?php

namespace App\Filament\Realty\Widgets;

use App\Models\Testimonial;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class LatestReviewsTable extends BaseWidget
{
    protected static ?string $heading = 'Latest Reviews';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $store = auth()->user()?->getStoreForPanel();

        return $table
            ->query(
                Testimonial::query()
                    ->where('store_id', $store?->id)
                    ->where('is_published', true)
                    ->with('property')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('content')
                    ->limit(80)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->wrap(),

                Tables\Columns\TextColumn::make('property.title')
                    ->label('Property')
                    ->limit(25)
                    ->placeholder('General Review')
                    ->url(fn (Model $record): ?string => $record->property_id
                        ? route('filament.realty.resources.properties.edit', ['record' => $record->property_id])
                        : null
                    )
                    ->color('primary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable(),
            ])
            ->paginated([5])
            ->defaultSort('created_at', 'desc');
    }
}
