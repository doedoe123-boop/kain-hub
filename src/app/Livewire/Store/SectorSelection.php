<?php

namespace App\Livewire\Store;

use App\Models\Sector;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest-fullwidth')]
class SectorSelection extends Component
{
    /**
     * Navigate to the store owner registration form with the selected sector.
     */
    public function selectSector(string $slug): void
    {
        $sector = Sector::active()->where('slug', $slug)->first();

        if (! $sector) {
            $this->addError('sector', 'Please select a valid industry sector.');

            return;
        }

        $this->redirect(route('register.store-owner', ['sector' => $slug]));
    }

    public function render(): View
    {
        return view('livewire.store.sector-selection', [
            'sectors' => Sector::active()->with('documents')->get(),
        ]);
    }
}
