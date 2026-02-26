{{-- ============================================================
     HERO: Marketplace Hub
     Deep navy with subtle mesh gradient + geometric pattern
     ============================================================ --}}
<div class="hero-mesh" id="hero-section">
    <div class="hero-pattern"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
            {{-- Eyebrow --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.06] border border-white/[0.08] mb-6">
                <svg class="w-3.5 h-3.5 text-emerald-400 live-pulse" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                <span class="text-xs font-semibold text-slate-300 tracking-wide">The Philippines' trusted multi-vendor marketplace</span>
            </div>

            {{-- Headline --}}
            <h1 class="text-3xl sm:text-4xl lg:text-[3.5rem] font-extrabold text-white leading-[1.1] tracking-tight">
                Your one-stop marketplace
                <br>
                <span class="gradient-text">for Filipino businesses</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-slate-400 max-w-xl mx-auto leading-relaxed">
                From retail stores to real estate — discover verified sellers, explore quality products, and transact with confidence across the Philippines.
            </p>

            {{-- Massive Search Bar --}}
            <div class="mt-8 max-w-2xl mx-auto animate-fade-in-up-delay-1">
                <div class="search-bar-hero rounded-2xl overflow-hidden bg-white/[0.07] border border-white/[0.1] p-1.5">
                    <div class="flex rounded-xl overflow-hidden bg-white dark:bg-slate-800">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" id="hero-search-input"
                                placeholder="Search stores, products, or services..."
                                class="block w-full border-0 bg-transparent py-4 sm:py-5 pl-14 pr-4 text-sm sm:text-base text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-0 focus:outline-none">
                        </div>
                        <button class="bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 px-6 sm:px-8 text-sm font-bold text-white transition-all duration-300 shrink-0" id="hero-search-btn">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            {{-- Quick filter chips --}}
            <div class="mt-5 flex flex-wrap justify-center gap-2 animate-fade-in-up-delay-2">
                <button class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold bg-emerald-500/15 text-emerald-400 border border-emerald-500/25 rounded-full hover:bg-emerald-500/25 transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    Verified Only
                </button>
                <button class="px-4 py-2 text-xs font-semibold text-slate-400 border border-white/10 rounded-full hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200">Retail Stores</button>
                <button class="px-4 py-2 text-xs font-semibold text-slate-400 border border-white/10 rounded-full hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200">Real Estate</button>
                <button class="px-4 py-2 text-xs font-semibold text-slate-400 border border-white/10 rounded-full hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200">Best Deals</button>
                <button class="px-4 py-2 text-xs font-semibold text-slate-400 border border-white/10 rounded-full hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-200">Metro Manila</button>
            </div>

            {{-- Trust badges --}}
            <div class="mt-8 flex flex-wrap justify-center gap-3 animate-fade-in-up-delay-3">
                @php
                    $trustBadges = [
                        ['label' => 'Verified Sellers', 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'color' => 'text-emerald-400'],
                        ['label' => 'Secure Payments', 'icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z', 'color' => 'text-sky-400'],
                        ['label' => 'Buyer Protection', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-amber-400'],
                        ['label' => 'Nationwide Reach', 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'text-violet-400'],
                    ];
                @endphp
                @foreach ($trustBadges as $badge)
                    <div class="trust-badge inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/[0.04] border border-white/[0.06]">
                        <svg class="w-4 h-4 {{ $badge['color'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $badge['icon'] }}" /></svg>
                        <span class="text-xs font-semibold text-slate-300">{{ $badge['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Platform Stats Strip --}}
        <div class="mt-14 max-w-4xl mx-auto animate-fade-in-up-delay-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-px rounded-2xl overflow-hidden bg-white/[0.06]">
                @php
                    $stats = [
                        ['label' => 'Active Stores', 'value' => number_format(\App\Models\Store::where('status', 'approved')->count()) ?: '0', 'icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64'],
                        ['label' => 'Registered Users', 'value' => number_format(\App\Models\User::count()) ?: '0', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                        ['label' => 'Satisfaction Rate', 'value' => '98%', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Coverage', 'value' => 'Nationwide', 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="bg-white/[0.02] px-6 py-5 text-center hover:bg-white/[0.04] transition-colors duration-300">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-1">{{ $stat['label'] }}</p>
                        <p class="text-xl font-extrabold text-white tabular-nums tracking-tight">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
