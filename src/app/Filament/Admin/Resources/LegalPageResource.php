<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LegalPageResource\Pages;
use App\Models\LegalPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationGroup = 'Legal';

    protected static ?string $navigationLabel = 'Legal Pages';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly identifier. Auto-generated from title.'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'terms' => 'Terms of Service',
                                'privacy' => 'Privacy Policy',
                                'store_agreement' => 'Store Owner Agreement',
                                'refund' => 'Refund & Return Policy',
                                'data_privacy' => 'Data Privacy Notice (DPA)',
                                'acceptable_use' => 'Acceptable Use Policy',
                            ])
                            ->required()
                            ->helperText('Categorizes this legal document.'),
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'redo',
                                'undo',
                            ]),
                    ])->columns(2),
                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Only published pages are visible to users.'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date'),
                        Forms\Components\DateTimePicker::make('last_reviewed_at')
                            ->label('Last Reviewed')
                            ->helperText('Track when this document was last reviewed for accuracy.'),
                        Forms\Components\Hidden::make('updated_by')
                            ->default(fn () => Auth::id()),
                    ])->columns(3),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Page Content')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('URL Slug')
                            ->icon('heroicon-o-link')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('type')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'terms' => 'Terms of Service',
                                'privacy' => 'Privacy Policy',
                                'store_agreement' => 'Store Owner Agreement',
                                'refund' => 'Refund & Return Policy',
                                'data_privacy' => 'Data Privacy Notice',
                                'acceptable_use' => 'Acceptable Use Policy',
                                default => ucfirst($state),
                            })
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('content')
                            ->html()
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'legal-content-admin']),
                    ])->columns(2),
                Infolists\Components\Section::make('Publishing Details')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_published')
                            ->label('Published')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('published_at')
                            ->dateTime()
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('last_reviewed_at')
                            ->label('Last Reviewed')
                            ->dateTime()
                            ->placeholder('Never'),
                        Infolists\Components\TextEntry::make('editor.name')
                            ->label('Last Edited By')
                            ->placeholder('—'),
                    ])->columns(4),
                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->dateTime(),
                    ])->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'terms' => 'Terms of Service',
                        'privacy' => 'Privacy Policy',
                        'store_agreement' => 'Store Owner Agreement',
                        'refund' => 'Refund & Return Policy',
                        'data_privacy' => 'Data Privacy Notice',
                        'acceptable_use' => 'Acceptable Use Policy',
                        default => ucfirst($state),
                    })
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_reviewed_at')
                    ->label('Last Reviewed')
                    ->dateTime()
                    ->placeholder('Never')
                    ->sortable(),
                Tables\Columns\TextColumn::make('editor.name')
                    ->label('Edited By')
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'terms' => 'Terms of Service',
                        'privacy' => 'Privacy Policy',
                        'store_agreement' => 'Store Owner Agreement',
                        'refund' => 'Refund & Return Policy',
                        'data_privacy' => 'Data Privacy Notice',
                        'acceptable_use' => 'Acceptable Use Policy',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_publish')
                    ->label(fn (LegalPage $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                    ->icon(fn (LegalPage $record): string => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (LegalPage $record): string => $record->is_published ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->action(function (LegalPage $record): void {
                        $record->update([
                            'is_published' => ! $record->is_published,
                            'published_at' => ! $record->is_published ? now() : $record->published_at,
                        ]);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegalPages::route('/'),
            'create' => Pages\CreateLegalPage::route('/create'),
            'view' => Pages\ViewLegalPage::route('/{record}'),
            'edit' => Pages\EditLegalPage::route('/{record}/edit'),
        ];
    }
}
