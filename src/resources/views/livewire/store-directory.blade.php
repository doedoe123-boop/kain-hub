<div>
    {{-- Premium Hero Section --}}
    <div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="stores-hero">

        {{-- Decorative Background Gradients --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 hidden dark:block">
            <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[100px] mix-blend-screen opacity-50"></div>
            <div class="absolute bottom-0 left-1/4 w-[600px] h-[600px] bg-sky-500/10 rounded-full blur-[120px] mix-blend-screen opacity-50"></div>
        </div>

        {{-- Background Dot Pattern --}}
        <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.05] bg-[radial-gradient(#000_1px,transparent_1px)] dark:bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="max-w-3xl">
                <nav class="flex items-center gap-2 text-[11px] font-bold tracking-wider text-slate-400 uppercase mb-6">
                    <a href="{{ route('home') }}" class="hover:text-sky-500 dark:hover:text-sky-400 transition-colors">Home</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="text-slate-800 dark:text-slate-200">Stores directory</span>
                </nav>

                <h1 class="text-4xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                    Browse Verified <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-sky-500">Enterprises</span>
                </h1>

                <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl">
                    Discover verified Filipino sellers across every industry. Every store on NegosyoHub undergoes strict KYC and compliance checks for your trust and safety.
                </p>
            </div>

            {{-- Functional Search + Filter bar --}}
            <div class="mt-10 max-w-4xl relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-400 to-sky-400 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500 hidden sm:block"></div>
                <div class="relative flex flex-col sm:flex-row gap-4 p-2 sm:bg-white sm:dark:bg-slate-900 rounded-2xl sm:shadow-xl sm:shadow-slate-200/50 sm:dark:shadow-black/50 border border-transparent sm:border-slate-200 sm:dark:border-slate-700/50">
                    <div class="flex-1 relative flex items-center">
                        <x-heroicon-o-magnifying-glass class="absolute left-4 w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" />
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            id="store-search"
                            placeholder="Search stores by name, product, or location..."
                            class="w-full pl-12 pr-4 py-4 sm:py-3 bg-white dark:bg-slate-900 sm:bg-transparent sm:dark:bg-transparent border border-slate-200 dark:border-slate-700 sm:border-transparent sm:dark:border-transparent rounded-xl text-base text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 sm:focus:ring-0 focus:ring-emerald-500 shadow-sm sm:shadow-none transition-all outline-none"
                        >
                    </div>
                    <div class="w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
                    <div class="relative sm:w-64">
                        <select
                            wire:model.live="sector"
                            id="sector-filter"
                            class="w-full appearance-none pl-4 pr-10 py-4 sm:py-3 bg-white dark:bg-slate-900 sm:bg-transparent sm:dark:bg-transparent border border-slate-200 dark:border-slate-700 sm:border-transparent sm:dark:border-transparent rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 focus:ring-2 sm:focus:ring-0 focus:ring-sky-500 shadow-sm sm:shadow-none transition-all outline-none cursor-pointer"
                        >
                            <option value="">All Sectors</option>
                            @foreach ($sectors as $sectorOption)
                                <option value="{{ $sectorOption->slug }}">{{ $sectorOption->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <x-heroicon-s-chevron-down class="h-4 w-4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60 sticky top-16 z-20 shadow-sm dark:shadow-none">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Showing <span class="font-bold text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">{{ $stores->count() }}</span>
                    @if ($totalCount !== $stores->count())
                        of {{ $totalCount }}
                    @endif
                    verified {{ Str::plural('store', $stores->count()) }}
                    @if ($search)
                        <span class="text-slate-400">for "<span class="text-slate-700 dark:text-slate-200">{{ $search }}</span>"</span>
                    @endif
                </p>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Sort by:</span>
                    <select
                        wire:model.live="sort"
                        class="appearance-none bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold pl-3 pr-8 py-2 rounded-lg focus:ring-2 focus:ring-emerald-400 outline-none shadow-sm cursor-pointer hover:border-slate-300 dark:hover:border-slate-600 transition-colors"
                    >
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Store Grid --}}
    <div class="bg-slate-50/50 dark:bg-[#060A13]">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">

            @if ($stores->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
                    @foreach ($stores as $store)
                        <div class="group bg-white dark:bg-slate-800/50 rounded-2xl border border-slate-200/80 dark:border-slate-700/50 shadow-sm hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-slate-900/50 hover:-translate-y-0.5 transition-all duration-300 overflow-hidden" wire:key="store-{{ $store->id }}">
                            <x-homepage.supplier-card :store="$store" />
                        </div>
                    @endforeach
                </div>

                {{-- Infinite scroll sentinel + loading indicator --}}
                @if ($hasMore)
                    <div
                        wire:key="sentinel-{{ $page }}"
                        x-data="{
                            observer: null,
                            init() {
                                this.observer = new IntersectionObserver((entries) => {
                                    entries.forEach(entry => {
                                        if (entry.isIntersecting) {
                                            $wire.loadMore();
                                        }
                                    });
                                }, { rootMargin: '300px' });
                                this.observer.observe(this.$el);
                            },
                            destroy() {
                                if (this.observer) this.observer.disconnect();
                            }
                        }"
                        class="flex flex-col items-center justify-center py-12 mt-6"
                    >
                        <div wire:loading wire:target="loadMore" class="flex items-center gap-3 px-6 py-3.5 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700">
                            <svg class="animate-spin h-5 w-5 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Loading more stores...</span>
                        </div>
                        <div wire:loading.remove wire:target="loadMore" class="flex items-center gap-2 text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                            <x-heroicon-o-arrow-down class="w-3.5 h-3.5 animate-bounce" />
                            Scroll for more
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center py-10 mt-6">
                        <div class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                            <x-heroicon-o-check-circle class="w-4 h-4 text-emerald-500" />
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">All stores loaded</span>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white dark:bg-slate-800/40 border border-dashed border-slate-200 dark:border-slate-700 rounded-3xl p-16 text-center shadow-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 mb-6 shadow-inner">
                        <x-heroicon-o-magnifying-glass class="h-10 w-10 text-slate-400 dark:text-slate-500" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">No stores found</h3>
                    <p class="text-base text-slate-500 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
                        @if ($search || $sector)
                            Try adjusting your search or filters to find what you're looking for.
                        @else
                            Stores on NegosyoHub undergo comprehensive enterprise verification before listing.
                        @endif
                    </p>
                    @if ($search || $sector)
                        <button wire:click="$set('search', ''); $set('sector', '')" class="inline-flex items-center mt-6 px-5 py-2.5 text-sm font-semibold rounded-xl text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/20 hover:bg-sky-100 dark:hover:bg-sky-900/40 border border-sky-200 dark:border-sky-700 transition-colors">
                            <x-heroicon-o-x-mark class="w-4 h-4 mr-1.5" />
                            Clear Filters
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Premium CTA Banner --}}
    <div class="relative bg-slate-900 dark:bg-slate-800 border-t border-slate-800 dark:border-slate-700 overflow-hidden">
        {{-- Inner glow --}}
        <div class="absolute inset-0 bg-gradient-to-r from-sky-500/20 to-emerald-500/20 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] opacity-[0.05] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-4">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Now Accepting Verified Sellers
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight mb-2">Want to sell on NegosyoHub?</h2>
                <p class="text-base text-slate-400 max-w-lg">Create your store, list products, and reach guaranteed enterprise customers across the Philippines.</p>
            </div>
            <a href="{{ route('register.sector') }}" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 text-sm font-bold rounded-xl text-slate-900 bg-white hover:bg-slate-100 shadow-xl shadow-black/30 hover:shadow-white/20 transition-all duration-300 hover:-translate-y-1 shrink-0 group">
                Register as a Seller
                <x-heroicon-o-arrow-right class="w-4 h-4 group-hover:translate-x-1.5 transition-transform" />
            </a>
        </div>
    </div>
</div>
