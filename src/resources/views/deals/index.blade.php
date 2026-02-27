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
                        <x-heroicon-s-play-circle class="w-4 h-4 animate-pulse" />
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
                            ['title' => 'Flash Sales', 'desc' => 'Limited-time deals with massive discounts. Act fast before they\'re gone!', 'icon' => 'heroicon-o-bolt', 'gradient' => 'from-amber-500 to-orange-500', 'bg' => 'bg-amber-50 dark:bg-amber-900/15'],
                            ['title' => 'Bundle Deals', 'desc' => 'Buy more, save more. Curated product bundles from verified sellers.', 'icon' => 'heroicon-o-archive-box', 'gradient' => 'from-sky-500 to-blue-500', 'bg' => 'bg-sky-50 dark:bg-sky-900/15'],
                            ['title' => 'Store Promos', 'desc' => 'Exclusive promotions from your favorite stores. Discounts, freebies, and more.', 'icon' => 'heroicon-o-tag', 'gradient' => 'from-emerald-500 to-teal-500', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/15'],
                            ['title' => 'Clearance', 'desc' => 'End-of-season clearance items at deeply discounted prices.', 'icon' => 'heroicon-o-banknotes', 'gradient' => 'from-rose-500 to-pink-500', 'bg' => 'bg-rose-50 dark:bg-rose-900/15'],
                        ];
                    @endphp
                    @foreach ($dealTypes as $deal)
                        <div class="group {{ $deal['bg'] }} border border-slate-100 dark:border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br {{ $deal['gradient'] }} flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <x-dynamic-component :component="$deal['icon']" class="w-6 h-6 text-white" />
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
                    <x-heroicon-o-bell-alert class="w-7 h-7 text-amber-600 dark:text-amber-400" />
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
