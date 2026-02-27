{{-- Why Sell Here — Featured hero card + 3 supporting cards --}}
<div class="bg-slate-50/50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800/60" id="why-sell-here">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-12">
            <p class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.2em] mb-3">Why NegosyoHub</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Built for how Filipino businesses actually work</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 max-w-lg mx-auto">Tools, trust, and reach — designed for the Philippine market.</p>
        </div>

        <div class="max-w-5xl mx-auto">
            {{-- Featured Card: Verified Network --}}
            <div class="mb-6 bg-gradient-to-br from-slate-800 to-slate-900 dark:from-slate-800 dark:to-slate-900 border border-slate-700/50 rounded-2xl p-8 relative overflow-hidden group">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 via-sky-500 to-violet-500"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
                    <div class="shrink-0">
                        <div class="h-16 w-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                            <x-heroicon-o-shield-check class="w-8 h-8 text-emerald-400" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Core Promise</span>
                        </div>
                        <h3 class="text-xl font-bold text-white tracking-tight mb-2">Every seller is verified. Every transaction is protected.</h3>
                        <p class="text-sm text-slate-400 leading-relaxed max-w-xl">We don't just list businesses — we verify them. KYC checks, document validation, DTI/SEC compliance, and active moderation keep our marketplace trustworthy.</p>
                    </div>
                    <div class="shrink-0 hidden lg:flex flex-col items-center gap-1.5">
                        <span class="text-3xl font-extrabold text-white">100%</span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">KYC Rate</span>
                    </div>
                </div>
            </div>

            {{-- Supporting Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                {{-- Card: Multi-Industry --}}
                <div class="bg-white dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-sky-500 to-sky-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="text-3xl font-black text-slate-100 dark:text-slate-800 absolute top-4 right-5">01</span>
                    <div class="relative z-10">
                        <div class="h-11 w-11 rounded-xl bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center mb-4">
                            <x-heroicon-o-squares-2x2 class="w-5 h-5 text-sky-600 dark:text-sky-400" />
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-tight mb-2">Multi-Industry Exposure</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Reach buyers across construction, IT, healthcare, real estate, and more — all from one storefront.</p>
                    </div>
                </div>

                {{-- Card: Seller Dashboard --}}
                <div class="bg-white dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-amber-500 to-amber-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="text-3xl font-black text-slate-100 dark:text-slate-800 absolute top-4 right-5">02</span>
                    <div class="relative z-10">
                        <div class="h-11 w-11 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mb-4">
                            <x-heroicon-o-chart-pie class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-tight mb-2">Secure Seller Dashboard</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Full-featured dashboard to manage products, orders, inventory, and analytics — all in one place.</p>
                    </div>
                </div>

                {{-- Card: Flexible Store Types --}}
                <div class="bg-white dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6 transition-all duration-300 hover:shadow-md relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-violet-500 to-violet-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="text-3xl font-black text-slate-100 dark:text-slate-800 absolute top-4 right-5">03</span>
                    <div class="relative z-10">
                        <div class="h-11 w-11 rounded-xl bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center mb-4">
                            <x-heroicon-o-building-storefront class="w-5 h-5 text-violet-600 dark:text-violet-400" />
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-tight mb-2">Flexible Store Types</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Retail, wholesale, services, or real estate listings — your store adapts to your business model.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
