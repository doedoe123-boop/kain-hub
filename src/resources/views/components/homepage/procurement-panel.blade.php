{{-- ============================================================
     HERO: Clean marketplace positioning with social proof
     ============================================================ --}}
<div class="hero-mesh" id="hero-section">
    <div class="hero-pattern"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
            {{-- Eyebrow --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/[0.06] border border-white/[0.08] mb-6">
                <span class="text-base">🇵🇭</span>
                <span class="text-xs font-semibold text-slate-300 tracking-wide">The Philippines' B2B Marketplace</span>
            </div>

            {{-- Headline --}}
            <h1 class="text-3xl sm:text-4xl lg:text-[3.5rem] font-extrabold text-white leading-[1.1] tracking-tight">
                Build Your Store.
                <br>
                Reach More Businesses.
                <br>
                <span class="gradient-text">Grow in One Marketplace.</span>
            </h1>
            <p class="mt-5 text-base sm:text-lg text-slate-400 max-w-xl mx-auto leading-relaxed">
                NegosyoHub connects verified sellers across construction, IT, healthcare, real estate, and more — all in one trusted Philippine marketplace.
            </p>

            {{-- Two CTAs --}}
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up-delay-1">
                <a href="{{ route('register.sector') }}"
                    class="inline-flex items-center gap-2.5 px-8 py-4 text-sm font-extrabold rounded-xl text-slate-900 bg-white hover:bg-slate-50 shadow-2xl shadow-black/10 transition-all duration-300 hover:-translate-y-1 group" id="hero-cta-primary">
                    Become a Seller
                    <x-heroicon-o-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" />
                </a>
                <a href="{{ route('stores.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 text-sm font-semibold rounded-xl text-white border border-white/20 hover:bg-white/10 transition-all duration-300" id="hero-cta-secondary">
                    Explore Marketplace
                </a>
            </div>

            {{-- Social Proof Stats Bar --}}
            <div class="mt-12 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 animate-fade-in-up-delay-2">
                <div class="flex items-center gap-2">
                    <div class="flex -space-x-1.5">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 border-2 border-emerald-500/40 flex items-center justify-center">
                            <x-heroicon-s-check class="w-3 h-3 text-emerald-400" />
                        </div>
                    </div>
                    <span class="text-sm font-bold text-white">120+</span>
                    <span class="text-xs text-slate-400">Verified Sellers</span>
                </div>
                <div class="w-px h-4 bg-slate-700 hidden sm:block"></div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-squares-2x2 class="w-4 h-4 text-sky-400" />
                    <span class="text-sm font-bold text-white">8</span>
                    <span class="text-xs text-slate-400">Industry Sectors</span>
                </div>
                <div class="w-px h-4 bg-slate-700 hidden sm:block"></div>
                <div class="flex items-center gap-2">
                    <x-heroicon-o-flag class="w-4 h-4 text-amber-400" />
                    <span class="text-xs text-slate-400 font-medium">100% Filipino-owned</span>
                </div>
            </div>

            {{-- Floating Trust Badges --}}
            <div class="mt-6 flex flex-wrap items-center justify-center gap-2 animate-fade-in-up-delay-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-semibold text-emerald-400 uppercase tracking-wider">
                    <x-heroicon-s-shield-check class="w-3 h-3" />
                    KYC Verified
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-500/10 border border-sky-500/20 text-[10px] font-semibold text-sky-400 uppercase tracking-wider">
                    <x-heroicon-s-document-check class="w-3 h-3" />
                    DTI / SEC
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-[10px] font-semibold text-amber-400 uppercase tracking-wider">
                    <x-heroicon-s-lock-closed class="w-3 h-3" />
                    Secure Platform
                </span>
            </div>
        </div>
    </div>
</div>
