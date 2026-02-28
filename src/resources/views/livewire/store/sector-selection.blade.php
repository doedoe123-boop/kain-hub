<div class="flex min-h-screen w-full">
    {{-- ===== Left Panel ===== --}}
    <aside class="hidden lg:flex flex-col w-72 xl:w-80 bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white px-8 py-10 flex-shrink-0">
        {{-- Logo --}}
        <a href="/" class="inline-flex items-center gap-3 mb-12 group">
            <div class="h-10 w-10 rounded-xl bg-indigo-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                <x-heroicon-o-building-storefront class="w-5 h-5 text-white" />
            </div>
            <span class="text-lg font-bold text-white">NegosyoHub</span>
        </a>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-white leading-tight">Become a Supplier</h1>
            <p class="mt-3 text-sm text-slate-400 leading-relaxed">Join hundreds of verified Filipino businesses on the marketplace.</p>

            {{-- Process steps preview --}}
            <div class="mt-10 space-y-5">
                @foreach ([
                    ['icon' => 'heroicon-s-squares-2x2', 'label' => 'Choose Your Industry', 'desc' => 'Select your business sector'],
                    ['icon' => 'heroicon-s-user', 'label' => 'Account Setup', 'desc' => 'Personal & login details'],
                    ['icon' => 'heroicon-s-building-storefront', 'label' => 'Store Details', 'desc' => 'Business name & description'],
                    ['icon' => 'heroicon-s-identification', 'label' => 'Verify Identity', 'desc' => 'Government-issued ID'],
                    ['icon' => 'heroicon-s-shield-check', 'label' => 'Compliance Docs', 'desc' => 'Required permits & licenses'],
                ] as $i => $item)
                    <div class="flex items-center gap-3.5">
                        <div class="flex-shrink-0 h-8 w-8 rounded-full {{ $i === 0 ? 'bg-indigo-500 shadow-lg shadow-indigo-500/30' : 'bg-slate-700' }} flex items-center justify-center">
                            @if($i === 0)
                                <x-dynamic-component :component="$item['icon']" class="w-4 h-4 text-white" />
                            @else
                                <span class="text-xs font-bold text-slate-400">{{ $i + 1 }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-semibold {{ $i === 0 ? 'text-white' : 'text-slate-400' }}">{{ $item['label'] }}</p>
                            <p class="text-[11px] text-slate-500">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-auto pt-8 border-t border-slate-700/50 space-y-2">
            <div class="flex items-center gap-2 text-slate-400">
                <x-heroicon-s-lock-closed class="w-4 h-4 text-emerald-400" />
                <p class="text-xs">AES-256-CBC encrypted storage</p>
            </div>
            <div class="flex items-center gap-2 text-slate-400">
                <x-heroicon-s-clock class="w-4 h-4 text-indigo-400" />
                <p class="text-xs">Review within 3–5 business days</p>
            </div>
        </div>
    </aside>

    {{-- ===== Right Panel ===== --}}
    <main class="flex-1 bg-slate-50 dark:bg-slate-900 px-5 sm:px-10 xl:px-16 py-10 flex flex-col">
        {{-- Mobile logo --}}
        <div class="lg:hidden flex items-center justify-between mb-8">
            <a href="/" class="inline-flex items-center gap-2.5">
                <div class="h-9 w-9 rounded-xl bg-indigo-500 flex items-center justify-center">
                    <x-heroicon-o-building-storefront class="w-4 h-4 text-white" />
                </div>
                <span class="font-bold text-slate-800 dark:text-white">NegosyoHub</span>
            </a>
        </div>

        {{-- Header --}}
        <div class="mb-8">
            <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Step 1 of 5</p>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Choose Your Industry</h2>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Select the sector that best describes your business. This helps tailor the registration to your needs.
            </p>
        </div>

        @error('sector')
            <div class="mb-6 flex items-center gap-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                <x-heroicon-s-exclamation-circle class="w-5 h-5 text-red-500 flex-shrink-0" />
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            </div>
        @enderror

        {{-- Sector Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 max-w-4xl">
            @foreach ($sectors as $sector)
                <button
                    wire:click="selectSector('{{ $sector->slug }}')"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-60 cursor-wait"
                    class="group relative flex flex-col items-center justify-center p-6 sm:p-8 bg-white dark:bg-slate-800/80 rounded-2xl border-2 border-slate-200 dark:border-slate-700 shadow-sm hover:border-indigo-500 hover:shadow-lg hover:shadow-indigo-500/10 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 cursor-pointer text-center"
                >
                    {{-- Dynamic icon from DB --}}
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/40 transition-colors duration-200 shadow-sm">
                        <x-dynamic-component :component="$sector->icon" class="w-7 h-7 text-slate-500 group-hover:text-indigo-600 transition-colors" />
                    </div>

                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-tight">
                        {{ $sector->name }}
                    </h3>
                    <p class="mt-1.5 text-[11px] text-slate-400 dark:text-slate-500 leading-relaxed hidden sm:block">
                        {{ $sector->description }}
                    </p>

                    {{-- Selection indicator --}}
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500 rounded-b-2xl scale-x-0 group-hover:scale-x-100 transition-transform duration-200 origin-left"></div>

                    {{-- Loading overlay --}}
                    <div wire:loading wire:target="selectSector('{{ $sector->slug }}')" class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-slate-800/80 rounded-2xl">
                        <svg class="w-5 h-5 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Legal footer --}}
        @php
            $legalLinks = \App\Models\LegalPage::published()
                ->whereIn('type', ['terms', 'privacy', 'store_agreement'])
                ->orderByRaw("CASE type WHEN 'terms' THEN 1 WHEN 'privacy' THEN 2 ELSE 3 END")
                ->get(['title', 'slug']);
        @endphp
        @if ($legalLinks->isNotEmpty())
            <div class="mt-auto pt-8 border-t border-slate-200 dark:border-slate-800">
                <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2">
                    @foreach ($legalLinks as $lp)
                        <a href="{{ route('legal.show', $lp->slug) }}"
                           target="_blank"
                           class="text-xs text-slate-400 hover:text-indigo-600 transition-colors">
                            {{ $lp->title }}
                        </a>
                    @endforeach
                </div>
                <p class="mt-3 text-center text-[11px] text-slate-400">© {{ date('Y') }} NegosyoHub. By registering you agree to our Terms &amp; Conditions and Privacy Policy.</p>
            </div>
        @endif
    </main>
</div>
