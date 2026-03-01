<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Store Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'reviewer_name';

    public static function getNavigationBadge(): ?string
    {
        $store = Auth::user()?->getStoreForPanel();
        if (! $store) {
            return null;
        }

        $count = Review::forStore($store->id)->where('is_published', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    /**
     * Scope all queries to the current user's store.
     */
    public static function getEloquentQuery(): Builder
    {
        $store = Auth::user()?->getStoreForPanel();

        return parent::getEloquentQuery()
            ->where('store_id', $store?->id)
            ->latest();
    }

    public static function form(Form $form): Form
    {
        $store = Auth::user()?->getStoreForPanel();

        return $form
            ->schema([
                Forms\Components\Section::make('Reviewer')
                    ->schema([
                        Forms\Components\TextInput::make('reviewer_name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('reviewer_email')
                            ->email()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('review_type')
                            ->label('Review Type')
                            ->options([
                                'store' => 'Store Review',
                                'product' => 'Product Review',
                            ])
                            ->default('store')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) use ($store): void {
                                if ($state === 'store' && $store) {
                                    $set('reviewable_type', Store::class);
                                    $set('reviewable_id', $store->id);
                                } else {
                                    $set('reviewable_type', \Lunar\Models\Product::class);
                                    $set('reviewable_id', null);
                                }
                            })
                            ->dehydrated(false),

                        Forms\Components\Hidden::make('reviewable_type')
                            ->default(Store::class),

                        Forms\Components\Hidden::make('reviewable_id')
                            ->default(fn () => $store?->id),

                        Forms\Components\Select::make('product_select')
                            ->label('Product')
                            ->options(function () use ($store): array {
                                if (! $store) {
                                    return [];
                                }

                                return \Lunar\Models\Product::query()
                                    ->whereHas('variants', function ($q) {
                                        $q->whereHas('prices');
                                    })
                                    ->get()
                                    ->filter(function ($product) use ($store) {
                                        $storeId = $product->attribute_data?->get('store_id');

                                        return $storeId && (string) $storeId->getValue() === (string) $store->id;
                                    })
                                    ->mapWithKeys(function ($product) {
                                        $name = $product->translateAttribute('name') ?? 'Product #'.$product->id;

                                        return [$product->id => $name];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->visible(fn (Forms\Get $get): bool => $get('review_type') === 'product' || $get('reviewable_type') === \Lunar\Models\Product::class)
                            ->afterStateUpdated(function (Forms\Set $set, $state): void {
                                if ($state) {
                                    $set('reviewable_type', \Lunar\Models\Product::class);
                                    $set('reviewable_id', $state);
                                }
                            })
                            ->live()
                            ->dehydrated(false),

                        Forms\Components\Select::make('rating')
                            ->options([
                                5 => '★★★★★ (5)',
                                4 => '★★★★☆ (4)',
                                3 => '★★★☆☆ (3)',
                                2 => '★★☆☆☆ (2)',
                                1 => '★☆☆☆☆ (1)',
                            ])
                            ->required()
                            ->default(5)
                            ->native(false),

                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->placeholder('Brief summary of the review'),

                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->maxLength(2000)
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_verified_purchase')
                            ->label('Verified Purchase'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Review'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(false),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date'),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reviewer_name')
                    ->label('Reviewer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->sortable()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->placeholder('—')
                    ->searchable(),

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

                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_verified_purchase')
                    ->boolean()
                    ->label('Verified')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Star',
                    ]),

                Tables\Filters\SelectFilter::make('review_type')
                    ->label('Type')
                    ->options([
                        Store::class => 'Store Reviews',
                        \Lunar\Models\Product::class => 'Product Reviews',
                    ])
                    ->attribute('reviewable_type'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),

                Tables\Filters\TernaryFilter::make('is_verified_purchase')
                    ->label('Verified Purchase'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-globe-alt')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Model $record): bool => ! $record->is_published)
                    ->action(fn (Model $record) => $record->publish()),
                Tables\Actions\Action::make('unpublish')
                    ->icon('heroicon-o-eye-slash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Model $record): bool => $record->is_published)
                    ->action(fn (Model $record) => $record->unpublish()),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
