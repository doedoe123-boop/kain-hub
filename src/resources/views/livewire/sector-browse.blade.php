<div>
    {{-- Hero Section --}}
    <div class="bg-slate-800 border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-white tracking-tight">Industry Sectors</h1>
                <p class="mt-3 text-slate-400 text-sm leading-relaxed">
                    NegosyoHub connects verified B2B suppliers across {{ count($sectors) }} industry sectors in the Philippines.
                    Each sector has specific compliance requirements to ensure quality and trust.
                </p>
                <div class="mt-6 flex items-center justify-center gap-6 text-sm">
                    <div class="flex items-center gap-2 text-emerald-400">
                        <x-heroicon-s-check-badge class="w-4 h-4" />
                        <span>{{ $totalSuppliers }} Verified Suppliers</span>
                    </div>
                    <div class="flex items-center gap-2 text-sky-400">
                        <x-heroicon-o-building-office class="w-4 h-4" />
                        <span>{{ count($sectors) }} Sectors</span>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div class="mt-8 max-w-md mx-auto">
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" />
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Search industries (e.g. food, construction, logistics...)"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-700 border border-slate-600 rounded-lg text-sm text-white placeholder-slate-500 focus:border-sky-500 focus:ring-1 focus:ring-sky-500"
                    >
                </div>
            </div>
        </div>
    </div>

    {{-- Sector Cards --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if (count($sectors) === 0)
            <div class="text-center py-16">
                <x-heroicon-o-magnifying-glass class="mx-auto h-12 w-12 text-gray-300" />
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No matching sectors</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search query.</p>
            </div>
        @else
            <div class="flex flex-wrap justify-center gap-5">
                @foreach ($sectors as $sector)
                    <div class="w-full sm:w-[calc(50%-10px)] lg:max-w-md flex-1 group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-{{ $sector->color }}-300 transition-all duration-200 overflow-hidden flex flex-col">
                        {{-- Color Header Bar --}}
                        <div class="h-1.5 bg-{{ $sector->color }}-500"></div>

                        <div class="p-5 flex-1 flex flex-col">
                            {{-- Icon & Label --}}
                            <div class="flex items-start gap-3 mb-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-{{ $sector->color }}-50 flex items-center justify-center">
                                    <x-dynamic-component :component="$sector->icon" class="w-5 h-5 text-{{ $sector->color }}-600" />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-{{ $sector->color }}-700 transition-colors">
                                        {{ $sector->name }}
                                    </h3>
                                    <span class="text-xs text-gray-500">{{ $sector->supplier_count }} {{ Str::plural('supplier', $sector->supplier_count) }}</span>
                                </div>
                            </div>

                            {{-- Description --}}
                            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                {{ $sector->description }}
                            </p>

                            {{-- Compliance Summary --}}
                            <div class="border-t border-gray-100 pt-3 mb-4">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Compliance Requirements</p>
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="inline-flex items-center gap-1 text-red-600">
                                        <x-heroicon-s-check-circle class="w-3 h-3" />
                                        {{ $sector->required_docs }} required
                                    </span>
                                    @if ($sector->optional_docs > 0)
                                        <span class="inline-flex items-center gap-1 text-gray-400">
                                            <x-heroicon-s-check-circle class="w-3 h-3" />
                                            {{ $sector->optional_docs }} optional
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Required Document List --}}
                            <div class="space-y-1.5 mb-4">
                                @foreach ($sector->documents as $doc)
                                    <div class="flex items-start gap-1.5 text-xs">
                                        @if ($doc->is_required)
                                            <x-heroicon-s-check-circle class="w-3 h-3 text-red-500 mt-0.5 flex-shrink-0" />
                                        @else
                                            <x-heroicon-o-clock class="w-3 h-3 text-gray-300 mt-0.5 flex-shrink-0" />
                                        @endif
                                        <span class="{{ $doc->is_required ? 'text-gray-700' : 'text-gray-400' }}">{{ $doc->label }}</span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Action --}}
                            <a href="{{ route('register.store-owner', ['sector' => $sector->slug]) }}"
                               class="mt-auto block w-full text-center text-xs font-semibold py-2 rounded-lg border border-{{ $sector->color }}-200 text-{{ $sector->color }}-700 hover:bg-{{ $sector->color }}-50 transition-colors">
                                {{ $sector->registration_button_text ?? 'Register as Supplier' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-12 text-center bg-slate-50 border border-slate-200 rounded-xl p-8">
            <h3 class="text-lg font-bold text-gray-900">Ready to become a verified supplier?</h3>
            <p class="mt-2 text-sm text-gray-500 max-w-lg mx-auto">
                Join NegosyoHub's B2B marketplace. Select your industry sector, upload your compliance documents, and start receiving orders from verified buyers.
            </p>
            <a href="{{ route('register.sector') }}"
               class="mt-5 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-sky-600 rounded-lg hover:bg-sky-700 transition-colors">
                Start Registration
                <x-heroicon-o-arrow-right class="w-4 h-4 ml-2" />
            </a>
        </div>
    </div>
</div>
