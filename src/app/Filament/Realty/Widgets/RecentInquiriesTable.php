<?php

namespace App\Filament\Realty\Widgets;

use App\InquiryStatus;
use App\Models\PropertyInquiry;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentInquiriesTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Inquiries';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $store = auth()->user()?->getStoreForPanel();

        return $table
            ->query(
                PropertyInquiry::query()
                    ->where('store_id', $store?->id)
                    ->with('property')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Contact'),

                Tables\Columns\TextColumn::make('email'),

                Tables\Columns\TextColumn::make('property.title')
                    ->label('Property')
                    ->limit(30),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (InquiryStatus $state): string => $state->label())
                    ->color(fn (InquiryStatus $state): string => $state->color()),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->since(),
            ])
            ->paginated(false);
    }
}
