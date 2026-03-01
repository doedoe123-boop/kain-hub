<?php

namespace App\Livewire;

use App\Models\Store;
use App\StoreStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Browse Stores — NegosyoHub Marketplace'])]
class StoreDirectory extends Component
{
    private const PER_PAGE = 9;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $sector = '';

    #[Url]
    public string $sort = 'newest';

    /** @var Collection<int, Store> */
    public Collection $stores;

    public bool $hasMore = true;

    public bool $loading = false;

    public int $page = 1;

    public function mount(): void
    {
        $this->stores = collect();
        $this->loadStores();
    }

    /**
     * Reset and reload when search/filter/sort changes.
     */
    public function updatedSearch(): void
    {
        $this->resetStores();
    }

    public function updatedSector(): void
    {
        $this->resetStores();
    }

    public function updatedSort(): void
    {
        $this->resetStores();
    }

    /**
     * Load the next batch of stores (called by IntersectionObserver).
     */
    public function loadMore(): void
    {
        if (! $this->hasMore) {
            return;
        }

        // Brief pause so the loading spinner is visible for a smoother UX
        usleep(400_000);

        $this->page++;
        $this->loadStores();
    }

    public function render(): View
    {
        $totalCount = Store::where('status', StoreStatus::Approved)->count();

        /** @var Collection<int, \App\Models\Sector> $sectors */
        $sectors = \App\Models\Sector::active()->orderBy('name')->get();

        return view('livewire.store-directory', [
            'totalCount' => $totalCount,
            'sectors' => $sectors,
        ]);
    }

    private function resetStores(): void
    {
        $this->stores = collect();
        $this->page = 1;
        $this->hasMore = true;
        $this->loadStores();
    }

    private function loadStores(): void
    {
        $query = Store::query()
            ->where('status', StoreStatus::Approved);

        if ($this->search !== '') {
            $term = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'ilike', $term)
                    ->orWhere('description', 'ilike', $term)
                    ->orWhereRaw("address->>'city' ilike ?", [$term])
                    ->orWhereRaw("address->>'province' ilike ?", [$term]);
            });
        }

        if ($this->sector !== '') {
            $query->where('sector', $this->sector);
        }

        $query = match ($this->sort) {
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $newStores = $query
            ->skip(($this->page - 1) * self::PER_PAGE)
            ->take(self::PER_PAGE)
            ->get();

        $this->stores = $this->stores->concat($newStores);
        $this->hasMore = $newStores->count() === self::PER_PAGE;
    }
}
