<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SectorResource\Pages;
use App\Models\Sector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Platform';

    protected static ?string $navigationLabel = 'Industry Sectors';

    protected static ?int $navigationSort = 1;

    // ── Form ──────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Sector Details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(120)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(120)
                        ->unique(ignoreRecord: true)
                        ->helperText('URL identifier — auto-generated from name. Must match the value stored in stores.sector.'),

                    Forms\Components\Textarea::make('description')
                        ->maxLength(500)
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('registration_button_text')
                        ->maxLength(120)
                        ->placeholder('Register as Supplier')
                        ->helperText('Custom text for the action button natively (e.g. "Join as Real Estate Agent").')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('icon')
                        ->placeholder('heroicon-o-building-storefront')
                        ->helperText('Heroicon component name, e.g. heroicon-o-cake')
                        ->maxLength(80),

                    Forms\Components\Select::make('color')
                        ->options([
                            'slate' => 'Slate',
                            'gray' => 'Gray',
                            'red' => 'Red',
                            'orange' => 'Orange',
                            'amber' => 'Amber',
                            'yellow' => 'Yellow',
                            'lime' => 'Lime',
                            'green' => 'Green',
                            'emerald' => 'Emerald',
                            'teal' => 'Teal',
                            'cyan' => 'Cyan',
                            'sky' => 'Sky',
                            'blue' => 'Blue',
                            'indigo' => 'Indigo',
                            'violet' => 'Violet',
                            'purple' => 'Purple',
                            'pink' => 'Pink',
                        ])
                        ->default('indigo'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->helperText('Inactive sectors are hidden from registration.'),
                ])->columns(2),

            Forms\Components\Section::make('Required Compliance Documents')
                ->description('Define the documents suppliers in this sector must upload during registration.')
                ->schema([
                    Forms\Components\Repeater::make('documents')
                        ->relationship('documents')
                        ->schema([
                            Forms\Components\TextInput::make('key')
                                ->required()
                                ->maxLength(80)
                                ->helperText('Unique identifier used as the file upload key, e.g. dti_sec_registration')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('key', Str::snake($state ?? ''))),

                            Forms\Components\TextInput::make('label')
                                ->required()
                                ->maxLength(200),

                            Forms\Components\Textarea::make('description')
                                ->maxLength(500)
                                ->rows(2)
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('mimes')
                                ->default('pdf,jpg,jpeg,png')
                                ->required()
                                ->helperText('Comma-separated extensions, e.g. pdf,jpg,jpeg,png'),

                            Forms\Components\Toggle::make('is_required')
                                ->label('Required')
                                ->default(true),

                            Forms\Components\TextInput::make('sort_order')
                                ->numeric()
                                ->default(0),
                        ])
                        ->columns(2)
                        ->itemLabel(fn (array $state): string => $state['label'] ?? 'New Document')
                        ->addActionLabel('Add Document')
                        ->reorderable('sort_order')
                        ->collapsible()
                        ->collapseAllAction(fn (Forms\Components\Actions\Action $action) => $action->label('Collapse all'))
                        ->columnSpanFull(),
                ]),
        ]);
    }

    // ── Table ─────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('documents_count')
                    ->counts('documents')
                    ->label('Documents')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn (Sector $record): string => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn (Sector $record): string => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (Sector $record): string => $record->is_active ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->action(fn (Sector $record) => $record->update(['is_active' => ! $record->is_active])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    // ── Pages ─────────────────────────────────────────────────────────

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSector::route('/create'),
            'edit' => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
