{{-- Industry Sectors — With counts and descriptions --}}
<div class="bg-slate-50 dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60" id="industry-sectors">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-12">
            <p class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.2em] mb-3">Industry Sectors</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Not just another store platform</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 max-w-lg mx-auto">NegosyoHub serves multiple industries — each with specialized store types, compliance needs, and buyer networks.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 max-w-6xl mx-auto">
            @php
                $sectorCounts = \App\Models\Store::query()
                    ->where('status', \App\StoreStatus::Approved)
                    ->whereNotNull('sector')
                    ->selectRaw('sector, count(*) as total')
                    ->groupBy('sector')
                    ->pluck('total', 'sector');
                    
                $sectors = \App\Models\Sector::active()->get();
            @endphp
            @foreach ($sectors as $sector)
                @php $count = $sectorCounts[$sector->slug] ?? 0; @endphp
                <a href="{{ route('sector.browse', ['search' => $sector->name]) }}" class="w-full sm:w-[calc(50%-12px)] lg:max-w-72 flex-1 group relative flex flex-col gap-3 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/30 hover:shadow-lg hover:border-{{ $sector->color }}-400 dark:hover:border-{{ $sector->color }}-800 transition-all duration-300 overflow-hidden">
                    {{-- Left accent border --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $sector->color }}-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 rounded-xl bg-{{ $sector->color }}-50 dark:bg-{{ $sector->color }}-900/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shrink-0">
                            <x-dynamic-component :component="$sector->icon" class="w-5 h-5 text-{{ $sector->color }}-600 dark:text-{{ $sector->color }}-400" />
                        </div>
                        <div class="min-w-0">
                            <span class="block text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-{{ $sector->color }}-700 dark:group-hover:text-{{ $sector->color }}-400 transition-colors">{{ $sector->name }}</span>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">{{ $count }} sellers</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $sector->description }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('sector.browse') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors">
                View all sectors
                <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>
    </div>
</div>
