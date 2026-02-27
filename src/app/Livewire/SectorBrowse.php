<?php

namespace App\Livewire;

use App\IndustrySector;
use App\Models\Store;
use App\StoreStatus;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class SectorBrowse extends Component
{
    /**
     * Search query for filtering sectors.
     */
    public string $search = '';

    /**
     * Get sector data with supplier counts.
     *
     * @return array<int, array{sector: IndustrySector, count: int, requiredDocs: int, optionalDocs: int}>
     */
    private function getSectorData(): array
    {
        $counts = Store::query()
            ->where('status', StoreStatus::Approved)
            ->whereNotNull('sector')
            ->selectRaw('sector, count(*) as total')
            ->groupBy('sector')
            ->pluck('total', 'sector')
            ->toArray();

        $sectors = [];
        foreach (IndustrySector::cases() as $sector) {
            if ($this->search && ! str_contains(
                strtolower($sector->label().' '.$sector->description()),
                strtolower($this->search)
            )) {
                continue;
            }

            $docs = $sector->requiredDocuments();
            $sectors[] = [
                'sector' => $sector,
                'count' => $counts[$sector->value] ?? 0,
                'requiredDocs' => count(array_filter($docs, fn (array $d) => $d['required'])),
                'optionalDocs' => count(array_filter($docs, fn (array $d) => ! $d['required'])),
            ];
        }

        return $sectors;
    }

    public function render(): View
    {
        return view('livewire.sector-browse', [
            'sectors' => $this->getSectorData(),
            'totalSuppliers' => Store::query()->where('status', StoreStatus::Approved)->count(),
        ])->title('Industries — NegosyoHub');
    }
}
