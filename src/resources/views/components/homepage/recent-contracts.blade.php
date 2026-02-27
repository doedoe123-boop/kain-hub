{{-- Recently Awarded Contracts — Live Activity Feed --}}
<div class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60" id="recent-contracts">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Left: Header + ticker --}}
            <div class="lg:col-span-3">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Recent Sales Activity</h2>
                    </div>
                </div>

                {{-- Activity feed --}}
                <div class="space-y-0 rounded-2xl border border-slate-100 dark:border-slate-700/40 overflow-hidden bg-white dark:bg-slate-800/30">
                    @php
                        $contracts = [
                            ['category' => 'Office IT Equipment', 'supplier' => 'TechSource Manila', 'region' => 'NCR', 'value' => '₱12,500', 'verified' => true, 'time' => '2 min ago', 'new' => true],
                            ['category' => 'Construction Materials', 'supplier' => 'BuildRight Corp', 'region' => 'Central Luzon', 'value' => '₱34,800', 'verified' => true, 'time' => '8 min ago', 'new' => true],
                            ['category' => 'PPE & Safety Gear', 'supplier' => 'SafeGuard PH', 'region' => 'CALABARZON', 'value' => '₱5,200', 'verified' => false, 'time' => '15 min ago', 'new' => true],
                            ['category' => 'Food & Bev Wholesale', 'supplier' => 'FreshHub Trading', 'region' => 'Central Visayas', 'value' => '₱8,900', 'verified' => true, 'time' => '32 min ago', 'new' => false],
                            ['category' => 'Janitorial Supplies', 'supplier' => 'CleanPro Inc', 'region' => 'NCR', 'value' => '₱2,350', 'verified' => true, 'time' => '1 hr ago', 'new' => false],
                            ['category' => 'Industrial Chemicals', 'supplier' => 'ChemWorks PH', 'region' => 'CALABARZON', 'value' => '₱15,600', 'verified' => true, 'time' => '2 hr ago', 'new' => false],
                        ];
                    @endphp
                    @foreach ($contracts as $idx => $c)
                        <div class="feed-item flex items-center gap-4 px-5 py-4 {{ !$loop->last ? 'border-b border-slate-50 dark:border-slate-700/30' : '' }}">
                            {{-- Pulsing green dot for new --}}
                            <div class="shrink-0 w-5 flex justify-center">
                                @if ($c['new'])
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                @else
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></span>
                                @endif
                            </div>

                            {{-- Category icon --}}
                            <div class="shrink-0 h-10 w-10 rounded-xl bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center">
                                <x-heroicon-o-clipboard-document-list class="w-4.5 h-4.5 text-slate-400 dark:text-slate-500" />
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $c['category'] }}</span>
                                    <span class="text-xs text-slate-400 dark:text-slate-600">→</span>
                                    <span class="text-sm text-slate-600 dark:text-slate-400 truncate">{{ $c['supplier'] }}</span>
                                    @if ($c['verified'])
                                        <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500 shrink-0" />
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                    <span>{{ $c['region'] }}</span>
                                    <span class="text-slate-200 dark:text-slate-700">·</span>
                                    <span>{{ $c['time'] }}</span>
                                </div>
                            </div>

                            {{-- Value --}}
                            <div class="shrink-0 text-right">
                                <span class="text-sm font-extrabold text-slate-900 dark:text-white tabular-nums">{{ $c['value'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-xs text-slate-400 dark:text-slate-600 italic">Sample data. Actual sales will be populated as transactions are processed.</p>
            </div>

            {{-- Right: Newly verified + CTA --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Newly Verified --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Newly Verified</h3>
                        <a href="{{ route('stores.index') }}" class="text-xs text-sky-600 dark:text-sky-400 hover:text-sky-700 font-semibold transition-colors inline-flex items-center gap-1">
                            View all
                            <x-heroicon-o-arrow-right class="w-3 h-3" />
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(3)->get() as $store)
                            <a href="{{ route('suppliers.show', $store->slug) }}" class="flex items-center gap-3.5 p-3.5 bg-white dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/40 rounded-xl hover:border-sky-200 dark:hover:border-sky-700 transition-all duration-300 card-hover group">
                                <div class="shrink-0 h-11 w-11 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 flex items-center justify-center group-hover:border-sky-200 dark:group-hover:border-sky-700 transition-colors">
                                    <span class="text-xs font-extrabold text-slate-300 dark:text-slate-500 group-hover:text-sky-500 dark:group-hover:text-sky-400 transition-colors">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-sky-700 dark:group-hover:text-sky-400 truncate transition-colors">{{ $store->name }}</h4>
                                        @if ($store->business_permit)
                                            <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500 shrink-0" />
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                        @if ($store->address)
                                            <span>{{ $store->address['city'] ?? 'Philippines' }}</span>
                                            <span class="text-slate-200 dark:text-slate-700">·</span>
                                        @endif
                                        <span>Since {{ $store->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 border border-dashed border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-400 dark:text-slate-500">
                                No verified suppliers to display yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- RFQ CTA --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-600 to-sky-800 dark:from-sky-700 dark:to-sky-900 p-6 shadow-xl shadow-sky-600/10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-12 translate-x-12"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-10 -translate-x-10"></div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-bold text-sky-200 uppercase tracking-[0.15em] mb-2">Need Something?</p>
                        <h3 class="text-base font-extrabold text-white tracking-tight mb-2">Browse verified stores and find the best deals</h3>
                        <p class="text-sm text-sky-200/80 leading-relaxed mb-4">Discover trusted sellers with competitive prices and fast delivery across the Philippines.</p>
                        <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-sky-700 bg-white hover:bg-sky-50 rounded-xl shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                            Browse Stores
                            <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
