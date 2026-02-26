<x-layouts.app :title="'Deals & Offers — NegosyoHub Marketplace'">

    {{-- Page Header --}}
    <div class="hero-mesh" id="deals-hero">
        <div class="hero-pattern"></div>
        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="max-w-2xl">
                <nav class="text-xs text-slate-400 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span class="mx-1.5">/</span>
                    <span class="text-slate-300">Deals & Offers</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Deals & <span class="gradient-text">Special Offers</span>
                </h1>
                <p class="mt-3 text-base text-slate-400 leading-relaxed max-w-lg">
                    Discover exclusive deals, limited-time offers, and special promotions from verified sellers on NegosyoHub.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-slate-50/50 dark:bg-slate-950">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

            {{-- Featured Deals Banner --}}
            <div class="mb-12 rounded-2xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 p-8 lg:p-12 text-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyem0wLTE4VjE0SDI0VjE2aDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 text-sm font-bold mb-4">
                        <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" /></svg>
                        Coming Soon
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Hot Deals Are Coming!</h2>
                    <p class="mt-3 text-base text-white/80 max-w-lg mx-auto">Sellers will soon be able to post exclusive deals and time-limited offers. Stay tuned for amazing savings from verified stores.</p>
                </div>
            </div>

            {{-- Deal Categories Preview --}}
            <div class="mb-12">
                <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">What to expect</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @php
                        $dealTypes = [
                            ['title' => 'Flash Sales', 'desc' => 'Limited-time deals with massive discounts. Act fast before they\'re gone!', 'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z', 'gradient' => 'from-amber-500 to-orange-500', 'bg' => 'bg-amber-50 dark:bg-amber-900/15'],
                            ['title' => 'Bundle Deals', 'desc' => 'Buy more, save more. Curated product bundles from verified sellers.', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z', 'gradient' => 'from-sky-500 to-blue-500', 'bg' => 'bg-sky-50 dark:bg-sky-900/15'],
                            ['title' => 'Store Promos', 'desc' => 'Exclusive promotions from your favorite stores. Discounts, freebies, and more.', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z', 'gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/15'],
                            ['title' => 'Clearance', 'desc' => 'End-of-season clearance items at deeply discounted prices.', 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z', 'gradient' => 'from-rose-500 to-pink-500', 'bg' => 'bg-rose-50 dark:bg-rose-900/15'],
                        ];
                    @endphp
                    @foreach ($dealTypes as $deal)
                        <div class="group {{ $deal['bg'] }} border border-slate-100 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br {{ $deal['gradient'] }} flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $deal['icon'] }}" /></svg>
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight mb-1.5">{{ $deal['title'] }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $deal['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Newsletter CTA --}}
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800/40 p-8 lg:p-10 text-center">
                <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-amber-100 dark:bg-amber-900/30 mb-5">
                    <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Get notified when deals go live</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto mb-6">Be the first to know about flash sales, exclusive promos, and limited-time offers from verified sellers.</p>
                <div class="max-w-sm mx-auto flex gap-2">
                    <input type="email" placeholder="Your email address" class="flex-1 rounded-xl border border-slate-200 dark:border-slate-600 dark:bg-slate-700 px-4 py-3 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent focus:outline-none dark:text-white">
                    <button class="px-6 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-sm font-bold text-white shadow-lg shadow-sky-500/20 transition-all duration-300 hover:-translate-y-0.5 shrink-0">
                        Notify Me
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
