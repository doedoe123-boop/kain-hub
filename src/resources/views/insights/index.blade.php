<x-layouts.app :title="'Market Insights — NegosyoHub Marketplace'">

    {{-- Page Header --}}
    <div class="hero-mesh" id="insights-hero">
        <div class="hero-pattern"></div>
        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="max-w-2xl">
                <nav class="text-xs text-slate-400 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span class="mx-1.5">/</span>
                    <span class="text-slate-300">Market Insights</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Market <span class="gradient-text">Insights</span>
                </h1>
                <p class="mt-3 text-base text-slate-400 leading-relaxed max-w-lg">
                    Data-driven intelligence on Philippine marketplace trends, industry performance, and seller analytics.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="bg-slate-50/50 dark:bg-slate-950">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
                @php
                    $insightStats = [
                        ['label' => 'Active Stores', 'value' => number_format(\App\Models\Store::where('status', 'approved')->count()), 'change' => '+12%', 'up' => true, 'icon' => 'heroicon-o-building-storefront', 'color' => 'sky'],
                        ['label' => 'Registered Users', 'value' => number_format(\App\Models\User::count()), 'change' => '+8%', 'up' => true, 'icon' => 'heroicon-o-users', 'color' => 'emerald'],
                        ['label' => 'Categories', 'value' => '24+', 'change' => '+3', 'up' => true, 'icon' => 'heroicon-o-squares-2x2', 'color' => 'amber'],
                        ['label' => 'Regions Served', 'value' => '17', 'change' => 'Nationwide', 'up' => true, 'icon' => 'heroicon-o-map-pin', 'color' => 'violet'],
                    ];
                @endphp
                @foreach ($insightStats as $stat)
                    <div class="bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6 card-hover">
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-10 w-10 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 flex items-center justify-center">
                                <x-dynamic-component :component="$stat['icon']" class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" />
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-bold {{ $stat['up'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600' }}">
                                @if ($stat['up'])
                                    <x-heroicon-o-arrow-trending-up class="w-3 h-3" />
                                @endif
                                {{ $stat['change'] }}
                            </span>
                        </div>
                        <p class="text-2xl font-extrabold text-slate-900 dark:text-white tabular-nums tracking-tight">{{ $stat['value'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Top Industries --}}
            <div class="mb-12">
                <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">Top Industry Categories</h2>
                <div class="bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/40 rounded-2xl overflow-hidden">
                    @php
                        $industries = [
                            ['name' => 'Construction & Building Materials', 'stores' => 240, 'growth' => '+12%', 'bar' => 'w-[85%]', 'color' => 'bg-sky-500'],
                            ['name' => 'IT & Technology', 'stores' => 180, 'growth' => '+8%', 'bar' => 'w-[64%]', 'color' => 'bg-emerald-500'],
                            ['name' => 'Food & Beverage', 'stores' => 150, 'growth' => '+15%', 'bar' => 'w-[53%]', 'color' => 'bg-amber-500'],
                            ['name' => 'Healthcare & Pharmaceuticals', 'stores' => 95, 'growth' => '+5%', 'bar' => 'w-[34%]', 'color' => 'bg-rose-500'],
                            ['name' => 'Chemicals & Raw Materials', 'stores' => 85, 'growth' => '+3%', 'bar' => 'w-[30%]', 'color' => 'bg-violet-500'],
                            ['name' => 'Logistics & Transport', 'stores' => 120, 'growth' => '+10%', 'bar' => 'w-[43%]', 'color' => 'bg-teal-500'],
                        ];
                    @endphp
                    @foreach ($industries as $idx => $ind)
                        <div class="flex items-center gap-5 px-6 py-4 {{ !$loop->last ? 'border-b border-slate-50 dark:border-slate-700/30' : '' }} hover:bg-slate-50/50 dark:hover:bg-slate-800/80 transition-colors">
                            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 tabular-nums w-6 text-right">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">{{ $ind['name'] }}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs text-slate-500 dark:text-slate-400 tabular-nums">{{ $ind['stores'] }} stores</span>
                                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $ind['growth'] }}</span>
                                    </div>
                                </div>
                                <div class="h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full {{ $ind['color'] }} rounded-full {{ $ind['bar'] }} transition-all duration-700"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Regional Coverage --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
                {{-- Top Regions --}}
                <div class="bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6">
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">Top Regions by Store Count</h3>
                    <div class="space-y-4">
                        @php
                            $regions = [
                                ['name' => 'NCR — Metro Manila', 'count' => 'Leading', 'pct' => '38%'],
                                ['name' => 'Region IV-A — CALABARZON', 'count' => 'Growing', 'pct' => '18%'],
                                ['name' => 'Region III — Central Luzon', 'count' => 'Growing', 'pct' => '14%'],
                                ['name' => 'Region VII — Central Visayas', 'count' => 'Emerging', 'pct' => '12%'],
                                ['name' => 'Region XI — Davao', 'count' => 'Emerging', 'pct' => '8%'],
                            ];
                        @endphp
                        @foreach ($regions as $region)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-700 dark:text-slate-300">{{ $region['name'] }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-bold uppercase tracking-wider {{ $region['count'] === 'Leading' ? 'text-sky-600 dark:text-sky-400' : ($region['count'] === 'Growing' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400') }}">{{ $region['count'] }}</span>
                                    <span class="text-xs font-bold text-slate-900 dark:text-slate-100 tabular-nums bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded">{{ $region['pct'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Platform Health --}}
                <div class="bg-white dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/40 rounded-2xl p-6">
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">Platform Health</h3>
                    <div class="space-y-5">
                        @php
                            $health = [
                                ['label' => 'Seller Verification Rate', 'value' => '100%', 'desc' => 'All sellers undergo identity verification'],
                                ['label' => 'Average Response Time', 'value' => '< 24hrs', 'desc' => 'Store approvals processed quickly'],
                                ['label' => 'Customer Satisfaction', 'value' => '98%', 'desc' => 'Based on platform ratings and reviews'],
                                ['label' => 'Platform Uptime', 'value' => '99.9%', 'desc' => 'Reliable infrastructure 24/7'],
                            ];
                        @endphp
                        @foreach ($health as $h)
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-0.5">
                                    <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $h['label'] }}</span>
                                        <span class="text-sm font-extrabold text-slate-900 dark:text-white tabular-nums">{{ $h['value'] }}</span>
                                    </div>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $h['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Disclaimer --}}
            <p class="text-xs text-slate-400 dark:text-slate-600 italic text-center">Market data shown is representative. Live analytics will be available as the platform scales.</p>
        </div>
    </div>

</x-layouts.app>
