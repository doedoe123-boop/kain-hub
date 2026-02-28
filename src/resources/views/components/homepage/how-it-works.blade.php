{{-- How It Works — 3 steps with numbered indicators and connectors --}}
<div class="bg-slate-50 dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60" id="how-it-works">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-14">
            <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3">Getting Started</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Start selling in 3 steps</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">From registration to your first order — it takes less than 10 minutes.</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-0 relative">
                {{-- Connector lines (desktop only) --}}
                <div class="hidden md:block absolute top-10 left-[calc(16.67%+24px)] right-[calc(16.67%+24px)] h-0.5 bg-gradient-to-r from-sky-200 via-emerald-200 to-violet-200 dark:from-sky-800 dark:via-emerald-800 dark:to-violet-800"></div>

                {{-- Step 1 --}}
                <div class="text-center px-6 pb-10 md:pb-0 relative">
                    <div class="relative z-10 inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-white dark:bg-sky-900/20 border-2 border-slate-200 dark:border-sky-800 mb-5 group-hover:scale-105 transition-transform">
                        <span class="text-2xl font-black text-sky-600/20 dark:text-sky-400/20 absolute -top-1 -right-1 text-[40px] leading-none">1</span>
                        <x-heroicon-o-user-plus class="w-8 h-8 text-sky-600 dark:text-sky-400" />
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight mb-2">Create Account</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-2">Register and verify your identity. Upload your DTI/SEC documents.</p>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-sky-600 dark:text-sky-400">
                        <x-heroicon-o-clock class="w-3 h-3" />
                        ~2 minutes
                    </span>
                </div>

                {{-- Step 2 --}}
                <div class="text-center px-6 pb-10 md:pb-0 relative border-t md:border-t-0 border-slate-200 dark:border-slate-800 pt-10 md:pt-0">
                    <div class="relative z-10 inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-white dark:bg-emerald-900/20 border-2 border-slate-200 dark:border-emerald-800 mb-5">
                        <span class="text-2xl font-black text-emerald-600/20 dark:text-emerald-400/20 absolute -top-1 -right-1 text-[40px] leading-none">2</span>
                        <x-heroicon-o-building-storefront class="w-8 h-8 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight mb-2">Set Up Store</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-2">Customize your storefront, add products, set pricing and delivery options.</p>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                        <x-heroicon-o-clock class="w-3 h-3" />
                        ~5 minutes
                    </span>
                </div>

                {{-- Step 3 --}}
                <div class="text-center px-6 relative border-t md:border-t-0 border-slate-200 dark:border-slate-800 pt-10 md:pt-0">
                    <div class="relative z-10 inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-white dark:bg-violet-900/20 border-2 border-slate-200 dark:border-violet-800 mb-5">
                        <span class="text-2xl font-black text-violet-600/20 dark:text-violet-400/20 absolute -top-1 -right-1 text-[40px] leading-none">3</span>
                        <x-heroicon-o-rocket-launch class="w-8 h-8 text-violet-600 dark:text-violet-400" />
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white tracking-tight mb-2">Start Selling</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-2">Go live and receive orders from buyers across the Philippines.</p>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-violet-600 dark:text-violet-400">
                        <x-heroicon-o-clock class="w-3 h-3" />
                        Instant
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
