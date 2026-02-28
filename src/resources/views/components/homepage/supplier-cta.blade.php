{{-- Final CTA — With social proof and trust signals --}}
<div class="bg-slate-900 dark:bg-[#0B1120] relative overflow-hidden" id="final-cta">
    {{-- Radial glow --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="w-[600px] h-[300px] bg-sky-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="max-w-2xl mx-auto text-center">
            {{-- Social proof counter --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/[0.06] border border-white/[0.08] mb-6">
                <div class="flex -space-x-1">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/30 border border-emerald-500/50"></div>
                    <div class="w-5 h-5 rounded-full bg-sky-500/30 border border-sky-500/50"></div>
                    <div class="w-5 h-5 rounded-full bg-amber-500/30 border border-amber-500/50"></div>
                </div>
                <span class="text-xs font-semibold text-slate-300">Join 120+ verified Filipino businesses</span>
            </div>

            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">Ready to grow your business?</h2>
            <p class="mt-4 text-base text-slate-400 leading-relaxed max-w-lg mx-auto">Join verified Filipino sellers across multiple industries. Free to start — no monthly fees, no hidden charges.</p>

            <div class="mt-8">
                <a href="{{ route('register.sector') }}"
                    class="inline-flex items-center gap-2.5 px-10 py-4 text-base font-extrabold rounded-xl text-slate-900 bg-white hover:bg-slate-100 shadow-2xl shadow-black/20 transition-all duration-300 hover:-translate-y-1 group" id="final-cta-btn">
                    Become a Seller
                    <x-heroicon-o-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" />
                </a>
            </div>

            {{-- Trust signals --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-500" />
                    Free to start
                </span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-500" />
                    No monthly fees
                </span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-500" />
                    DTI verified
                </span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500">
                    <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-500" />
                    Cancel anytime
                </span>
            </div>
        </div>
    </div>
</div>
