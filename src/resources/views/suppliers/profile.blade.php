<x-layouts.app :title="$store->name.' — NegosyoHub Store'">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-6 mt-4">
        <a href="{{ route('stores.index') }}" class="hover:text-slate-600 transition-colors">Stores</a>
        <span class="mx-1.5">/</span>
        <span class="text-slate-600">{{ $store->name }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ============================================================
             LEFT COLUMN: Main profile content
             ============================================================ --}}
        <div class="flex-1 min-w-0 space-y-6">

            {{-- Header Card --}}
            <div class="bg-white dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/40 p-6 sm:p-8">
                <div class="flex items-start gap-5">
                    {{-- Logo --}}
                    <div class="shrink-0 h-20 w-20 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center">
                        <span class="text-2xl font-bold text-slate-400">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                    </div>
                    {{-- Name + badges --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">{{ $store->name }}</h1>
                            @if ($store->business_permit)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    <x-heroicon-s-check-badge class="w-3 h-3" />
                                    Verified Store
                                </span>
                            @endif
                        </div>
                        @if ($store->description)
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $store->description }}</p>
                        @endif
                        <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-400">
                            @if ($store->address)
                                <span class="inline-flex items-center gap-1">
                                    <x-heroicon-o-map-pin class="w-3.5 h-3.5" />
                                    {{ $store->address['city'] ?? '' }}{{ isset($store->address['city']) && isset($store->address['postcode']) ? ', ' : '' }}{{ $store->address['postcode'] ?? '' }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1">
                                <x-heroicon-o-calendar-days class="w-3.5 h-3.5" />
                                Member since {{ $store->created_at->format('F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- About Section --}}
            <div class="bg-white dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/40 p-6 sm:p-8">
                <h2 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">About This Store</h2>
                @if ($store->description)
                    <div class="prose prose-sm prose-slate max-w-none">
                        <p>{{ $store->description }}</p>
                    </div>
                @else
                    <p class="text-sm text-slate-400 dark:text-slate-500 italic">This store has not provided a detailed description yet.</p>
                @endif
            </div>

            {{-- Business Location --}}
            @if ($store->address)
                <div class="bg-white dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/40 p-6 sm:p-8">
                    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Business Location</h2>
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 h-9 w-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                            <x-heroicon-o-map-pin class="w-4.5 h-4.5" />
                        </div>
                        <div>
                            @if (isset($store->address['line_one']))
                                <p class="text-sm text-slate-700">{{ $store->address['line_one'] }}</p>
                            @endif
                            <p class="text-sm text-slate-700">
                                {{ $store->address['city'] ?? '' }}{{ isset($store->address['postcode']) ? ', '.$store->address['postcode'] : '' }}
                            </p>
                            <p class="text-xs text-slate-400 mt-1">Philippines</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Products / Catalog Placeholder --}}
            <div class="bg-white rounded-lg border border-dashed border-slate-300 p-8 sm:p-10 text-center">
                <x-heroicon-o-archive-box class="mx-auto h-10 w-10 text-slate-300" />
                <p class="mt-3 text-sm font-medium text-slate-600">Product catalog coming soon</p>
                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">This store's products and services will be listed here.</p>
            </div>
        </div>

        {{-- ============================================================
             RIGHT SIDEBAR: Verification & quick info
             ============================================================ --}}
        <aside class="w-full lg:w-72 shrink-0 space-y-5">

            {{-- Verification Status --}}
            <div class="bg-white dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/40 p-5">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Verification Status</h3>
                <ul class="space-y-3">
                    {{-- Platform Approved --}}
                    <li class="flex items-center gap-2.5">
                        <div class="shrink-0 h-6 w-6 rounded-full bg-emerald-100 flex items-center justify-center">
                            <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-600" />
                        </div>
                        <span class="text-sm text-slate-700">Platform Approved</span>
                    </li>
                    {{-- ID Verified --}}
                    <li class="flex items-center gap-2.5">
                        @if ($store->id_type)
                            <div class="shrink-0 h-6 w-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-600" />
                            </div>
                            <span class="text-sm text-slate-700">Government ID Verified</span>
                        @else
                            <div class="shrink-0 h-6 w-6 rounded-full bg-slate-100 flex items-center justify-center">
                                <x-heroicon-o-clock class="w-3.5 h-3.5 text-slate-400" />
                            </div>
                            <span class="text-sm text-slate-400">ID Pending</span>
                        @endif
                    </li>
                    {{-- Business Permit --}}
                    <li class="flex items-center gap-2.5">
                        @if ($store->business_permit)
                            <div class="shrink-0 h-6 w-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                <x-heroicon-o-check class="w-3.5 h-3.5 text-emerald-600" />
                            </div>
                            <span class="text-sm text-slate-700">Business Permit Filed</span>
                        @else
                            <div class="shrink-0 h-6 w-6 rounded-full bg-slate-100 flex items-center justify-center">
                                <x-heroicon-o-clock class="w-3.5 h-3.5 text-slate-400" />
                            </div>
                            <span class="text-sm text-slate-400">Permit Pending</span>
                        @endif
                    </li>
                </ul>
            </div>

            {{-- Quick Facts --}}
            <div class="bg-white dark:bg-slate-800/60 rounded-lg border border-slate-200 dark:border-slate-700/40 p-5">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Quick Facts</h3>
                <dl class="space-y-3">
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-slate-500">Status</dt>
                        <dd>
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Active</span>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-slate-500">Joined</dt>
                        <dd class="text-xs font-medium text-slate-700">{{ $store->created_at->format('M d, Y') }}</dd>
                    </div>
                    @if ($store->address)
                        <div class="flex items-center justify-between">
                            <dt class="text-xs text-slate-500">Region</dt>
                            <dd class="text-xs font-medium text-slate-700">{{ $store->address['city'] ?? 'Philippines' }}</dd>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-slate-500">Orders</dt>
                        <dd class="text-xs font-medium text-slate-700">{{ $store->orders()->count() }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Contact / Inquiry CTA --}}
            <div class="bg-sky-50 dark:bg-sky-900/20 rounded-lg border border-sky-200 dark:border-sky-800/40 p-5 text-center">
                <h3 class="text-sm font-semibold text-sky-800 dark:text-sky-300">Interested in this store?</h3>
                <p class="mt-1 text-xs text-sky-600 dark:text-sky-400">Contact them to discuss orders, pricing, or other inquiries.</p>
                <button disabled class="mt-3 w-full inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-md text-white bg-sky-600 opacity-60 cursor-not-allowed">
                    <x-heroicon-o-envelope class="w-4 h-4 mr-1.5" />
                    Send Inquiry
                </button>
                <p class="mt-2 text-[10px] text-sky-500">Coming soon</p>
            </div>

            {{-- Back link --}}
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                <x-heroicon-o-arrow-left class="w-3.5 h-3.5" />
                Back to all stores
            </a>
        </aside>
    </div>

</x-layouts.app>
