<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityLogResource\Pages;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Security';

    protected static ?string $navigationLabel = 'Activity Log';

    protected static ?string $modelLabel = 'Activity';

    protected static ?string $pluralModelLabel = 'Activity Log';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Event Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('log_name')
                            ->label('Log'),
                        Infolists\Components\TextEntry::make('event')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'created' => 'success',
                                'updated' => 'info',
                                'deleted' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('description'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Timestamp')
                            ->dateTime('M d, Y h:i:s A'),
                    ])->columns(2),

                Infolists\Components\Section::make('Subject')
                    ->schema([
                        Infolists\Components\TextEntry::make('subject_type')
                            ->label('Model')
                            ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '—'),
                        Infolists\Components\TextEntry::make('subject_id')
                            ->label('ID'),
                    ])->columns(2),

                Infolists\Components\Section::make('Causer')
                    ->schema([
                        Infolists\Components\TextEntry::make('causer.name')
                            ->label('User')
                            ->default('System'),
                        Infolists\Components\TextEntry::make('causer.email')
                            ->label('Email')
                            ->default('—'),
                    ])->columns(2),

                Infolists\Components\Section::make('Changed Attributes')
                    ->schema([
                        Infolists\Components\TextEntry::make('properties.old')
                            ->label('Old Values')
                            ->formatStateUsing(fn ($state): string => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : ($state ?? '—'))
                            ->markdown()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('properties.attributes')
                            ->label('New Values')
                            ->formatStateUsing(fn ($state): string => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : ($state ?? '—'))
                            ->markdown()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),

                Tables\Columns\TextColumn::make('event')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (?string $state): string => $state ? class_basename($state) : '—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
                Tables\Filters\SelectFilter::make('subject_type')
                    ->label('Model')
                    ->options(fn (): array => Activity::query()
                        ->distinct('subject_type')
                        ->whereNotNull('subject_type')
                        ->pluck('subject_type')
                        ->mapWithKeys(fn (string $type) => [$type => class_basename($type)])
                        ->toArray()
                    ),
                Tables\Filters\SelectFilter::make('causer_id')
                    ->label('User')
                    ->relationship('causer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }
}
