{{-- Newly Verified Suppliers — shows recent approvals --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-gray-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Newly Verified Stores</h2>
            <a href="{{ route('stores.index') }}" class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-medium transition-colors duration-200 inline-flex items-center gap-1">
                View all
                <x-heroicon-o-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(3)->get() as $store)
                <a href="{{ route('suppliers.show', $store->slug) }}" class="block bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-5 hover:border-sky-300 dark:hover:border-sky-600 hover:shadow-md dark:hover:shadow-none transition-all duration-300 card-hover group">
                    <div class="flex items-start gap-3.5">
                        <div class="shrink-0 h-12 w-12 rounded-xl bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center group-hover:bg-sky-50 dark:group-hover:bg-sky-900/30 transition-colors duration-300">
                            <span class="text-sm font-bold text-slate-400 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors duration-300">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200 group-hover:text-sky-700 dark:group-hover:text-sky-400 truncate transition-colors duration-200">{{ $store->name }}</h3>
                                @if ($store->business_permit)
                                    <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-500 shrink-0" />
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 line-clamp-1">{{ $store->description ?? 'Verified supplier' }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-400 dark:text-slate-500">
                                @if ($store->address)
                                    <span>{{ $store->address['city'] ?? 'Philippines' }}</span>
                                    <span class="text-slate-200 dark:text-slate-700">·</span>
                                @endif
                                <span>Since {{ $store->created_at->format('M Y') }}</span>
                                @if ($store->id_type)
                                    <span class="text-slate-200 dark:text-slate-700">·</span>
                                    <span class="text-emerald-600 dark:text-emerald-400 font-medium">ID Verified</span>
                                @endif
                                @if ($store->business_permit)
                                    <span class="text-slate-200 dark:text-slate-700">·</span>
                                    <span class="text-sky-600 dark:text-sky-400 font-medium">DTI/SEC</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-10 border border-dashed border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-sm text-slate-400 dark:text-slate-500">
                    No verified suppliers to display yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
