{{-- Featured Stores — limited to 6, clean grid --}}
<div class="bg-slate-50/50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800/60" id="featured-stores">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-16">
        {{-- Section header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.2em] mb-2">Featured Stores</p>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Discover verified sellers</h2>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                    <span class="font-bold text-slate-700 dark:text-slate-200">{{ \App\Models\Store::where('status', 'approved')->count() }}</span> stores are live on the marketplace
                </p>
            </div>
            <div class="flex items-center gap-3">
                <select class="border border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 text-slate-600 text-xs font-semibold px-3 py-2.5 rounded-xl focus:border-sky-400 focus:ring-sky-400 focus:ring-1 bg-white transition-colors" id="region-filter">
                    <option>All Regions</option>
                    <option>NCR — Metro Manila</option>
                    <option>Region III — Central Luzon</option>
                    <option>Region IV-A — CALABARZON</option>
                    <option>Region VII — Central Visayas</option>
                    <option>Region XI — Davao</option>
                </select>
                <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors duration-200">
                    View all
                    <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>
        </div>

        {{-- Store Grid — max 6 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(6)->get() as $store)
                <x-homepage.supplier-card :store="$store" />
            @empty
                <div class="md:col-span-2 bg-white dark:bg-slate-800/60 border border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-16 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-slate-100 dark:bg-slate-800 mb-4">
                        <x-heroicon-o-building-storefront class="h-8 w-8 text-slate-300 dark:text-slate-600" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 tracking-tight">No stores listed yet</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Be the first to open your store on the platform and start selling to customers nationwide.</p>
                    @guest
                        <a href="{{ route('register.sector') }}" class="inline-flex items-center mt-5 px-6 py-3 text-sm font-bold rounded-xl text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 shadow-lg shadow-sky-500/20 transition-all duration-300">
                            Sell on NegosyoHub
                        </a>
                    @endguest
                </div>
            @endforelse
        </div>
    </div>
</div>
