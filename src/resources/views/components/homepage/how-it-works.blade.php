{{-- How It Works — Premium Edition --}}
<div class="relative bg-slate-50 dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="how-it-works">
    
    {{-- Ambient Mesh Gradient Background --}}
    <div class="absolute inset-0 z-0 opacity-40 dark:opacity-20 pointer-events-none hidden sm:block">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-sky-400/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="text-center mb-20">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-5 shadow-sm">
                <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.15em]">Onboarding</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                Start selling in 3 steps
            </h2>
            <p class="mt-5 text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                From registration to your first order — we've streamlined the enterprise onboarding process to take less than 10 minutes.
            </p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-4 relative group/grid">
                
                {{-- Animated Connector line (desktop only) --}}
                <div class="hidden md:block absolute top-[44px] left-[calc(16.67%+30px)] right-[calc(16.67%+30px)] h-0.5 bg-slate-200 dark:bg-slate-800 overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-full bg-gradient-to-r from-transparent via-sky-400 to-transparent -translate-x-full group-hover/grid:animate-[shimmer_2s_infinite]"></div>
                </div>

                {{-- Step 1 --}}
                <div class="text-center px-4 relative group">
                    <div class="relative z-10 mx-auto flex items-center justify-center h-[5.5rem] w-[5.5rem] rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl shadow-sky-500/5 mb-6 group-hover:-translate-y-2 group-hover:border-sky-300 dark:group-hover:border-sky-600 transition-all duration-300">
                        {{-- Number background --}}
                        <span class="absolute -top-3 -right-3 text-[4rem] font-black text-slate-100 dark:text-slate-800/80 leading-none pointer-events-none group-hover:text-sky-100 dark:group-hover:text-sky-900/40 transition-colors duration-300">1</span>
                        <x-heroicon-o-user-plus class="relative z-10 w-8 h-8 text-sky-600 dark:text-sky-400 group-hover:scale-110 transition-transform duration-300" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">Create Account</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-xs mx-auto mb-4">
                        Register and verify your identity. Upload your DTI/SEC documents for compliance review.
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 dark:bg-sky-500/10 border border-sky-100 dark:border-sky-500/20 text-[10px] font-bold text-sky-700 dark:text-sky-400">
                        <x-heroicon-s-clock class="w-3.5 h-3.5" />
                        ~2 MINUTES
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="text-center px-4 relative group mt-12 md:mt-0">
                    <div class="relative z-10 mx-auto flex items-center justify-center h-[5.5rem] w-[5.5rem] rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl shadow-emerald-500/5 mb-6 group-hover:-translate-y-2 group-hover:border-emerald-300 dark:group-hover:border-emerald-600 transition-all duration-300">
                        <span class="absolute -top-3 -right-3 text-[4rem] font-black text-slate-100 dark:text-slate-800/80 leading-none pointer-events-none group-hover:text-emerald-100 dark:group-hover:text-emerald-900/40 transition-colors duration-300">2</span>
                        <x-heroicon-o-building-storefront class="relative z-10 w-8 h-8 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">Set Up Store</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-xs mx-auto mb-4">
                        Customize your storefront, add products, set pricing, and configure delivery options.
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 text-[10px] font-bold text-emerald-700 dark:text-emerald-400">
                        <x-heroicon-s-clock class="w-3.5 h-3.5" />
                        ~5 MINUTES
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="text-center px-4 relative group mt-12 md:mt-0">
                    <div class="relative z-10 mx-auto flex items-center justify-center h-[5.5rem] w-[5.5rem] rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl shadow-violet-500/5 mb-6 group-hover:-translate-y-2 group-hover:border-violet-300 dark:group-hover:border-violet-600 transition-all duration-300">
                        <span class="absolute -top-3 -right-3 text-[4rem] font-black text-slate-100 dark:text-slate-800/80 leading-none pointer-events-none group-hover:text-violet-100 dark:group-hover:text-violet-900/40 transition-colors duration-300">3</span>
                        <x-heroicon-o-rocket-launch class="relative z-10 w-8 h-8 text-violet-600 dark:text-violet-400 group-hover:scale-110 transition-transform duration-300" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight mb-3">Start Selling</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed max-w-xs mx-auto mb-4">
                        Go live immediately upon approval and begin receiving orders from buyers nationwide.
                    </p>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-50 dark:bg-violet-500/10 border border-violet-100 dark:border-violet-500/20 text-[10px] font-bold text-violet-700 dark:text-violet-400">
                        <x-heroicon-s-bolt class="w-3.5 h-3.5" />
                        INSTANT
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
