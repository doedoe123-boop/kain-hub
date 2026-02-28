<x-layouts.app :title="$store->name.' — NegosyoHub Store'">

    {{-- Premium Hero Section for Profile --}}
    <div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden">
        {{-- Decorative Background Gradients --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 hidden dark:block">
            @php
                // Generate a consistent gradient color based on store name length or ID
                $colors = ['sky', 'emerald', 'amber', 'violet', 'rose'];
                $themeColor = $colors[$store->id % count($colors)] ?? 'sky';
            @endphp
            <div class="absolute -top-1/4 right-0 w-[500px] h-[500px] bg-{{ $themeColor }}-500/10 rounded-full blur-[100px] mix-blend-screen opacity-50"></div>
        </div>

        {{-- Background Pattern --}}
        <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.05] bg-[radial-gradient(#000_1px,transparent_1px)] dark:bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-8">
                <a href="{{ route('stores.index') }}" class="hover:text-{{ $themeColor }}-500 dark:hover:text-{{ $themeColor }}-400 transition-colors">Stores Directory</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200">{{ Str::limit($store->name, 30) }}</span>
            </nav>

            <div class="flex flex-col md:flex-row gap-8 items-start md:items-center justify-between">
                <div class="flex items-center gap-6">
                    {{-- Premium Logo Box --}}
                    <div class="shrink-0 relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-br from-{{ $themeColor }}-400 to-{{ $themeColor }}-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                        <div class="relative h-24 w-24 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-lg transform group-hover:scale-105 transition duration-500">
                            <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-br from-slate-400 to-slate-600 dark:from-slate-300 dark:to-slate-500">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                        </div>
                    </div>
                    
                    {{-- Name + badges --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ $store->name }}</h1>
                            @if ($store->business_permit)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 shadow-sm">
                                    <x-heroicon-s-shield-check class="w-3.5 h-3.5" />
                                    Verified Enterprise
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3 mt-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
                            @if ($store->address)
                                <span class="inline-flex items-center gap-1.5 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                                    <x-heroicon-o-map-pin class="w-4 h-4 text-slate-400 dark:text-slate-500" />
                                    {{ $store->address['city'] ?? '' }}{{ isset($store->address['city']) && isset($store->address['postcode']) ? ', ' : '' }}{{ $store->address['postcode'] ?? '' }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 opacity-80">
                                <x-heroicon-o-calendar-days class="w-4 h-4 text-slate-400 dark:text-slate-500" />
                                Member since {{ $store->created_at->format('F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50/50 dark:bg-[#060A13] pb-20">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- ============================================================
                     LEFT COLUMN: Main profile content
                     ============================================================ --}}
                <div class="flex-1 min-w-0 space-y-8">

                    {{-- About Section --}}
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 sm:p-10 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-{{ $themeColor }}-400 to-{{ $themeColor }}-600 opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <h2 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-6 flex items-center gap-2">
                            <x-heroicon-o-building-office-2 class="w-5 h-5 text-{{ $themeColor }}-500" />
                            About the Enterprise
                        </h2>
                        
                        @if ($store->description)
                            <div class="prose prose-sm prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                                <p>{{ $store->description }}</p>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-8 text-center bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/50">
                                <x-heroicon-o-document-text class="w-8 h-8 text-slate-300 dark:text-slate-600 mb-3" />
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Enterprise profile details pending.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Products / Catalog Placeholder --}}
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-10 sm:p-16 text-center shadow-sm relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-{{ $themeColor }}-500/5 mix-blend-overlay"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 mb-6 group-hover:scale-110 transition-transform duration-500 shadow-inner">
                                <x-heroicon-o-archive-box class="w-10 h-10 text-slate-400 dark:text-slate-500" />
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Product Catalog Integration Network</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto leading-relaxed">This supplier's extensive inventory and specialized B2B service offerings are currently being localized and will be listed here shortly.</p>
                            
                            <button disabled class="mt-8 px-8 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-sm font-bold text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-700 cursor-not-allowed">
                                View Full Inventory (Coming Soon)
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ============================================================
                     RIGHT SIDEBAR: Verification & quick info
                     ============================================================ --}}
                <aside class="w-full lg:w-80 shrink-0 space-y-6">

                    {{-- Contact / Inquiry CTA --}}
                    <div class="relative bg-gradient-to-br from-{{ $themeColor }}-600 to-{{ $themeColor }}-700 rounded-3xl p-8 overflow-hidden shadow-xl shadow-{{ $themeColor }}-500/10">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyem0wLTE4VjE0SDI0VjE2aDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-20"></div>
                        
                        <div class="relative z-10 text-center">
                            <h3 class="text-xl font-bold text-white mb-2">Interested in negotiating?</h3>
                            <p class="text-sm text-white/80 leading-relaxed mb-6 font-medium">Initiate secure B2B contact to discuss high-volume orders, corporate pricing, or bespoke logistics.</p>
                            <button disabled class="w-full inline-flex items-center justify-center px-6 py-4 text-sm font-extrabold rounded-xl text-{{ $themeColor }}-900 bg-white hover:bg-slate-50 opacity-90 cursor-not-allowed transition-all">
                                <x-heroicon-s-envelope class="w-5 h-5 mr-2" />
                                Initiate Secure Inquiry
                            </button>
                            <p class="mt-4 text-[11px] font-bold text-white/60 uppercase tracking-widest">Feature unlocking soon</p>
                        </div>
                    </div>

                    {{-- Market Verification Matrix --}}
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-6 shadow-sm">
                        <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-6 flex items-center gap-2">
                            <x-heroicon-s-shield-check class="w-4 h-4 text-emerald-500" />
                            KYC Assessment Matrix
                        </h3>
                        
                        <div class="space-y-4">
                            {{-- Platform Approved --}}
                            <div class="group flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 hover:border-emerald-200 dark:hover:border-emerald-500/30 transition-colors">
                                <div class="shrink-0 h-8 w-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">
                                    <x-heroicon-s-check-circle class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-none mb-1">Platform Approved</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-500 uppercase tracking-widest">Stage 1 Cleared</p>
                                </div>
                            </div>

                            {{-- ID Verified --}}
                            <div class="group flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 {{ $store->id_type ? 'hover:border-emerald-200 dark:hover:border-emerald-500/30' : 'hover:border-amber-200 dark:hover:border-amber-500/30' }} transition-colors">
                                @if ($store->id_type)
                                    <div class="shrink-0 h-8 w-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-none mb-1">Corporate ID Verified</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-500 uppercase tracking-widest">Stage 2 Cleared</p>
                                    </div>
                                @else
                                    <div class="shrink-0 h-8 w-8 rounded-lg bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                                        <x-heroicon-o-clock class="w-5 h-5 text-amber-600 dark:text-amber-500" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-300 leading-none mb-1">ID Processing</p>
                                        <p class="text-[10px] text-amber-500 uppercase tracking-widest">Stage 2 Pending</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Business Permit --}}
                            <div class="group flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 {{ $store->business_permit ? 'hover:border-emerald-200 dark:hover:border-emerald-500/30' : 'hover:border-amber-200 dark:hover:border-amber-500/30' }} transition-colors">
                                @if ($store->business_permit)
                                    <div class="shrink-0 h-8 w-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-none mb-1">Operating License Valid</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-500 uppercase tracking-widest">Stage 3 Cleared</p>
                                    </div>
                                @else
                                    <div class="shrink-0 h-8 w-8 rounded-lg bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                                        <x-heroicon-o-clock class="w-5 h-5 text-amber-600 dark:text-amber-500" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-300 leading-none mb-1">License Review</p>
                                        <p class="text-[10px] text-amber-500 uppercase tracking-widest">Stage 3 Pending</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Telemetry Data --}}
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-6 shadow-sm">
                        <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-5 flex items-center gap-2">
                            <x-heroicon-o-chart-bar class="w-4 h-4 text-slate-400" />
                            Store Telemetry
                        </h3>
                        <dl class="space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400">Current Status</dt>
                                <dd>
                                    <span class="relative flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20">
                                        <span class="relative flex h-1.5 w-1.5">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                        </span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700 dark:text-emerald-400">Online & Active</span>
                                    </span>
                                </dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-700/50 pt-4">
                                <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400">Network Join Date</dt>
                                <dd class="text-xs font-bold text-slate-900 dark:text-white">{{ $store->created_at->format('M d, Y') }}</dd>
                            </div>
                            @if ($store->address)
                                <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-700/50 pt-4">
                                    <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400">Logistics Hub</dt>
                                    <dd class="text-xs font-bold text-slate-900 dark:text-white">{{ $store->address['city'] ?? 'Philippines' }}</dd>
                                </div>
                            @endif
                            <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-700/50 pt-4">
                                <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400">Transactions Count</dt>
                                <dd class="text-xs font-black text-slate-900 dark:text-white">{{ number_format($store->orders()->count()) }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Back link --}}
                    <div class="text-center pt-2">
                        <a href="{{ route('stores.index') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors py-2 px-4 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                            <x-heroicon-o-arrow-left class="w-4 h-4" />
                            Return to Enterprise Directory
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>

</x-layouts.app>
