<?php

namespace App\Livewire\Store;

use App\IndustrySector;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest-fullwidth')]
class SectorSelection extends Component
{
    /**
     * Navigate to the store owner registration form with the selected sector.
     */
    public function selectSector(string $sector): void
    {
        $industrySector = IndustrySector::tryFrom($sector);

        if (! $industrySector) {
            $this->addError('sector', 'Please select a valid industry sector.');

            return;
        }

        $this->redirect(route('register.store-owner', ['sector' => $sector]));
    }

    public function render(): View
    {
        return view('livewire.store.sector-selection', [
            'sectors' => IndustrySector::cases(),
        ]);
    }
}
