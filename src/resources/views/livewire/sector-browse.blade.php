<div>
    {{-- Premium Hero Section --}}
    <div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden">
        {{-- Decorative Background Gradients --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 hidden dark:block">
            <div class="absolute -top-1/2 left-1/4 w-[600px] h-[600px] bg-sky-500/10 rounded-full blur-[120px] mix-blend-screen"></div>
            <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-emerald-500/10 rounded-full blur-[100px] mix-blend-screen"></div>
        </div>

        {{-- Background Dot Pattern --}}
        <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.05] bg-[radial-gradient(#000_1px,transparent_1px)] dark:bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-6 shadow-sm">
                    <span class="text-[10px] font-bold text-sky-600 dark:text-sky-400 uppercase tracking-[0.15em]">Directory</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                    Enterprise Industry Sectors
                </h1>
                
                <p class="mt-5 text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto">
                    NegosyoHub connects verified B2B suppliers across {{ count($sectors) }} industry sectors in the Philippines.
                    Each sector has customized onboarding to ensure regulatory compliance.
                </p>
                
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                    <div class="flex items-center gap-2.5 px-4 py-2 bg-slate-50 dark:bg-slate-800/50 backdrop-blur-md rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                            <x-heroicon-s-check-badge class="w-5 h-5" />
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">{{ $totalSuppliers }} Verified</div>
                            <div class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">Suppliers</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 px-4 py-2 bg-slate-50 dark:bg-slate-800/50 backdrop-blur-md rounded-xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-sky-100 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400">
                            <x-heroicon-o-building-office class="w-5 h-5" />
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-slate-900 dark:text-white">{{ count($sectors) }} Sectors</div>
                            <div class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">Categories</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Premium Search Input --}}
            <div class="mt-10 max-w-xl mx-auto relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-sky-400 to-emerald-400 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-sky-500 transition-colors" />
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Search industries (e.g. food, construction, logistics...)"
                        class="w-full pl-12 pr-4 py-4 bg-white dark:bg-slate-900 border-0 rounded-xl text-base text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-sky-500 shadow-xl shadow-slate-200/50 dark:shadow-black/50 transition-all duration-300"
                    >
                </div>
            </div>
        </div>
    </div>

    {{-- Sector Cards Grid --}}
    <div class="bg-slate-50/50 dark:bg-[#060A13]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            @if (count($sectors) === 0)
                <div class="text-center py-20 bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 mb-4">
                        <x-heroicon-o-magnifying-glass class="w-8 h-8 text-slate-400 dark:text-slate-500" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No matching sectors</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">We couldn't find any sectors matching your search.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($sectors as $sector)
                        <div class="group flex flex-col bg-white dark:bg-slate-800/40 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden relative">
                            {{-- Top glowing accent bar --}}
                            <div class="absolute top-0 inset-x-0 h-1 bg-{{ $sector->color }}-500 opacity-80 group-hover:opacity-100 scale-x-95 group-hover:scale-x-100 transition-all duration-300"></div>

                            <div class="p-6 md:p-8 flex-1 flex flex-col relative z-10">
                                {{-- Header --}}
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="shrink-0 h-12 w-12 rounded-xl bg-{{ $sector->color }}-50 dark:bg-{{ $sector->color }}-500/10 border border-{{ $sector->color }}-100 dark:border-{{ $sector->color }}-500/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                                        <x-dynamic-component :component="$sector->icon" class="w-6 h-6 text-{{ $sector->color }}-600 dark:text-{{ $sector->color }}-400" />
                                    </div>
                                    <div class="min-w-0 pt-1">
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-{{ $sector->color }}-600 dark:group-hover:text-{{ $sector->color }}-300 transition-colors">
                                            {{ $sector->name }}
                                        </h3>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="inline-flex h-2 w-2 rounded-full bg-{{ $sector->color }}-500"></span>
                                            <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $sector->supplier_count }} {{ Str::plural('Supplier', $sector->supplier_count) }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-6 flex-1">
                                    {{ $sector->description }}
                                </p>

                                {{-- Compliance Module --}}
                                <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800 mb-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Compliance Checks</span>
                                        <div class="flex gap-2 text-[10px] font-semibold">
                                            <span class="text-slate-700 dark:text-slate-300">REQ: <span class="text-rose-500 dark:text-rose-400">{{ $sector->required_docs }}</span></span>
                                            @if ($sector->optional_docs > 0)
                                                <span class="text-slate-400">OPT: <span>{{ $sector->optional_docs }}</span></span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        @foreach ($sector->documents as $doc)
                                            <div class="flex items-start gap-2 text-xs">
                                                @if ($doc->is_required)
                                                    <x-heroicon-s-shield-exclamation class="w-4 h-4 text-rose-500 shrink-0" />
                                                    <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $doc->label }}</span>
                                                @else
                                                    <x-heroicon-o-document-text class="w-4 h-4 text-slate-400 shrink-0" />
                                                    <span class="text-slate-500 dark:text-slate-500">{{ $doc->label }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Interactive CTA --}}
                                <a href="{{ route('register.store-owner', ['sector' => $sector->slug]) }}"
                                   class="mt-auto relative inline-flex items-center justify-center w-full px-5 py-3 text-sm font-bold text-white bg-slate-900 dark:bg-slate-700 rounded-xl overflow-hidden group/btn shadow-sm hover:shadow-md transition-all">
                                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-{{ $sector->color }}-600 to-{{ $sector->color }}-500 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></span>
                                    <span class="relative z-10 flex items-center justify-center gap-2">
                                        {{ $sector->registration_button_text ?? 'Register as Provider' }}
                                        <x-heroicon-s-arrow-right class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" />
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Bottom Call to Action --}}
            <div class="mt-16 md:mt-24 relative rounded-3xl bg-slate-900 dark:bg-slate-800/80 border border-slate-800 dark:border-slate-700 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-r from-sky-500/10 to-emerald-500/10 mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] opacity-[0.03] [background-size:24px_24px]"></div>
                
                <div class="relative z-10 px-6 py-12 md:py-16 text-center max-w-2xl mx-auto">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 mb-6">
                        <x-heroicon-s-rocket-launch class="w-6 h-6" />
                    </div>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight leading-tight">Can't find your specific industry?</h3>
                    <p class="mt-4 text-slate-400 leading-relaxed max-w-lg mx-auto">
                        NegosyoHub is continuously expanding. Register your business profile and we'll notify you when specialized B2B categories open.
                    </p>
                    <a href="{{ route('register.sector') }}" class="mt-8 inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-slate-900 bg-white hover:bg-slate-100 rounded-xl shadow-lg shadow-black/20 hover:shadow-xl hover:shadow-white/20 transition-all duration-300 transform hover:-translate-y-0.5">
                        Start General Registration
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
