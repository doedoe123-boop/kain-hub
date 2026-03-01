<?php

namespace App\Filament\Realty\Resources;

use App\Filament\Realty\Resources\PropertyResource\Pages;
use App\ListingType;
use App\PropertyStatus;
use App\PropertyType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = \App\Models\Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Listings';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Scope all queries to the current user's store.
     */
    public static function getEloquentQuery(): Builder
    {
        $store = auth()->user()?->getStoreForPanel();

        return parent::getEloquentQuery()
            ->where('store_id', $store?->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Property')
                    ->tabs([
                        // ── Details Tab ────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Details')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state).'-'.Str::random(6))),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Auto-generated from title. You can customise it.'),

                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull()
                                    ->maxLength(5000),

                                Forms\Components\Select::make('property_type')
                                    ->options(collect(PropertyType::cases())->mapWithKeys(
                                        fn (PropertyType $type) => [$type->value => $type->label()]
                                    ))
                                    ->required()
                                    ->native(false)
                                    ->live(),

                                Forms\Components\Select::make('listing_type')
                                    ->options(collect(ListingType::cases())->mapWithKeys(
                                        fn (ListingType $type) => [$type->value => $type->label()]
                                    ))
                                    ->required()
                                    ->native(false)
                                    ->live(),

                                Forms\Components\Select::make('status')
                                    ->options(collect(PropertyStatus::cases())->mapWithKeys(
                                        fn (PropertyStatus $s) => [$s->value => $s->label()]
                                    ))
                                    ->default(PropertyStatus::Draft->value)
                                    ->required()
                                    ->native(false),
                            ])->columns(2),

                        // ── Pricing Tab ────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Pricing')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('₱')
                                    ->minValue(0)
                                    ->step(0.01),

                                Forms\Components\Select::make('price_currency')
                                    ->options([
                                        'PHP' => 'PHP (₱)',
                                        'USD' => 'USD ($)',
                                    ])
                                    ->default('PHP')
                                    ->native(false),

                                Forms\Components\Select::make('price_period')
                                    ->options([
                                        'month' => 'Per Month',
                                        'year' => 'Per Year',
                                        'sqm' => 'Per SQM',
                                    ])
                                    ->visible(fn (Get $get): bool => in_array($get('listing_type'), [
                                        ListingType::ForRent->value,
                                        ListingType::ForLease->value,
                                    ]))
                                    ->native(false),
                            ])->columns(3),

                        // ── Specifications Tab ─────────────────────────
                        Forms\Components\Tabs\Tab::make('Specifications')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Forms\Components\TextInput::make('bedrooms')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn (Get $get): bool => ! in_array($get('property_type'), [
                                        PropertyType::Lot->value,
                                        PropertyType::Warehouse->value,
                                        PropertyType::Farm->value,
                                    ])),

                                Forms\Components\TextInput::make('bathrooms')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn (Get $get): bool => ! in_array($get('property_type'), [
                                        PropertyType::Lot->value,
                                        PropertyType::Farm->value,
                                    ])),

                                Forms\Components\TextInput::make('garage_spaces')
                                    ->label('Garage / Parking Spaces')
                                    ->numeric()
                                    ->minValue(0),

                                Forms\Components\TextInput::make('floor_area')
                                    ->label('Floor Area (sqm)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->visible(fn (Get $get): bool => $get('property_type') !== PropertyType::Lot->value),

                                Forms\Components\TextInput::make('lot_area')
                                    ->label('Lot Area (sqm)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01),

                                Forms\Components\TextInput::make('year_built')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y') + 5)
                                    ->visible(fn (Get $get): bool => ! in_array($get('property_type'), [
                                        PropertyType::Lot->value,
                                        PropertyType::Farm->value,
                                    ])),

                                Forms\Components\TextInput::make('floors')
                                    ->label('Number of Floors')
                                    ->numeric()
                                    ->minValue(1)
                                    ->visible(fn (Get $get): bool => in_array($get('property_type'), [
                                        PropertyType::House->value,
                                        PropertyType::Townhouse->value,
                                        PropertyType::Commercial->value,
                                        PropertyType::Warehouse->value,
                                    ])),
                            ])->columns(3),

                        // ── Location Tab ───────────────────────────────
                        Forms\Components\Tabs\Tab::make('Location')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Forms\Components\TextInput::make('address_line')
                                    ->label('Street Address')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('barangay')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('city')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('province')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('zip_code')
                                    ->maxLength(10),

                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->step(0.000001),

                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->step(0.000001),
                            ])->columns(2),

                        // ── Features Tab ───────────────────────────────
                        Forms\Components\Tabs\Tab::make('Features')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Forms\Components\TagsInput::make('features')
                                    ->placeholder('Add feature...')
                                    ->suggestions([
                                        'Swimming Pool',
                                        'Garden',
                                        'Parking',
                                        'Security',
                                        'Gym',
                                        'Balcony',
                                        'Elevator',
                                        'CCTV',
                                        'Air Conditioning',
                                        'Furnished',
                                        'Pet Friendly',
                                        'Rooftop',
                                        'Storage Room',
                                        'Laundry Area',
                                        'Playground',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ── Media Tab ──────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Repeater::make('images')
                                    ->schema([
                                        Forms\Components\TextInput::make('url')
                                            ->label('Image URL')
                                            ->url()
                                            ->required(),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Alt Text')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->defaultItems(0)
                                    ->addActionLabel('Add Image')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('video_url')
                                    ->label('Video URL')
                                    ->url()
                                    ->maxLength(500),

                                Forms\Components\TextInput::make('virtual_tour_url')
                                    ->label('Virtual Tour URL')
                                    ->url()
                                    ->maxLength(500),
                            ])->columns(2),

                        // ── Publishing Tab ─────────────────────────────
                        Forms\Components\Tabs\Tab::make('Publishing')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Listing')
                                    ->helperText('Featured listings appear prominently on the browse page.'),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->helperText('Leave blank to publish immediately when status is set to Active.'),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(fn (Model $record): string => $record->title),

                Tables\Columns\TextColumn::make('property_type')
                    ->badge()
                    ->formatStateUsing(fn (PropertyType $state): string => $state->label())
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('listing_type')
                    ->badge()
                    ->formatStateUsing(fn (ListingType $state): string => $state->label())
                    ->color(fn (ListingType $state): string => $state->color())
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn (Model $record): string => $record->formattedPrice())
                    ->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (PropertyStatus $state): string => $state->label())
                    ->color(fn (PropertyStatus $state): string => $state->color())
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('inquiries_count')
                    ->counts('inquiries')
                    ->label('Inquiries')
                    ->sortable()
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('property_type')
                    ->options(collect(PropertyType::cases())->mapWithKeys(
                        fn (PropertyType $type) => [$type->value => $type->label()]
                    )),

                Tables\Filters\SelectFilter::make('listing_type')
                    ->options(collect(ListingType::cases())->mapWithKeys(
                        fn (ListingType $type) => [$type->value => $type->label()]
                    )),

                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(PropertyStatus::cases())->mapWithKeys(
                        fn (PropertyStatus $s) => [$s->value => $s->label()]
                    )),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Model $record) => $record->publish())
                    ->visible(fn (Model $record): bool => $record->status === PropertyStatus::Draft),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
