{{-- Why Sell Here — Premium Edition --}}
<div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden z-10" id="why-sell-here">
    
    {{-- Dot Pattern Background --}}
    <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.05] bg-[radial-gradient(#000_1px,transparent_1px)] dark:bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-5 shadow-sm">
                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.15em]">Why NegosyoHub</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                Built for Filipino enterprise.
            </h2>
            <p class="mt-5 text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Tools, trust, and targeted reach — designed to accelerate your growth securely.
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            {{-- Featured Card: Verified Network --}}
            <div class="mb-8 relative rounded-[2rem] p-[1px] bg-gradient-to-b from-slate-200 to-slate-100 dark:from-slate-700 dark:to-slate-800/50 overflow-hidden group shadow-2xl shadow-slate-200/50 dark:shadow-none hover:shadow-emerald-500/10 transition-shadow duration-500">
                
                {{-- Animated subtle border glow (Dark Mode) --}}
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 via-sky-500 to-violet-500 opacity-0 dark:opacity-20 group-hover:opacity-100 dark:group-hover:opacity-50 transition-opacity duration-700 blur-xl"></div>
                
                <div class="relative bg-white dark:bg-slate-900/90 backdrop-blur-xl rounded-[calc(2rem-1px)] p-8 sm:p-10 z-10 overflow-hidden">
                    
                    {{-- Inner ambient glow --}}
                    <div class="absolute -top-32 -right-32 w-64 h-64 bg-emerald-500/20 dark:bg-emerald-500/10 rounded-full blur-[80px] group-hover:bg-emerald-500/30 transition-colors duration-700"></div>

                    <div class="relative flex flex-col lg:flex-row lg:items-center gap-8 lg:gap-12">
                        <div class="shrink-0">
                            <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center transform group-hover:scale-105 transition-transform duration-500">
                                <x-heroicon-s-shield-check class="w-10 h-10 text-white" />
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-500/30 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">
                                    Trust & Security
                                </span>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4 leading-tight">
                                Every seller verified.<br class="hidden sm:block"> Every transaction protected.
                            </h3>
                            <p class="text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl">
                                We don't just list businesses — we verify them. Mandatory KYC checks, document tier validation (DTI/SEC/PhilGEPS), and active behavioral moderation keep our entire ecosystem trustworthy and secure for enterprise buyers.
                            </p>
                        </div>
                        <div class="shrink-0 hidden lg:flex flex-col items-end gap-1.5 border-l border-slate-200 dark:border-slate-800 pl-12 py-4">
                            <span class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-emerald-600 to-emerald-400">100%</span>
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">KYC Success Rate</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Supporting Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card: Multi-Industry --}}
                <div class="group relative bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 backdrop-blur-md rounded-3xl p-8 hover:shadow-xl hover:shadow-sky-500/5 transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-sky-400 to-sky-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    <span class="text-4xl font-black text-slate-200/50 dark:text-slate-800 absolute top-6 right-6 transition-colors duration-300 group-hover:text-slate-200 dark:group-hover:text-slate-700">01</span>
                    
                    <div class="mt-4">
                        <div class="h-14 w-14 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-sky-300 dark:group-hover:border-sky-700 transition-all duration-300">
                            <x-heroicon-o-squares-2x2 class="w-6 h-6 text-sky-600 dark:text-sky-400" />
                        </div>
                        @php
                            $activeSectors = \App\Models\Sector::active()->pluck('name')->map(fn($n) => strtolower($n))->toArray();
                            $sectorsList = count($activeSectors) > 0 
                                ? implode(', ', array_slice($activeSectors, 0, 3)) . (count($activeSectors) > 3 ? ', and more' : '') 
                                : 'multiple industries';
                        @endphp
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight mb-3">Targeted Exposure</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Reach targeted B2B buyers across {{ $sectorsList }}. One unified storefront adapts seamlessly to different market segments.
                        </p>
                    </div>
                </div>

                {{-- Card: Seller Dashboard --}}
                <div class="group relative bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 backdrop-blur-md rounded-3xl p-8 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-amber-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    <span class="text-4xl font-black text-slate-200/50 dark:text-slate-800 absolute top-6 right-6 transition-colors duration-300 group-hover:text-slate-200 dark:group-hover:text-slate-700">02</span>
                    
                    <div class="mt-4">
                        <div class="h-14 w-14 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-amber-300 dark:group-hover:border-amber-700 transition-all duration-300">
                            <x-heroicon-o-chart-pie class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight mb-3">Enterprise Dashboard</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            A highly capable operating system for your storefront. Track RFQs, fulfill orders, monitor inventory, and assess real-time analytics.
                        </p>
                    </div>
                </div>

                {{-- Card: Flexible Store Types --}}
                <div class="group relative bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 backdrop-blur-md rounded-3xl p-8 hover:shadow-xl hover:shadow-violet-500/5 transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-violet-400 to-violet-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    <span class="text-4xl font-black text-slate-200/50 dark:text-slate-800 absolute top-6 right-6 transition-colors duration-300 group-hover:text-slate-200 dark:group-hover:text-slate-700">03</span>
                    
                    <div class="mt-4">
                        <div class="h-14 w-14 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 group-hover:border-violet-300 dark:group-hover:border-violet-700 transition-all duration-300">
                            <x-heroicon-o-building-storefront class="w-6 h-6 text-violet-600 dark:text-violet-400" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight mb-3">Adaptive Architecture</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Whether you're listing wholesale products, offering professional services, or leasing real estate — the platform molds to your workflow.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
