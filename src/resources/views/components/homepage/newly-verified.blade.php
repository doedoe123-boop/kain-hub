{{-- Newly Verified Suppliers — shows recent approvals --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Newly Verified Suppliers</h2>
            <a href="/" class="text-[11px] text-sky-600 hover:text-sky-700 font-medium transition-colors">View all</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(3)->get() as $store)
                <a href="{{ route('suppliers.show', $store->slug) }}" class="block bg-white border border-slate-200 p-3.5 hover:border-sky-300 transition-colors group">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 h-10 w-10 rounded-sm bg-slate-100 border border-slate-200 flex items-center justify-center">
                            <span class="text-sm font-bold text-slate-400">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5">
                                <h3 class="text-xs font-semibold text-slate-800 group-hover:text-sky-700 truncate transition-colors">{{ $store->name }}</h3>
                                @if ($store->business_permit)
                                    <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                @endif
                            </div>
                            <p class="mt-0.5 text-[11px] text-slate-500 line-clamp-1">{{ $store->description ?? 'Verified supplier' }}</p>
                            <div class="mt-1.5 flex flex-wrap items-center gap-2 text-[10px] text-slate-400">
                                @if ($store->address)
                                    <span>{{ $store->address['city'] ?? 'Philippines' }}</span>
                                    <span class="text-slate-200">|</span>
                                @endif
                                <span>Since {{ $store->created_at->format('M Y') }}</span>
                                @if ($store->id_type)
                                    <span class="text-slate-200">|</span>
                                    <span class="text-emerald-600">ID Verified</span>
                                @endif
                                @if ($store->business_permit)
                                    <span class="text-slate-200">|</span>
                                    <span class="text-sky-600">DTI/SEC</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-6 border border-dashed border-slate-300 bg-white text-xs text-slate-400">
                    No verified suppliers to display yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
