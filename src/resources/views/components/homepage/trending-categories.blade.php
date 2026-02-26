{{-- Trending Procurement Categories — premium data-driven cards --}}
<div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60" id="trending-categories">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Trending Categories</h2>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">See what shoppers and businesses are buying right now</p>
            </div>
            <a href="{{ route('sector.browse') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors duration-200">
                All categories
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $trends = [
                    ['name' => 'Construction Materials', 'change' => '+12%', 'up' => true, 'volume' => '2,340 orders', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008V7.5z', 'accent' => 'from-amber-500 to-orange-500', 'bg' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-600 dark:text-amber-400', 'bar' => 'w-[72%]'],
                    ['name' => 'Office IT Supplies', 'change' => '+8%', 'up' => true, 'volume' => '1,892 orders', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25', 'accent' => 'from-sky-500 to-blue-500', 'bg' => 'bg-sky-50 dark:bg-sky-900/20', 'text' => 'text-sky-600 dark:text-sky-400', 'bar' => 'w-[58%]'],
                    ['name' => 'PPE & Safety Gear', 'change' => '-4%', 'up' => false, 'volume' => '987 orders', 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'accent' => 'from-emerald-500 to-teal-500', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' => 'text-emerald-600 dark:text-emerald-400', 'bar' => 'w-[30%]'],
                    ['name' => 'Food & Bev Wholesale', 'change' => '+15%', 'up' => true, 'volume' => '1,456 orders', 'icon' => 'M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5', 'accent' => 'from-rose-500 to-pink-500', 'bg' => 'bg-rose-50 dark:bg-rose-900/20', 'text' => 'text-rose-600 dark:text-rose-400', 'bar' => 'w-[45%]'],
                ];
            @endphp
            @foreach ($trends as $trend)
                <div class="group relative bg-white dark:bg-slate-800/50 rounded-2xl p-5 border border-slate-100 dark:border-slate-700/50 hover:border-slate-200 dark:hover:border-slate-600 transition-all duration-300 card-hover cursor-pointer overflow-hidden">
                    {{-- Subtle gradient accent line at top --}}
                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r {{ $trend['accent'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="flex items-start justify-between mb-4">
                        <div class="h-12 w-12 rounded-xl {{ $trend['bg'] }} flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-5 h-5 {{ $trend['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $trend['icon'] }}" /></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-bold {{ $trend['up'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400' }}">
                            @if ($trend['up'])
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" /></svg>
                            @endif
                            {{ $trend['change'] }}
                        </span>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1 tracking-tight">{{ $trend['name'] }}</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-3">{{ $trend['volume'] }}</p>

                    {{-- Mini progress bar --}}
                    <div class="h-1 bg-slate-100 dark:bg-slate-700/50 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r {{ $trend['accent'] }} rounded-full {{ $trend['bar'] }} transition-all duration-500"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
