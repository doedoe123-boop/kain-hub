{{-- Industry Sectors — Premium Redesign --}}
<div class="relative bg-slate-50 dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="industry-sectors">
    {{-- Decorative Background Gradients --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 hidden dark:block">
        <div class="absolute top-10 right-[10%] w-[400px] h-[400px] bg-sky-500/5 rounded-full blur-[100px] opacity-70"></div>
        <div class="absolute bottom-10 left-[10%] w-[400px] h-[400px] bg-violet-500/5 rounded-full blur-[100px] opacity-70"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-24">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-5 shadow-sm">
                <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.15em]">Ecosystem</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                Built for your industry.
            </h2>
            <p class="mt-5 text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                NegosyoHub isn't a one-size-fits-all directory. We serve highly specialized markets with specific data layers, buyer networks, and compliance standards.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
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
                <a href="{{ route('sector.browse', ['search' => $sector->name]) }}" 
                   class="group relative flex flex-col p-6 rounded-2xl bg-white dark:bg-slate-800/40 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 hover:border-{{ $sector->color }}-300 dark:hover:border-{{ $sector->color }}-500/50 hover:shadow-xl hover:shadow-{{ $sector->color }}-500/5 dark:hover:shadow-2xl dark:hover:shadow-{{ $sector->color }}-500/10 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden h-full">
                    
                    {{-- Ambient background hover glow --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-{{ $sector->color }}-500/0 to-{{ $sector->color }}-500/0 group-hover:from-{{ $sector->color }}-500/5 group-hover:to-transparent dark:group-hover:from-{{ $sector->color }}-500/10 transition-all duration-500 pointer-events-none"></div>

                    {{-- Dynamic glowing accent bar --}}
                    <div class="absolute top-0 inset-x-0 h-[3px] bg-gradient-to-r from-transparent via-{{ $sector->color }}-400 to-transparent scale-x-0 group-hover:scale-x-100 transition-transform duration-500 ease-out origin-left opacity-70"></div>

                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex items-start justify-between mb-4">
                            <div class="h-12 w-12 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 group-hover:bg-{{ $sector->color }}-50 dark:group-hover:bg-{{ $sector->color }}-500/20 group-hover:border-{{ $sector->color }}-200 dark:group-hover:border-{{ $sector->color }}-500/30 flex items-center justify-center transition-all duration-300">
                                <x-dynamic-component :component="$sector->icon" class="w-6 h-6 text-slate-500 dark:text-slate-400 group-hover:text-{{ $sector->color }}-600 dark:group-hover:text-{{ $sector->color }}-400 transition-colors duration-300" />
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-[10px] font-bold text-slate-500 dark:text-slate-400 tracking-wider">
                                {{ $count }} <span class="hidden sm:inline ml-1">STORES</span>
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-{{ $sector->color }}-700 dark:group-hover:text-{{ $sector->color }}-300 transition-colors duration-300">{{ $sector->name }}</h3>
                        </div>
                        
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mt-auto">
                            {{ Str::limit($sector->description, 90) }}
                        </p>
                        
                        <div class="mt-5 flex items-center text-xs font-semibold text-slate-400 dark:text-slate-500 group-hover:text-{{ $sector->color }}-600 dark:group-hover:text-{{ $sector->color }}-400 transition-colors duration-300">
                            Explore sector
                            <x-heroicon-o-arrow-right class="w-3.5 h-3.5 ml-1.5 transform group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-14 text-center">
            <a href="{{ route('sector.browse') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold rounded-lg text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 backdrop-blur-sm border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all duration-300">
                View Enterprise Directory
                <x-heroicon-o-arrow-right class="w-4 h-4" />
            </a>
        </div>
    </div>
</div>
