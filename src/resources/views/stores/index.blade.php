<x-layouts.app :title="'Browse Stores — NegosyoHub Marketplace'">

    {{-- Page Header --}}
    <div class="hero-mesh" id="stores-hero">
        <div class="hero-pattern"></div>
        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="max-w-2xl">
                <nav class="text-xs text-slate-400 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span class="mx-1.5">/</span>
                    <span class="text-slate-300">Stores</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Browse Verified Stores
                </h1>
                <p class="mt-3 text-base text-slate-400 leading-relaxed max-w-lg">
                    Discover verified Filipino sellers across every industry. Every store on NegosyoHub is identity-verified for your trust and safety.
                </p>
            </div>

            {{-- Search + Filter bar --}}
            <div class="mt-8 max-w-3xl">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input type="text" id="store-search" placeholder="Search stores by name, product, or location..." class="block w-full rounded-xl border-0 bg-white/10 py-3.5 pl-12 pr-4 text-sm text-white placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 focus:outline-none backdrop-blur-sm">
                    </div>
                    <select id="region-filter" class="rounded-xl border-0 bg-white/10 text-sm text-slate-300 py-3.5 pl-4 pr-10 focus:ring-2 focus:ring-sky-500 focus:outline-none backdrop-blur-sm">
                        <option>All Regions</option>
                        <option>NCR — Metro Manila</option>
                        <option>Region III — Central Luzon</option>
                        <option>Region IV-A — CALABARZON</option>
                        <option>Region VII — Central Visayas</option>
                        <option>Region XI — Davao</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Showing <span class="font-bold text-slate-800 dark:text-slate-200">{{ \App\Models\Store::where('status', 'approved')->count() }}</span> verified stores
                </p>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400 dark:text-slate-500">Sort by:</span>
                    <select class="border border-slate-200 dark:border-slate-700 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-semibold px-3 py-2 rounded-lg focus:ring-1 focus:ring-sky-400 bg-white">
                        <option>Newest First</option>
                        <option>Most Popular</option>
                        <option>Name (A-Z)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Store Grid --}}
    <div class="bg-slate-50/50 dark:bg-slate-950">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse (\App\Models\Store::where('status', 'approved')->latest()->get() as $store)
                    <x-homepage.supplier-card :store="$store" />
                @empty
                    <div class="md:col-span-2 bg-white dark:bg-slate-800/60 border border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-16 text-center">
                        <div class="inline-flex items-center justify-center h-20 w-20 rounded-3xl bg-slate-100 dark:bg-slate-800 mb-5">
                            <svg class="h-10 w-10 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200 tracking-tight">No stores listed yet</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">Stores on NegosyoHub are verified before listing. Be the first to open your store and start selling to customers nationwide.</p>
                        @guest
                            <a href="{{ route('register.sector') }}" class="inline-flex items-center mt-6 px-8 py-3.5 text-sm font-bold rounded-xl text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 shadow-lg shadow-sky-500/20 transition-all duration-300">
                                Sell on NegosyoHub
                            </a>
                        @endguest
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- CTA Banner --}}
    <div class="bg-gradient-to-r from-sky-600 to-sky-700 dark:from-sky-700 dark:to-sky-800">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-extrabold text-white tracking-tight">Want to sell on NegosyoHub?</h2>
                <p class="mt-1 text-sm text-sky-100/80">Create your store, list products, and reach customers across the Philippines. Free to start.</p>
            </div>
            <a href="{{ route('register.sector') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 text-sm font-extrabold rounded-xl text-sky-700 bg-white hover:bg-sky-50 shadow-lg transition-all duration-300 hover:-translate-y-0.5 shrink-0 group">
                Sell on NegosyoHub
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>

</x-layouts.app>
