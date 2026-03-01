<?php

namespace App\Filament\Realty\Resources\PropertyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TestimonialsRelationManager extends RelationManager
{
    protected static string $relationship = 'testimonials';

    protected static ?string $title = 'Reviews';

    protected static ?string $icon = 'heroicon-o-star';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Client Information')
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('client_email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('client_photo')
                            ->label('Photo URL')
                            ->url()
                            ->maxLength(500),
                    ])->columns(3),

                Forms\Components\Section::make('Review')
                    ->schema([
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

                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->maxLength(2000)
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(false),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date'),
                    ])->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('client_name')
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('content')
                    ->limit(60)
                    ->tooltip(fn (Model $record): string => $record->content)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $store = auth()->user()?->getStoreForPanel();
                        $data['store_id'] = $store?->id;

                        return $data;
                    }),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
