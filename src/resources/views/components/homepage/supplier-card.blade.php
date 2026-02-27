{{-- Rich Profile Supplier Card — premium procurement style --}}
@props(['store'])

<div class="card-premium bg-white dark:bg-slate-800/60 rounded-2xl border border-slate-100 dark:border-slate-700/40 group" id="supplier-card-{{ $store->id }}">
    <div class="p-5 sm:p-6">
        <div class="flex gap-5">
            {{-- Company Logo Area --}}
            <div class="shrink-0 flex flex-col items-center gap-3">
                <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 flex items-center justify-center group-hover:border-sky-200 dark:group-hover:border-sky-700 transition-colors duration-300 overflow-hidden">
                    @if ($store->logo)
                        <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="h-full w-full object-cover rounded-xl">
                    @else
                        <span class="text-lg font-extrabold text-slate-300 dark:text-slate-500 group-hover:text-sky-500 dark:group-hover:text-sky-400 transition-colors duration-300">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                    @endif
                </div>
                {{-- Verification indicator --}}
                @if ($store->business_permit)
                    <div class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/30 glow-ring">
                        <x-heroicon-s-check-badge class="w-3.5 h-3.5 text-white" />
                    </div>
                @endif
            </div>

            {{-- Main Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-sky-700 dark:group-hover:text-sky-400 transition-colors duration-200 truncate tracking-tight">{{ $store->name }}</h3>
                            {{-- Custom badge icons --}}
                            @if ($store->business_permit)
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/15 px-2.5 py-1 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">
                                    <x-heroicon-o-shield-check class="w-3 h-3" />
                                    Verified
                                </span>
                            @endif
                            @if ($store->id_type)
                                <span class="hidden sm:inline-flex items-center gap-1 rounded-lg bg-sky-500/10 dark:bg-sky-500/15 px-2.5 py-1 text-[10px] font-bold text-sky-700 dark:text-sky-400 uppercase tracking-wider">
                                    <x-heroicon-o-document-text class="w-3 h-3" />
                                    SEC/DTI
                                </span>
                            @endif
                        </div>
                        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ $store->description ?? 'Verified store on NegosyoHub. Browse their profile for products and details.' }}</p>
                    </div>

                    {{-- Hover-reveal Actions (desktop) --}}
                    <div class="card-actions shrink-0 hidden sm:flex flex-col gap-2">
                        <a href="{{ route('suppliers.show', $store->slug) }}" class="inline-flex items-center gap-2 rounded-xl bg-sky-600 hover:bg-sky-700 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-sky-600/20 transition-all duration-200">
                            View Profile
                            <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
                        </a>
                        <button class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2.5 text-xs font-bold text-slate-900 shadow-lg shadow-amber-500/20 transition-all duration-200">
                            <x-heroicon-o-chat-bubble-left-ellipsis class="w-3.5 h-3.5" />
                            Contact Seller
                        </button>
                    </div>
                </div>

                {{-- Mini Product Gallery --}}
                <div class="mt-3 flex gap-2">
                    @php
                        $productImages = [
                            'bg-gradient-to-br from-slate-100 to-slate-50 dark:from-slate-700 dark:to-slate-700/50',
                            'bg-gradient-to-br from-sky-50 to-slate-50 dark:from-sky-900/20 dark:to-slate-700/50',
                            'bg-gradient-to-br from-emerald-50 to-slate-50 dark:from-emerald-900/20 dark:to-slate-700/50',
                        ];
                        $productLabels = ['Product', 'Catalog', 'Service'];
                    @endphp
                    @foreach ($productImages as $idx => $bg)
                        <div class="product-thumb h-14 w-20 rounded-lg {{ $bg }} border border-slate-200/60 dark:border-slate-600/40 flex items-center justify-center overflow-hidden cursor-pointer">
                            <span class="text-[10px] font-semibold text-slate-300 dark:text-slate-600">{{ $productLabels[$idx] }}</span>
                        </div>
                    @endforeach
                    <div class="h-14 w-14 rounded-lg bg-slate-50 dark:bg-slate-700/30 border border-dashed border-slate-200 dark:border-slate-600/40 flex items-center justify-center cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                        <span class="text-xs font-bold text-slate-300 dark:text-slate-600">+</span>
                    </div>
                </div>

                {{-- Data row --}}
                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-400 dark:text-slate-500">
                    @if ($store->address)
                        <span class="inline-flex items-center gap-1.5">
                            <x-heroicon-o-map-pin class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" />
                            {{ $store->address['city'] ?? 'Philippines' }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5">
                        <x-heroicon-o-calendar-days class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" />
                        Since {{ $store->created_at->format('M Y') }}
                    </span>
                    <span class="text-slate-200 dark:text-slate-700">·</span>
                    <span>MOQ: Contact</span>
                    <span class="text-slate-200 dark:text-slate-700">·</span>
                    <span>Lead: 3–7 days</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile action footer --}}
    <div class="sm:hidden border-t border-slate-100 dark:border-slate-700/40 px-5 py-3 flex gap-2">
        <a href="{{ route('suppliers.show', $store->slug) }}" class="flex-1 text-center rounded-xl bg-sky-600 hover:bg-sky-700 px-3 py-2.5 text-xs font-bold text-white transition-colors">View Store</a>
        <button class="flex-1 text-center rounded-xl bg-amber-500 hover:bg-amber-600 px-3 py-2.5 text-xs font-bold text-slate-900 transition-colors">Contact Seller</button>
    </div>
</div>
