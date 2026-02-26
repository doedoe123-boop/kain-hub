<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
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
                    <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                    <span class="text-emerald-400/80">Live</span>
                    <span class="text-slate-600 mx-0.5">·</span>
                    Philippines Online Marketplace
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
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
                            <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                            </svg>
                        </div>
                        <span class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight">NegosyoHub</span>
                    </a>

                    {{-- Navigation links --}}
                    <div class="hidden lg:flex items-center gap-1 text-sm">
                        {{-- Categories Mega-Menu --}}
                        <div class="mega-menu-trigger relative" id="categories-dropdown">
                            <button class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                                Categories
                                <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </button>

                            {{-- Full-width mega menu --}}
                            <div class="mega-menu absolute left-0 top-full mt-2 w-[800px] bg-white dark:bg-slate-900 rounded-2xl shadow-2xl dark:shadow-black/40 border border-slate-200/80 dark:border-slate-700/60 p-6 z-50">
                                <div class="grid grid-cols-3 gap-6">
                                    {{-- Column 1 --}}
                                    <div>
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">Core Industries</h4>
                                        <div class="space-y-0.5">
                                            @php
                                                $coreIndustries = [
                                                    ['label' => 'Construction & Building', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21', 'count' => '240+'],
                                                    ['label' => 'IT & Technology', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25', 'count' => '180+'],
                                                    ['label' => 'Food & Beverage', 'icon' => 'M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513', 'count' => '150+'],
                                                    ['label' => 'Healthcare & Pharma', 'icon' => 'M11.42 15.17l-5.645-5.645a3.563 3.563 0 114.95-4.95l.355.355a2.52 2.52 0 013.562 0l.354-.354a3.565 3.565 0 114.95 4.949L11.42 15.17z', 'count' => '95+'],
                                                ];
                                            @endphp
                                            @foreach ($coreIndustries as $ind)
                                                <a href="{{ route('sector.browse') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-200 group">
                                                    <div class="h-9 w-9 rounded-lg bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center group-hover:bg-sky-100 dark:group-hover:bg-sky-900/50 transition-colors">
                                                        <svg class="w-4 h-4 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ind['icon'] }}" /></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 group-hover:text-sky-700 dark:group-hover:text-sky-400 transition-colors">{{ $ind['label'] }}</p>
                                                        <p class="text-xs text-slate-400 dark:text-slate-500">{{ $ind['count'] }} stores</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- Column 2 --}}
                                    <div>
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">More Sectors</h4>
                                        <div class="space-y-0.5">
                                            @php
                                                $moreSectors = [
                                                    ['label' => 'Chemicals & Raw Materials', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5', 'count' => '85+'],
                                                    ['label' => 'Logistics & Transport', 'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6', 'count' => '120+'],
                                                    ['label' => 'Real Estate & Property', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18', 'count' => '70+'],
                                                    ['label' => 'Agriculture & Farming', 'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375', 'count' => '60+'],
                                                ];
                                            @endphp
                                            @foreach ($moreSectors as $ind)
                                                <a href="{{ route('sector.browse') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-200 group">
                                                    <div class="h-9 w-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/50 transition-colors">
                                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ind['icon'] }}" /></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $ind['label'] }}</p>
                                                        <p class="text-xs text-slate-400 dark:text-slate-500">{{ $ind['count'] }} stores</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- Column 3: Featured --}}
                                    <div class="bg-gradient-to-br from-slate-50 to-sky-50/50 dark:from-slate-800/50 dark:to-sky-900/20 rounded-xl p-5 border border-slate-100 dark:border-slate-700/50">
                                        <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">Government</h4>
                                        <a href="{{ route('sector.browse') }}" class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-white/60 dark:hover:bg-slate-800/40 transition-colors group">
                                            <div class="h-9 w-9 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">PhilGEPS Compatible</p>
                                                <p class="text-xs text-slate-400 dark:text-slate-500">Gov procurement ready</p>
                                            </div>
                                        </a>
                                        <div class="mt-4 pt-4 border-t border-slate-200/60 dark:border-slate-700/40">
                                            <a href="{{ route('sector.browse') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors">
                                                Browse all sectors
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
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
                                <a href="/admin" class="text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Admin</a>
                            @endif
                            @if (auth()->user()->isStoreOwner())
                                @if (auth()->user()->store?->isApproved())
                                    <span class="mx-1.5 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
                                    <a href="/lunar" class="text-sky-600 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold">Dashboard</a>
                                @else
                                    <span class="mx-1.5 h-5 w-px bg-slate-200 dark:bg-slate-700"></span>
                                    <a href="{{ route('store.pending') }}" class="text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Under Review
                                    </a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Sell button — vibrant amber accent --}}
                    <a href="{{ route('register.sector') }}" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl text-slate-900 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-300 hover:-translate-y-0.5" id="sell-btn">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35" /></svg>
                        Sell on NegosyoHub
                    </a>

                    {{-- Dark mode toggle --}}
                    <button @click="darkMode = !darkMode" class="p-2.5 rounded-xl text-slate-400 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200" title="Toggle dark mode" id="dark-mode-toggle">
                        <svg x-show="!darkMode" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>
                        <svg x-show="darkMode" x-cloak class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
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
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                            </svg>
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
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            DTI/SEC Verification
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Verified Sellers
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            BIR VAT Registered
                        </li>
                        <li class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
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
