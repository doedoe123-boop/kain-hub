{{-- CTA: Join the marketplace — dual CTA for sellers & agents --}}
<div class="relative overflow-hidden" id="seller-cta">
    <div class="absolute inset-0 bg-gradient-to-r from-sky-600 via-sky-700 to-sky-800 dark:from-sky-700 dark:via-sky-800 dark:to-sky-900"></div>
    {{-- Decorative elements --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-sky-400/10 rounded-full translate-y-1/2 blur-2xl"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="max-w-3xl mx-auto text-center">
            <p class="text-[10px] font-bold text-sky-200 uppercase tracking-[0.2em] mb-4">Join NegosyoHub</p>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">Ready to grow your business?</h2>
            <p class="mt-4 text-base text-sky-100/80 leading-relaxed max-w-lg mx-auto">Whether you own a retail store or manage properties — NegosyoHub gives you the tools, reach, and trust framework to succeed.</p>

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                @guest
                    <a href="{{ route('register.sector') }}"
                        class="inline-flex items-center gap-2.5 px-8 py-4 text-sm font-extrabold rounded-xl text-sky-700 bg-white hover:bg-sky-50 shadow-2xl shadow-black/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl group">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64" /></svg>
                        Sell on NegosyoHub
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </a>
                @endguest
                @auth
                    @if (auth()->user()->isStoreOwner() && auth()->user()->store?->isApproved())
                        <a href="/lunar" class="inline-flex items-center gap-2 px-8 py-4 text-sm font-extrabold rounded-xl text-sky-700 bg-white hover:bg-sky-50 shadow-2xl shadow-black/10 transition-all duration-300 hover:-translate-y-1">
                            Seller Dashboard
                        </a>
                    @elseif (auth()->user()->isAdmin())
                        <a href="/admin" class="inline-flex items-center gap-2 px-8 py-4 text-sm font-extrabold rounded-xl text-sky-700 bg-white hover:bg-sky-50 shadow-2xl shadow-black/10 transition-all duration-300 hover:-translate-y-1">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-6 text-sm text-sky-200/70">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Free to register
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    No monthly fees
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Set up in minutes
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Nationwide reach
                </span>
            </div>
        </div>
    </div>
</div>
