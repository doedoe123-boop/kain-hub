<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          theme: localStorage.getItem('theme') || 'system',
          darkMode: false,
          resolve() {
              this.darkMode = this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
          },
          toggle() {
              const next = { system: 'dark', dark: 'light', light: 'system' };
              this.theme = next[this.theme];
              this.theme === 'system' ? localStorage.removeItem('theme') : localStorage.setItem('theme', this.theme);
              this.resolve();
          }
      }"
      x-init="
          resolve();
          window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => resolve());
          if (localStorage.getItem('darkMode') !== null) { localStorage.removeItem('darkMode'); }
      "
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="NegosyoHub — Philippines' premier online marketplace. Discover verified stores, shop quality products, and buy from trusted Filipino sellers across every category nationwide.">
    <title>{{ $title ?? 'NegosyoHub — Philippine Online Marketplace' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">
    {{-- Top utility bar --}}
    <div class="bg-slate-950 text-slate-400 text-xs">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-9">
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline-flex items-center gap-1.5 font-medium text-slate-500">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-emerald-400/80">Live</span>
                    <span class="text-slate-600 mx-0.5">·</span>
                    Philippines Online Marketplace
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <x-heroicon-s-check-badge class="w-3.5 h-3.5 text-emerald-500" />
                    Verified sellers
                </span>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-slate-500">{{ auth()->user()->email }}</span>
                    @if (auth()->user()->isCustomer())
                        <span class="text-slate-700">·</span>
                        <a href="{{ route('register.sector') }}" class="hover:text-white transition-colors duration-200">Become a Seller</a>
                    @endif
                @else
                    <a href="{{ route('register.sector') }}" class="hover:text-white transition-colors duration-200">Become a Seller</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Main navigation --}}
    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/60 dark:border-slate-800/60 shadow-[0_1px_3px_rgba(0,0,0,0.04)]" id="main-nav">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-2.5 group" id="logo-link">
                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 dark:from-sky-400 dark:to-sky-600 flex items-center justify-center shadow-lg shadow-sky-500/20">
                            <x-heroicon-o-building-storefront class="w-4.5 h-4.5 text-white" />
                        </div>
                        <span class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">NegosyoHub</span>
                    </a>

                    {{-- Navigation links --}}
                    <div class="hidden lg:flex items-center gap-1 text-sm">
                        {{-- Categories Mega-Menu --}}
                        <div class="mega-menu-trigger relative" id="categories-dropdown">
                            <button class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">
                                <x-heroicon-o-squares-2x2 class="w-4 h-4" />
                                Categories
                                <x-heroicon-o-chevron-down class="w-3 h-3 text-slate-400" />
                            </button>

                            {{-- Full-width mega menu --}}
                            <div class="mega-menu absolute left-0 top-full mt-2 w-[800px] bg-white dark:bg-slate-900 rounded-2xl shadow-2xl dark:shadow-black/40 border border-slate-200/80 dark:border-slate-700/60 p-6 z-50">
                                <div class="grid grid-cols-3 gap-6">
                                    @php
                                        $megaSectors = \App\Models\Sector::active()->get();
                                        $megaCounts = \App\Models\Store::query()
                                            ->where('status', \App\StoreStatus::Approved)
                                            ->whereNotNull('sector')
                                            ->selectRaw('sector, count(*) as total')
                                            ->groupBy('sector')
                                            ->pluck('total', 'sector');

                                        // Split sectors evenly across two columns
                                        $firstHalfCount = max(ceil($megaSectors->count() / 2), 1);
                                        $col1Sectors = $megaSectors->take($firstHalfCount);
                                        $col2Sectors = $megaSectors->skip($firstHalfCount);
                                    @endphp

                                    {{-- Column 1 --}}
                                    <div>
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">Core Industries</h4>
                                        <div class="space-y-0.5">
                                            @foreach ($col1Sectors as $sector)
                                                @php $count = $megaCounts[$sector->slug] ?? 0; @endphp
                                                <a href="{{ route('sector.browse', ['search' => $sector->name]) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-200 group">
                                                    <div class="h-9 w-9 rounded-lg bg-{{ $sector->color }}-50 dark:bg-{{ $sector->color }}-900/30 flex items-center justify-center group-hover:bg-{{ $sector->color }}-100 dark:group-hover:bg-{{ $sector->color }}-900/50 transition-colors">
                                                        <x-dynamic-component :component="$sector->icon" class="w-4 h-4 text-{{ $sector->color }}-600 dark:text-{{ $sector->color }}-400" />
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 group-hover:text-{{ $sector->color }}-700 dark:group-hover:text-{{ $sector->color }}-400 transition-colors">{{ $sector->name }}</p>
                                                        <p class="text-xs text-slate-400 dark:text-slate-500">{{ $count }} {{ Str::plural('store', $count) }}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Column 2 --}}
                                    <div>
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">More Sectors</h4>
                                        @if($col2Sectors->isNotEmpty())
                                            <div class="space-y-0.5">
                                                @foreach ($col2Sectors as $sector)
                                                    @php $count = $megaCounts[$sector->slug] ?? 0; @endphp
                                                    <a href="{{ route('sector.browse', ['search' => $sector->name]) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-200 group">
                                                        <div class="h-9 w-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/50 transition-colors">
                                                            <x-dynamic-component :component="$sector->icon" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $sector->name }}</p>
                                                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $count }} {{ Str::plural('store', $count) }}</p>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs text-slate-400 dark:text-slate-500 italic mt-2">More sectors coming soon...</p>
                                        @endif
                                    </div>
                                    {{-- Column 3: Featured --}}
                                    <div class="bg-gradient-to-br from-slate-50 to-sky-50/50 dark:from-slate-800/50 dark:to-sky-900/20 rounded-xl p-5 border border-slate-100 dark:border-slate-700/50">
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">Government</h4>
                                        <a href="{{ route('sector.browse') }}" class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-white/60 dark:hover:bg-slate-800/40 transition-colors group">
                                            <div class="h-9 w-9 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                                <x-heroicon-o-building-library class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">PhilGEPS Compatible</p>
                                                <p class="text-xs text-slate-400 dark:text-slate-500">Gov procurement ready</p>
                                            </div>
                                        </a>
                                        <div class="mt-4 pt-4 border-t border-slate-200/60 dark:border-slate-700/40">
                                            <a href="{{ route('sector.browse') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors">
                                                Browse all sectors
                                                <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('stores.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Stores</a>
                        <a href="{{ route('deals.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Deals</a>
                        <a href="{{ route('insights.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Insights</a>

                        @auth
                            @if (auth()->user()->isAdmin())
                                <span class="mx-1.5 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
                                <a href="/moon/portal/itsec_tk_{{ config('app.admin_path_token') }}" class="text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Admin Panel</a>
                            @endif
                            @if (auth()->user()->isStoreOwner())
                                @if (auth()->user()->store?->isApproved())
                                    <span class="mx-1.5 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
                                    <a href="/store/dashboard/tk_{{ config('app.store_path_token') }}" class="text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Dashboard</a>
                                @else
                                    <span class="mx-1.5 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
                                    <a href="{{ route('store.pending') }}" class="text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold inline-flex items-center gap-1.5">
                                        <x-heroicon-o-clock class="w-3.5 h-3.5" />
                                        Under Review
                                    </a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Dark mode toggle (cycles: system → dark → light → system) --}}
                    <button @click="toggle()" class="relative p-2.5 rounded-xl text-slate-400 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200" :title="'Theme: ' + theme" id="dark-mode-toggle">
                        {{-- Moon: shown when theme resolves to light (click will go dark) --}}
                        <svg x-show="!darkMode && theme !== 'system'" x-cloak class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>
                        {{-- Sun: shown when theme resolves to dark (click will go light) --}}
                        <svg x-show="darkMode && theme !== 'system'" x-cloak class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                        {{-- Computer/System: shown when theme is system --}}
                        <svg x-show="theme === 'system'" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" /></svg>
                    </button>

                    @auth
                        <div class="flex items-center gap-3">
                            <div class="hidden sm:flex items-center gap-2.5 text-sm">
                                <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-sky-500 to-emerald-500 flex items-center justify-center shadow-sm">
                                    <span class="text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ auth()->user()->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs text-slate-400 hover:text-red-500 dark:hover:text-red-400 px-2.5 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10 transition-all duration-200 font-medium">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('register.sector') }}"
                            class="inline-flex items-center px-4 py-2.5 text-sm font-bold rounded-xl text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 shadow-lg shadow-sky-500/20 transition-all duration-300 hover:-translate-y-0.5" id="register-seller-btn">
                            Sell on NegosyoHub
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content — full-bleed wrapper for hero sections --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900 dark:bg-slate-950 border-t border-slate-800">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center shadow-lg shadow-sky-500/20">
                            <x-heroicon-o-building-storefront class="w-4 h-4 text-white" />
                        </div>
                        <span class="text-base font-extrabold text-white tracking-tight">NegosyoHub</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-400 leading-relaxed">Connecting verified Filipino sellers with customers nationwide. The trusted online marketplace for quality products and great deals.</p>
                </div>
                {{-- Platform links --}}
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-5">Platform</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('stores.index') }}" class="hover:text-white transition-colors duration-200">Browse Stores</a></li>
                        <li><a href="{{ route('register.sector') }}" class="hover:text-white transition-colors duration-200">Sell on NegosyoHub</a></li>
                        <li><a href="{{ route('deals.index') }}" class="hover:text-white transition-colors duration-200">Deals & Offers</a></li>
                        <li><a href="{{ route('insights.index') }}" class="hover:text-white transition-colors duration-200">Market Insights</a></li>
                    </ul>
                </div>
                {{-- Industries --}}
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-5">Industries</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('sector.browse') }}" class="hover:text-white transition-colors duration-200">Construction</a></li>
                        <li><a href="{{ route('sector.browse') }}" class="hover:text-white transition-colors duration-200">IT & Technology</a></li>
                        <li><a href="{{ route('sector.browse') }}" class="hover:text-white transition-colors duration-200">Food & Beverage</a></li>
                        <li><a href="{{ route('sector.browse') }}" class="hover:text-white transition-colors duration-200">Healthcare</a></li>
                    </ul>
                </div>
                {{-- Compliance --}}
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em] mb-5">Compliance</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="inline-flex items-center gap-2">
                            <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500" />
                            DTI/SEC Verification
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500" />
                            Verified Sellers
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500" />
                            BIR VAT Registered
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500" />
                            PhilGEPS Compatible
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} NegosyoHub. All rights reserved.</p>
                <p class="text-xs text-slate-500">Built in the Philippines 🇵🇭</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
