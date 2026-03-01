<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class StoreProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Store Profile';

    protected static string $view = 'filament.pages.store-profile';

    /** @var array<string, mixed> */
    public ?array $data = [];

    public function mount(): void
    {
        $store = auth()->user()->getStoreForPanel();

        if (! $store) {
            abort(403);
        }

        $this->form->fill([
            'name' => $store->name,
            'description' => $store->description,
            'logo' => $store->logo,
            'address' => $store->address ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Store Information')
                    ->description('Your public-facing store details.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(1000)
                            ->rows(4)
                            ->placeholder('Describe your store to customers...')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('logo')
                            ->label('Logo URL')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://...'),
                    ])->columns(2),

                Forms\Components\Section::make('Address')
                    ->schema([
                        Forms\Components\TextInput::make('address.line_one')
                            ->label('Street Address')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address.city')
                            ->label('City')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address.province')
                            ->label('Province')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address.postcode')
                            ->label('Zip Code')
                            ->maxLength(10),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $store = auth()->user()->getStoreForPanel();

        $store->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'logo' => $data['logo'],
            'address' => $data['address'],
        ]);

        Notification::make()
            ->title('Store profile updated')
            ->success()
            ->send();
    }
}
