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
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
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
                        <svg class="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                        </svg>
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
