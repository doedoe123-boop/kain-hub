<?php

namespace App\Filament\Realty\Resources;

use App\Filament\Realty\Resources\PropertyInquiryResource\Pages;
use App\InquiryStatus;
use App\Models\PropertyInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PropertyInquiryResource extends Resource
{
    protected static ?string $model = PropertyInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Listings';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Inquiry';

    protected static ?string $pluralModelLabel = 'Inquiries';

    /**
     * Show the "new" badge count in the sidebar.
     */
    public static function getNavigationBadge(): ?string
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return null;
        }

        $count = PropertyInquiry::forStore($store->id)->new()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    /**
     * Scope all queries to the current user's store.
     */
    public static function getEloquentQuery(): Builder
    {
        $store = auth()->user()?->getStoreForPanel();

        return parent::getEloquentQuery()
            ->where('store_id', $store?->id)
            ->with(['property']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->disabled(),

                        Forms\Components\TextInput::make('phone')
                            ->disabled(),

                        Forms\Components\Textarea::make('message')
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Pipeline')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options(collect(InquiryStatus::cases())->mapWithKeys(
                                fn (InquiryStatus $s) => [$s->value => $s->label()]
                            ))
                            ->required()
                            ->native(false),

                        Forms\Components\DateTimePicker::make('viewing_date')
                            ->label('Scheduled Viewing'),

                        Forms\Components\Textarea::make('agent_notes')
                            ->label('Agent Notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Property')
                    ->schema([
                        Forms\Components\Placeholder::make('property_title')
                            ->label('Property')
                            ->content(fn (?Model $record): string => $record?->property?->title ?? '—'),

                        Forms\Components\Placeholder::make('source')
                            ->content(fn (?Model $record): string => ucfirst($record?->source ?? 'website')),

                        Forms\Components\Placeholder::make('received_at')
                            ->label('Received')
                            ->content(fn (?Model $record): string => $record?->created_at?->diffForHumans() ?? '—'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Contact')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('property.title')
                    ->label('Property')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (InquiryStatus $state): string => $state->label())
                    ->color(fn (InquiryStatus $state): string => $state->color())
                    ->sortable(),

                Tables\Columns\TextColumn::make('viewing_date')
                    ->label('Viewing')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('source')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(InquiryStatus::cases())->mapWithKeys(
                        fn (InquiryStatus $s) => [$s->value => $s->label()]
                    )),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('markContacted')
                    ->label('Mark Contacted')
                    ->icon('heroicon-o-phone')
                    ->color('warning')
                    ->action(function (Model $record): void {
                        $record->markContacted();
                        Notification::make()
                            ->title('Inquiry marked as contacted')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Model $record): bool => $record->status === InquiryStatus::New),

                Tables\Actions\Action::make('scheduleViewing')
                    ->label('Schedule Viewing')
                    ->icon('heroicon-o-calendar-days')
                    ->color('primary')
                    ->form([
                        Forms\Components\DateTimePicker::make('viewing_date')
                            ->label('Viewing Date & Time')
                            ->required()
                            ->minDate(now()),
                    ])
                    ->action(function (Model $record, array $data): void {
                        $record->scheduleViewing($data['viewing_date']);
                        Notification::make()
                            ->title('Viewing scheduled')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Model $record): bool => in_array($record->status, [
                        InquiryStatus::New,
                        InquiryStatus::Contacted,
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPropertyInquiries::route('/'),
            'edit' => Pages\EditPropertyInquiry::route('/{record}/edit'),
        ];
    }

    /**
     * Inquiries are read-only on creation — they come from the public site.
     */
    public static function canCreate(): bool
    {
        return false;
    }
}
