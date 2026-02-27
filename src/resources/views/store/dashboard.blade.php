<x-layouts.app>
    <div class="py-6 animate-fade-in-up">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-none border border-slate-200 dark:border-slate-700 p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="h-10 w-10 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center">
                    <x-heroicon-o-presentation-chart-bar class="w-5 h-5 text-white" />
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800 dark:text-white">Store Dashboard</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Welcome back, {{ auth()->user()->name }}!</p>
                </div>
            </div>

            @if (auth()->user()->store)
                <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-5 border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-800 dark:text-white">{{ auth()->user()->store->name }}</h2>
                        <span @class([
                            'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold',
                            'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 ring-1 ring-inset ring-amber-200 dark:ring-amber-700' => auth()->user()->store->status->value === 'pending',
                            'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 ring-1 ring-inset ring-emerald-200 dark:ring-emerald-700' => auth()->user()->store->status->value === 'approved',
                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-inset ring-red-200 dark:ring-red-700' => auth()->user()->store->status->value === 'suspended',
                        ])>
                            @if (auth()->user()->store->status->value === 'approved')
                                <x-heroicon-s-check-badge class="w-3.5 h-3.5" />
                            @endif
                            {{ ucfirst(auth()->user()->store->status->value) }}
                        </span>
                    </div>

                    <div class="mt-4 bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2">Your Store Login URL</p>
                        @php
                            $storeUrl = auth()->user()->store->slug . '.' . config('app.domain');
                            $port = parse_url(config('app.url'), PHP_URL_PORT);
                            if ($port) { $storeUrl .= ':' . $port; }
                        @endphp
                        <div class="flex items-center gap-2">
                            <code class="text-sm font-mono text-sky-600 dark:text-sky-400 bg-sky-50 dark:bg-sky-900/20 px-3 py-1.5 rounded-lg flex-1">{{ $storeUrl }}/login</code>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-sky-50 dark:bg-sky-900/20 rounded-xl p-5 border border-sky-100 dark:border-sky-800 flex items-start gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-sky-500 dark:text-sky-400 shrink-0 mt-0.5" />
                    <p class="text-sm text-sky-700 dark:text-sky-300">You don't have a store yet. Store registration will be available soon.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
