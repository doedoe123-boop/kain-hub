{{-- Final CTA — Premium Edition --}}
<div class="relative bg-slate-900 dark:bg-[#0B1120] overflow-hidden" id="final-cta">
    {{-- Dynamic Background Glows --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0">
        <div class="absolute w-[800px] h-[400px] bg-sky-500/10 dark:bg-sky-500/10 rounded-full blur-[100px] -translate-y-1/2"></div>
        <div class="absolute w-[600px] h-[300px] bg-emerald-500/10 dark:bg-emerald-500/10 rounded-full blur-[80px] translate-y-1/4 translate-x-1/4"></div>
    </div>

    {{-- Subtle dot grid --}}
    <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-3xl mx-auto text-center">
            {{-- Social proof counter --}}
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/10 mb-8 shadow-xl shadow-black/20 group hover:bg-white/10 transition-colors cursor-default">
                <div class="flex -space-x-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 border border-slate-900 shadow-sm"></div>
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-sky-400 to-sky-600 border border-slate-900 shadow-sm"></div>
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 border border-slate-900 shadow-sm"></div>
                </div>
                <span class="text-xs font-bold text-slate-300 tracking-wide">Join 120+ verified Filipino enterprise sellers</span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.1] mb-6">
                Ready to accelerate
                <span class="block relative mt-2">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-emerald-400">your business growth?</span>
                </span>
            </h2>
            
            <p class="text-lg sm:text-xl text-slate-400 leading-relaxed max-w-2xl mx-auto mb-10 font-medium">
                Tap into the Philippines' most trusted B2B network. Free to register, no hidden fees, and highly targeted buyer exposure.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register.sector') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-10 py-4 text-base font-extrabold rounded-xl text-slate-900 bg-white hover:bg-slate-50 shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:shadow-[0_0_60px_rgba(255,255,255,0.2)] transition-all duration-300 hover:-translate-y-1 group" id="final-cta-btn">
                    Start Selling Today
                    <x-heroicon-o-arrow-right class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300" />
                </a>
            </div>

            {{-- Trust signals --}}
            <div class="mt-12 flex flex-wrap items-center justify-center gap-x-8 gap-y-4 pt-8 border-t border-white/10">
                <span class="flex items-center gap-2 text-sm font-semibold text-slate-400">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <x-heroicon-s-check class="w-3 h-3 text-emerald-400" />
                    </div>
                    Free to start
                </span>
                <span class="flex items-center gap-2 text-sm font-semibold text-slate-400">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <x-heroicon-s-check class="w-3 h-3 text-emerald-400" />
                    </div>
                    No monthly fees
                </span>
                <span class="flex items-center gap-2 text-sm font-semibold text-slate-400">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <x-heroicon-s-check class="w-3 h-3 text-emerald-400" />
                    </div>
                    DTI verified
                </span>
                <span class="flex items-center gap-2 text-sm font-semibold text-slate-400">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <x-heroicon-s-check class="w-3 h-3 text-emerald-400" />
                    </div>
                    Cancel anytime
                </span>
            </div>
        </div>
    </div>
</div>
