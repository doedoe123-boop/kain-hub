{{-- ============================================================
     FIRST VIEWPORT: Procurement Control Panel (3-panel)
     Left: Industry categories | Center: Search + quick filters | Right: RFQ + stats
     ============================================================ --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-900 border-b border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-5">

            {{-- LEFT PANEL: Industry categories --}}
            <div class="lg:col-span-3 hidden lg:block">
                <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Industry Sectors</h3>
                <nav class="space-y-0.5">
                    @php
                        $sectors = [
                            ['label' => 'Construction & Building', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008V7.5z'],
                            ['label' => 'IT & Technology', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25'],
                            ['label' => 'Food & Beverage', 'icon' => 'M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.379a48.474 48.474 0 00-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265z'],
                            ['label' => 'Healthcare & Pharma', 'icon' => 'M11.42 15.17l-5.645-5.645a3.563 3.563 0 114.95-4.95l.355.355a2.52 2.52 0 013.562 0l.354-.354a3.565 3.565 0 114.95 4.949L11.42 15.17zM14.176 9.824a.374.374 0 01-.53 0l-.354-.354a.375.375 0 01.53-.53l.353.354a.374.374 0 010 .53z'],
                            ['label' => 'Chemicals & Raw Materials', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                            ['label' => 'Logistics & Transport', 'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H6.375c-.621 0-1.125-.504-1.125-1.125V14.25m0 0h13.5m-13.5 0V11.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v2.625m0 0h4.5V9.75a3 3 0 00-3-3h-1.5a3 3 0 00-3 3v4.5m4.5 0v-4.5'],
                            ['label' => 'Real Estate & Property', 'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21'],
                            ['label' => 'Agriculture & Farming', 'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125'],
                        ];
                    @endphp
                    @foreach ($sectors as $sector)
                        <button class="w-full flex items-center gap-2.5 px-2.5 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800 rounded transition-colors text-left group">
                            <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-sky-400 shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sector['icon'] }}" /></svg>
                            {{ $sector['label'] }}
                        </button>
                    @endforeach
                </nav>
                <div class="mt-3 pt-3 border-t border-slate-800">
                    <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Government</h3>
                    <button class="w-full flex items-center gap-2.5 px-2.5 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800 rounded transition-colors text-left group">
                        <svg class="w-3.5 h-3.5 text-slate-600 group-hover:text-amber-400 shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>
                        PhilGEPS Compatible
                    </button>
                </div>
            </div>

            {{-- CENTER PANEL: Search + quick filters --}}
            <div class="lg:col-span-6">
                <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2">Philippines B2B Marketplace</p>
                <h1 class="text-base sm:text-lg font-bold text-white leading-tight">Source verified suppliers and products</h1>

                {{-- Search bar --}}
                <div class="mt-3 flex">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Search products, suppliers, SKUs..."
                            class="block w-full border-0 bg-slate-800 py-2 pl-9 pr-3 text-sm text-white placeholder:text-slate-500 ring-1 ring-inset ring-slate-700 focus:ring-2 focus:ring-sky-500 rounded-l">
                    </div>
                    <button class="bg-sky-600 px-4 text-xs font-semibold text-white hover:bg-sky-700 transition-colors rounded-r">Search</button>
                </div>

                {{-- Quick filter chips --}}
                <div class="mt-3 flex flex-wrap gap-1.5">
                    <button class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium bg-slate-800 text-emerald-400 ring-1 ring-emerald-700/50 rounded hover:bg-emerald-900/30 transition-colors">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Verified Only
                    </button>
                    <button class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium bg-slate-800 text-slate-400 ring-1 ring-slate-700 rounded hover:text-white hover:ring-slate-600 transition-colors">
                        PEZA Registered
                    </button>
                    <button class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium bg-slate-800 text-slate-400 ring-1 ring-slate-700 rounded hover:text-white hover:ring-slate-600 transition-colors">
                        BIR Compliant
                    </button>
                    <button class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium bg-slate-800 text-slate-400 ring-1 ring-slate-700 rounded hover:text-white hover:ring-slate-600 transition-colors">
                        ISO Certified
                    </button>
                    <button class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-medium bg-slate-800 text-slate-400 ring-1 ring-slate-700 rounded hover:text-white hover:ring-slate-600 transition-colors">
                        Metro Manila
                    </button>
                </div>

                {{-- Shortcut links --}}
                <div class="mt-3 flex items-center gap-3 text-[11px]">
                    <span class="text-slate-600">Quick:</span>
                    <a href="#" class="text-slate-400 hover:text-sky-400 transition-colors">Keyword Search</a>
                    <span class="text-slate-700">|</span>
                    <a href="#" class="text-slate-400 hover:text-sky-400 transition-colors">RFQ Shortcut</a>
                    <span class="text-slate-700">|</span>
                    <a href="#" class="text-slate-400 hover:text-sky-400 transition-colors">SKU Lookup</a>
                </div>
            </div>

            {{-- RIGHT PANEL: RFQ + stats --}}
            <div class="lg:col-span-3">
                {{-- Primary actions --}}
                <div class="space-y-2 mb-4">
                    <a href="#" class="block w-full text-center px-3 py-2 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded ring-1 ring-sky-500 transition-colors">
                        Post a Request for Quotation
                    </a>
                    <a href="/" class="block w-full text-center px-3 py-1.5 text-xs font-medium text-slate-300 bg-slate-800 hover:bg-slate-750 rounded ring-1 ring-slate-700 hover:ring-slate-600 transition-colors">
                        Browse Verified Suppliers
                    </a>
                </div>

                {{-- Live stats --}}
                <div class="bg-slate-800 rounded ring-1 ring-slate-700 p-3">
                    <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2.5">Platform Statistics</h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Verified Vendors</span>
                            <span class="text-xs font-bold text-white tabular-nums">{{ number_format(\App\Models\Store::where('status', 'approved')->count()) ?: '0' }}</span>
                        </div>
                        <div class="h-px bg-slate-700/60"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Registered Buyers</span>
                            <span class="text-xs font-bold text-white tabular-nums">{{ number_format(\App\Models\User::where('role', 'customer')->count()) ?: '0' }}</span>
                        </div>
                        <div class="h-px bg-slate-700/60"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Fulfillment Rate</span>
                            <span class="text-xs font-bold text-emerald-400 tabular-nums">98%</span>
                        </div>
                        <div class="h-px bg-slate-700/60"></div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Coverage</span>
                            <span class="text-xs font-bold text-white">Nationwide PH</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
