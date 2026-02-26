{{-- Supplier card component — data-dense procurement style --}}
@props(['store'])

<a href="{{ route('suppliers.show', $store->slug) }}" class="block bg-white border border-slate-200 p-3.5 hover:border-sky-300 transition-all group">
    <div class="flex items-start gap-3">
        {{-- Logo --}}
        <div class="shrink-0 h-11 w-11 rounded bg-slate-100 border border-slate-200 flex items-center justify-center">
            <span class="text-sm font-bold text-slate-400">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-1.5">
                <h3 class="text-sm font-semibold text-slate-800 group-hover:text-sky-700 transition-colors truncate">{{ $store->name }}</h3>
                @if ($store->business_permit)
                    <span class="inline-flex items-center gap-0.5 rounded-sm bg-emerald-50 px-1.5 py-px text-[10px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        Verified
                    </span>
                @endif
                @if ($store->id_type)
                    <span class="hidden sm:inline-flex items-center gap-0.5 rounded-sm bg-sky-50 px-1.5 py-px text-[10px] font-semibold text-sky-700 ring-1 ring-inset ring-sky-200">SEC/DTI</span>
                @endif
            </div>
            <p class="mt-0.5 text-xs text-slate-500 line-clamp-1">{{ $store->description ?? 'Verified supplier on NegosyoHub marketplace.' }}</p>

            {{-- Data row --}}
            <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-[11px] text-slate-400">
                @if ($store->address)
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                        {{ $store->address['city'] ?? 'Philippines' }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    {{ $store->created_at->format('M Y') }}
                </span>
                @if ($store->id_type)
                    <span class="inline-flex items-center gap-1 text-emerald-600">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                        ID Verified
                    </span>
                @endif
                @if ($store->business_permit)
                    <span class="inline-flex items-center gap-1 text-sky-600">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        BIR VAT
                    </span>
                @endif
                <span class="text-slate-300">|</span>
                <span>MOQ: Contact</span>
                <span class="text-slate-300">|</span>
                <span>Lead: 3–7 days</span>
            </div>
        </div>

        {{-- Action --}}
        <div class="shrink-0 hidden sm:flex flex-col items-end gap-1.5">
            <span class="inline-flex items-center gap-1 rounded-sm bg-sky-50 px-2.5 py-1 text-[11px] font-semibold text-sky-700 ring-1 ring-inset ring-sky-200 group-hover:bg-sky-100 transition-colors">
                View Profile
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </span>
            <span class="text-[10px] text-slate-400">Request Quote</span>
        </div>
    </div>
</a>
