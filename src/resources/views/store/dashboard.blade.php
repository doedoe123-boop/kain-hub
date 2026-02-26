<x-layouts.app>
    <div class="py-6 animate-fade-in-up">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-none border border-slate-200 dark:border-slate-700 p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-5">
                <div class="h-10 w-10 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                    </svg>
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
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
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
                    <svg class="w-5 h-5 text-sky-500 dark:text-sky-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <p class="text-sm text-sky-700 dark:text-sky-300">You don't have a store yet. Store registration will be available soon.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
