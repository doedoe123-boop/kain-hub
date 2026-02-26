<x-layouts.app>
    {{-- ============================================================
         TOP BAR: Search + Trust Signals (above the fold, discovery-first)
         ============================================================ --}}
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 -mt-8 bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                {{-- Headline + search --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-400 font-medium tracking-wide uppercase">Philippines B2B Marketplace</p>
                    <h1 class="mt-1 text-xl sm:text-2xl font-bold text-white leading-tight">Source verified suppliers and products</h1>
                    {{-- Search bar --}}
                    <div class="mt-4 flex max-w-xl">
                        <div class="relative flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" placeholder="Search products, suppliers, or categories..."
                                class="block w-full rounded-l-lg border-0 bg-slate-700/60 py-2.5 pl-10 pr-4 text-sm text-white placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-500">
                        </div>
                        <button class="rounded-r-lg bg-sky-600 px-5 text-sm font-semibold text-white hover:bg-sky-700 transition-colors">Search</button>
                    </div>
                </div>
                {{-- Trust counters --}}
                <div class="flex items-center gap-6 lg:gap-8 text-center shrink-0">
                    <div>
                        <p class="text-2xl font-bold text-white tabular-nums">{{ number_format(\App\Models\Store::where('status', 'approved')->count()) ?: '0' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Verified Suppliers</p>
                    </div>
                    <div class="h-8 w-px bg-slate-600"></div>
                    <div>
                        <p class="text-2xl font-bold text-white tabular-nums">{{ number_format(\App\Models\User::count()) ?: '0' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Registered Buyers</p>
                    </div>
                    <div class="h-8 w-px bg-slate-600"></div>
                    <div>
                        <p class="text-2xl font-bold text-white tabular-nums">PH</p>
                        <p class="text-xs text-slate-400 mt-0.5">Nationwide Coverage</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CATEGORY GRID (immediate discovery — no marketing fluff)
         ============================================================ --}}
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Browse by Industry</h2>
                <span class="text-xs text-slate-400">All categories</span>
            </div>
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                @php
                    $categories = [
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008V7.5z" />', 'label' => 'Construction'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />', 'label' => 'Chemicals'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H6.375c-.621 0-1.125-.504-1.125-1.125V14.25m0 0h13.5m-13.5 0V11.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v2.625m0 0h4.5V9.75a3 3 0 00-3-3h-1.5a3 3 0 00-3 3v4.5m4.5 0v-4.5" />', 'label' => 'Logistics'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />', 'label' => 'IT & Tech'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.379a48.474 48.474 0 00-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265z" />', 'label' => 'Food & Bev'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.645-5.645a3.563 3.563 0 114.95-4.95l.355.355a2.52 2.52 0 013.562 0l.354-.354a3.565 3.565 0 114.95 4.949L11.42 15.17zM14.176 9.824a.374.374 0 01-.53 0l-.354-.354a.375.375 0 01.53-.53l.353.354a.374.374 0 010 .53z" />', 'label' => 'Healthcare'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />', 'label' => 'Real Estate'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />', 'label' => 'Agriculture'],
                    ];
                @endphp
                @foreach ($categories as $cat)
                    <button class="group flex flex-col items-center gap-2 rounded-lg border border-slate-200 bg-white p-3 hover:border-sky-300 hover:bg-sky-50/50 transition-colors">
                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-slate-100 text-slate-500 group-hover:bg-sky-100 group-hover:text-sky-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">{!! $cat['icon'] !!}</svg>
                        </div>
                        <span class="text-xs font-medium text-slate-600 group-hover:text-sky-700 leading-tight text-center">{{ $cat['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ============================================================
         MAIN CONTENT: 2-column layout (sidebar filters + listings)
         ============================================================ --}}
    <div class="py-6 sm:py-8">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- LEFT SIDEBAR: Filters --}}
            <aside class="w-full lg:w-64 shrink-0 space-y-5">
                {{-- Verification Filter --}}
                <div class="bg-white rounded-lg border border-slate-200 p-4">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Supplier Status</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" checked class="rounded border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Verified Only
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            Trade Licensed
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            DTI/SEC Registered
                        </label>
                    </div>
                </div>

                {{-- Location Filter --}}
                <div class="bg-white rounded-lg border border-slate-200 p-4">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Location</h3>
                    <select class="block w-full rounded-md border-slate-200 text-sm text-slate-600 focus:border-sky-500 focus:ring-sky-500 py-2">
                        <option>All Regions</option>
                        <option>NCR — Metro Manila</option>
                        <option>Region III — Central Luzon</option>
                        <option>Region IV-A — CALABARZON</option>
                        <option>Region VII — Central Visayas</option>
                        <option>Region XI — Davao</option>
                    </select>
                </div>

                {{-- Minimum Order --}}
                <div class="bg-white rounded-lg border border-slate-200 p-4">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Min. Order Value</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5" checked>
                            Any
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            ₱5,000+
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            ₱25,000+
                        </label>
                        <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                            <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                            ₱100,000+
                        </label>
                    </div>
                </div>

                {{-- Sort --}}
                <div class="bg-white rounded-lg border border-slate-200 p-4">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Sort By</h3>
                    <select class="block w-full rounded-md border-slate-200 text-sm text-slate-600 focus:border-sky-500 focus:ring-sky-500 py-2">
                        <option>Relevance</option>
                        <option>Newest Listed</option>
                        <option>Most Verified</option>
                        <option>Alphabetical</option>
                    </select>
                </div>
            </aside>

            {{-- RIGHT: Supplier Listings --}}
            <div class="flex-1 min-w-0">
                {{-- Results header --}}
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-slate-500">
                        Showing <span class="font-semibold text-slate-700">{{ \App\Models\Store::where('status', 'approved')->count() }}</span> verified suppliers
                    </p>
                    <div class="flex items-center gap-2">
                        <button class="p-1.5 rounded border border-slate-200 text-slate-400 hover:text-slate-600 hover:border-slate-300" title="Grid view">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        </button>
                        <button class="p-1.5 rounded border border-sky-200 bg-sky-50 text-sky-600" title="List view">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                        </button>
                    </div>
                </div>

                {{-- Supplier Cards --}}
                <div class="space-y-3">
                    @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(10)->get() as $store)
                        <a href="{{ route('suppliers.show', $store->slug) }}" class="block bg-white rounded-lg border border-slate-200 p-4 sm:p-5 hover:border-sky-200 hover:shadow-sm transition-all group">
                            <div class="flex items-start gap-4">
                                {{-- Logo placeholder --}}
                                <div class="shrink-0 h-14 w-14 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center">
                                    <span class="text-lg font-bold text-slate-400">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-semibold text-slate-800 group-hover:text-sky-700 transition-colors truncate">{{ $store->name }}</h3>
                                        @if ($store->business_permit)
                                            <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                                Verified
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $store->description ?? 'Verified supplier on KainHub marketplace.' }}</p>
                                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-400">
                                        @if ($store->address)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                                {{ $store->address['city'] ?? 'Philippines' }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                            Joined {{ $store->created_at->format('M Y') }}
                                        </span>
                                        @if ($store->id_type)
                                            <span class="inline-flex items-center gap-1 text-emerald-600">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                                                ID Verified
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- Action --}}
                                <div class="shrink-0 hidden sm:flex flex-col items-end gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-md bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200 group-hover:bg-sky-100 transition-colors">
                                        View Profile
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        {{-- Empty state --}}
                        <div class="bg-white rounded-lg border border-dashed border-slate-300 p-12 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                            </svg>
                            <p class="mt-3 text-sm font-medium text-slate-600">No suppliers listed yet</p>
                            <p class="mt-1 text-xs text-slate-400">Be the first to register your business on the platform.</p>
                            @guest
                                <a href="{{ route('register.store-owner') }}" class="inline-flex items-center mt-4 px-4 py-2 text-xs font-semibold rounded-md text-white bg-sky-600 hover:bg-sky-700 transition-colors">
                                    Register as Supplier
                                </a>
                            @endguest
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         TRUST & COMPLIANCE STRIP
         ============================================================ --}}
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
            <div class="text-center mb-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Platform Compliance & Trust</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">KYC Verified</p>
                    <p class="text-[11px] text-slate-400">All suppliers undergo ID & document verification</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-sky-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">DTI/SEC Compliant</p>
                    <p class="text-[11px] text-slate-400">Business permits validated upon registration</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Secure Payments</p>
                    <p class="text-[11px] text-slate-400">Transactions protected with PCI-compliant gateways</p>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="h-10 w-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-violet-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Dashboard Analytics</p>
                    <p class="text-[11px] text-slate-400">Real-time order tracking and revenue reports</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CTA: Become a Supplier
         ============================================================ --}}
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div>
                    <h2 class="text-lg font-bold text-white">Register your business as a verified supplier</h2>
                    <p class="mt-1 text-sm text-slate-400">Submit your KYC documents and get listed within 3–5 business days. Free to register.</p>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                    @guest
                        <a href="{{ route('register.store-owner') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-lg text-slate-900 bg-white hover:bg-slate-100 shadow transition-colors">
                            Apply Now
                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                    @endguest
                    @auth
                        @if (auth()->user()->isStoreOwner() && auth()->user()->store?->isApproved())
                            <a href="/lunar"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-lg text-slate-900 bg-white hover:bg-slate-100 shadow transition-colors">
                                Supplier Dashboard
                            </a>
                        @elseif (auth()->user()->isAdmin())
                            <a href="/admin"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-lg text-slate-900 bg-white hover:bg-slate-100 shadow transition-colors">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
