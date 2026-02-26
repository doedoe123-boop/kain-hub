{{-- Why NegosyoHub — Platform Value Proposition --}}
<div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60" id="why-negosyohub">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-12 lg:mb-16">
            <p class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.2em] mb-3">Why NegosyoHub</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">The marketplace built for Filipino commerce</h2>
            <p class="mt-3 text-base text-slate-500 dark:text-slate-400 max-w-xl mx-auto">Whether you're a seller looking to grow or a buyer searching for quality — we've built the tools and trust framework to make it happen.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            {{-- Pillar 1: For Sellers --}}
            <div class="group relative rounded-2xl bg-gradient-to-br from-sky-50 to-white dark:from-sky-950/30 dark:to-slate-800/30 border border-sky-100 dark:border-sky-800/30 p-7 hover:border-sky-200 dark:hover:border-sky-700 transition-all duration-300 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-sky-100/50 to-transparent dark:from-sky-800/10 rounded-bl-[80px]"></div>
                <div class="relative z-10">
                    <div class="h-14 w-14 rounded-2xl bg-sky-100 dark:bg-sky-900/40 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Sell on NegosyoHub</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-5">Create your own storefront, list products, manage orders, and reach customers nationwide. Free to start — no monthly fees.</p>
                    <ul class="space-y-2.5">
                        @foreach (['Custom storefront with your branding', 'Product catalog & inventory management', 'Built-in order & payment processing', 'Analytics dashboard & insights'] as $feat)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Pillar 2: For Buyers --}}
            <div class="group relative rounded-2xl bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/30 dark:to-slate-800/30 border border-emerald-100 dark:border-emerald-800/30 p-7 hover:border-emerald-200 dark:hover:border-emerald-700 transition-all duration-300 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-emerald-100/50 to-transparent dark:from-emerald-800/10 rounded-bl-[80px]"></div>
                <div class="relative z-10">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Shop With Confidence</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-5">Browse verified stores, compare products, and enjoy buyer protection on every transaction. Your trust is our priority.</p>
                    <ul class="space-y-2.5">
                        @foreach (['Every seller is identity-verified', 'Buyer protection on all orders', 'Real reviews from real customers', 'Secure payment gateway'] as $feat)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Pillar 3: Trust & Compliance --}}
            <div class="group relative rounded-2xl bg-gradient-to-br from-amber-50 to-white dark:from-amber-950/30 dark:to-slate-800/30 border border-amber-100 dark:border-amber-800/30 p-7 hover:border-amber-200 dark:hover:border-amber-700 transition-all duration-300 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-amber-100/50 to-transparent dark:from-amber-800/10 rounded-bl-[80px]"></div>
                <div class="relative z-10">
                    <div class="h-14 w-14 rounded-2xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Philippine-Grade Trust</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-5">Built specifically for the Philippine market with local compliance, government-aligned verification, and peso-denominated pricing.</p>
                    <ul class="space-y-2.5">
                        @foreach (['DTI/SEC business verification', 'BIR-compliant transactions', 'PhilGEPS-aligned standards', 'Local customer support team'] as $feat)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                {{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
