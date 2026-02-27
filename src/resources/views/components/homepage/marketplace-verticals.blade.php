{{-- Marketplace Verticals — Multi-category marketplace showcase --}}
<div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60" id="marketplace-verticals">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-12">
            <p class="text-[10px] font-bold text-violet-600 dark:text-violet-400 uppercase tracking-[0.2em] mb-3">Marketplace Verticals</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">More than just a store — it's a platform</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 max-w-lg mx-auto">NegosyoHub is expanding to support multiple business verticals. Start with retail and get ready for what's next.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Retail Stores (Live) --}}
            <div class="group relative rounded-2xl bg-gradient-to-br from-sky-600 to-sky-800 dark:from-sky-700 dark:to-sky-900 p-8 lg:p-10 overflow-hidden shadow-xl shadow-sky-600/10 transition-all duration-500 hover:shadow-2xl hover:shadow-sky-600/20 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-300 text-[10px] font-extrabold uppercase tracking-widest">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-400"></span>
                            </span>
                            Live Now
                        </span>
                    </div>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-14 w-14 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center">
                            <x-heroicon-o-building-storefront class="w-7 h-7 text-white" />
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-white tracking-tight">Retail & General Merchandise</h3>
                            <p class="text-sm text-sky-200/80 mt-0.5">Products, wholesale, F&B, services & more</p>
                        </div>
                    </div>
                    <p class="text-sm text-sky-100/70 leading-relaxed mb-6">Open your retail store and sell anything — from electronics and clothing to food & beverages, office supplies, construction materials, and professional services. Full e-commerce toolkit included.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach (['Electronics', 'Food & Bev', 'Fashion', 'Office', 'Construction', 'Services'] as $cat)
                            <span class="px-3 py-1.5 rounded-lg bg-white/10 text-xs font-semibold text-sky-100/90 border border-white/5">{{ $cat }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('register.sector') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-sky-700 bg-white hover:bg-sky-50 rounded-xl shadow-lg transition-all duration-200 hover:-translate-y-0.5 group">
                        Sell on NegosyoHub
                        <x-heroicon-o-arrow-right class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>

            {{-- Real Estate (Coming Soon) --}}
            <div class="group relative rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 dark:from-slate-800 dark:to-slate-900 p-8 lg:p-10 overflow-hidden border border-slate-700/50 transition-all duration-500 hover:border-violet-700/40 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-64 h-64 bg-violet-500/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-violet-500/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-violet-500/15 text-violet-400 text-[10px] font-extrabold uppercase tracking-widest border border-violet-500/20">
                            <x-heroicon-o-clock class="w-3 h-3" />
                            Coming Soon
                        </span>
                    </div>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-14 w-14 rounded-2xl bg-violet-500/10 border border-violet-500/15 flex items-center justify-center">
                            <x-heroicon-o-building-office-2 class="w-7 h-7 text-violet-400" />
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-white tracking-tight">Real Estate</h3>
                            <p class="text-sm text-slate-400 mt-0.5">Properties, rentals & agent listings</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6">List residential and commercial properties for sale or rent. Real estate agents and property owners will be able to create listings, manage inquiries, and connect with qualified buyers and tenants.</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach (['Houses', 'Condos', 'Lots', 'Commercial', 'Rentals', 'Agents'] as $cat)
                            <span class="px-3 py-1.5 rounded-lg bg-slate-700/60 text-xs font-semibold text-slate-400 border border-slate-600/30">{{ $cat }}</span>
                        @endforeach
                    </div>
                    <button class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-violet-300 bg-violet-500/10 hover:bg-violet-500/20 border border-violet-500/20 rounded-xl transition-all duration-200 cursor-default">
                        <x-heroicon-o-bell-alert class="w-4 h-4" />
                        Notify Me
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
