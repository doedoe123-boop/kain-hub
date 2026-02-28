<?php

namespace App\Livewire;

use App\Models\Sector;
use App\Models\Store;
use App\StoreStatus;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class SectorBrowse extends Component
{
    public string $search = '';

    /**
     * Get active sector data with supplier counts.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Sector>
     */
    private function getSectors(): mixed
    {
        $counts = Store::query()
            ->where('status', StoreStatus::Approved)
            ->whereNotNull('sector')
            ->selectRaw('sector, count(*) as total')
            ->groupBy('sector')
            ->pluck('total', 'sector')
            ->toArray();

        return Sector::active()
            ->with('documents')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $op = \Illuminate\Support\Facades\DB::connection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
                $q->where('name', $op, "%{$this->search}%")
                    ->orWhere('description', $op, "%{$this->search}%");
            }))
            ->get()
            ->map(function (Sector $sector) use ($counts): Sector {
                $sector->supplier_count = $counts[$sector->slug] ?? 0;
                $sector->required_docs = $sector->documents->where('is_required', true)->count();
                $sector->optional_docs = $sector->documents->where('is_required', false)->count();

                return $sector;
            });
    }

    public function render(): View
    {
        return view('livewire.sector-browse', [
            'sectors' => $this->getSectors(),
            'totalSuppliers' => Store::query()->where('status', StoreStatus::Approved)->count(),
        ])->title('Industries — NegosyoHub');
    }
}
