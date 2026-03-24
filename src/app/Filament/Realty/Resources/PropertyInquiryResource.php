<?php

namespace App\Filament\Realty\Resources;

use App\Filament\Realty\Resources\PropertyInquiryResource\Pages;
use App\InquiryStatus;
use App\Models\PropertyInquiry;
use App\RentalAgreementStatus;
use App\Services\RentalAgreementService;
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

    protected static function defaultMonthlyRentForInquiry(PropertyInquiry $record): float
    {
        return (float) ($record->property?->price ?? 0);
    }

    protected static function defaultSecurityDepositForInquiry(PropertyInquiry $record): float
    {
        return static::defaultMonthlyRentForInquiry($record) * 2;
    }

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
            ->with(['property', 'rentalAgreement']);
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

                Tables\Columns\TextColumn::make('rentalAgreement.status')
                    ->label('Agreement')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state
                        ? (RentalAgreementStatus::tryFrom($state)?->label() ?? ucfirst($state))
                        : '—')
                    ->color(fn (?string $state): string => $state
                        ? (RentalAgreementStatus::tryFrom($state)?->color() ?? 'gray')
                        : 'gray')
                    ->placeholder('—'),

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

                Tables\Actions\Action::make('convertToAgreement')
                    ->label('Convert to Agreement')
                    ->icon('heroicon-o-document-plus')
                    ->color('success')
                    ->form(fn (Model $record): array => [
                        Forms\Components\TextInput::make('tenant_name')
                            ->label('Tenant Name')
                            ->required()
                            ->default($record->name),
                        Forms\Components\TextInput::make('tenant_email')
                            ->email()
                            ->required()
                            ->default($record->email),
                        Forms\Components\TextInput::make('tenant_phone')
                            ->tel()
                            ->default($record->phone),
                        Forms\Components\TextInput::make('monthly_rent')
                            ->label('Monthly Rent (₱)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(static::defaultMonthlyRentForInquiry($record)),
                        Forms\Components\TextInput::make('security_deposit')
                            ->label('Security Deposit (₱)')
                            ->numeric()
                            ->minValue(0)
                            ->default(static::defaultSecurityDepositForInquiry($record)),
                        Forms\Components\DatePicker::make('move_in_date')
                            ->required()
                            ->default(
                                $record->viewing_date?->copy()->addWeek()->toDateString() ?? now()->addWeek()->toDateString()
                            ),
                        Forms\Components\TextInput::make('lease_term_months')
                            ->numeric()
                            ->minValue(1)
                            ->default(12),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->default($record->message)
                            ->columnSpanFull(),
                    ])
                    ->action(function (Model $record, array $data): void {
                        $agreement = app(RentalAgreementService::class)->convertInquiryToAgreement($record, $data);

                        Notification::make()
                            ->title('Rental agreement created')
                            ->body('The tenant can now review and sign this agreement in their account.')
                            ->success()
                            ->send();

                        redirect(RentalAgreementResource::getUrl('edit', ['record' => $agreement]));
                    })
                    ->visible(fn (Model $record): bool => $record->canConvertToRentalAgreement()),

                Tables\Actions\Action::make('viewAgreement')
                    ->label('View Agreement')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (Model $record): string => RentalAgreementResource::getUrl('edit', ['record' => $record->rental_agreement_id]))
                    ->openUrlInNewTab(false)
                    ->visible(fn (Model $record): bool => $record->rental_agreement_id !== null),
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
