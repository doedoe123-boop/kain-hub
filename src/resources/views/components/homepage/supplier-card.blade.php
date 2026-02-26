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
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
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
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                                    Verified
                                </span>
                            @endif
                            @if ($store->id_type)
                                <span class="hidden sm:inline-flex items-center gap-1 rounded-lg bg-sky-500/10 dark:bg-sky-500/15 px-2.5 py-1 text-[10px] font-bold text-sky-700 dark:text-sky-400 uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
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
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                        <button class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2.5 text-xs font-bold text-slate-900 shadow-lg shadow-amber-500/20 transition-all duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
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
                            <svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            {{ $store->address['city'] ?? 'Philippines' }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
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
