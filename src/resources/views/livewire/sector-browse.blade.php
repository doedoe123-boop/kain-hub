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
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                        <span>{{ $totalSuppliers }} Verified Suppliers</span>
                    </div>
                    <div class="flex items-center gap-2 text-sky-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                        <span>{{ count($sectors) }} Sectors</span>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div class="mt-8 max-w-md mx-auto">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
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
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No matching sectors</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search query.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ($sectors as $item)
                    @php $sector = $item['sector']; @endphp
                    <div class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-{{ $sector->color() }}-300 transition-all duration-200 overflow-hidden">
                        {{-- Color Header Bar --}}
                        <div class="h-1.5 bg-{{ $sector->color() }}-500"></div>

                        <div class="p-5">
                            {{-- Icon & Label --}}
                            <div class="flex items-start gap-3 mb-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-{{ $sector->color() }}-50 flex items-center justify-center">
                                    @switch($sector)
                                        @case(App\IndustrySector::Construction)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" /></svg>
                                            @break
                                        @case(App\IndustrySector::Technology)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z" /></svg>
                                            @break
                                        @case(App\IndustrySector::FoodAndBeverage)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.126-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265z" /></svg>
                                            @break
                                        @case(App\IndustrySector::Healthcare)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                                            @break
                                        @case(App\IndustrySector::Chemicals)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>
                                            @break
                                        @case(App\IndustrySector::Logistics)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                                            @break
                                        @case(App\IndustrySector::RealEstate)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" /></svg>
                                            @break
                                        @case(App\IndustrySector::Agriculture)
                                            <svg class="w-5 h-5 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                                            @break
                                    @endswitch
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-{{ $sector->color() }}-700 transition-colors">
                                        {{ $sector->label() }}
                                    </h3>
                                    <span class="text-xs text-gray-500">{{ $item['count'] }} {{ Str::plural('supplier', $item['count']) }}</span>
                                </div>
                            </div>

                            {{-- Description --}}
                            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                                {{ $sector->description() }}
                            </p>

                            {{-- Compliance Summary --}}
                            <div class="border-t border-gray-100 pt-3 mb-4">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Compliance Requirements</p>
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="inline-flex items-center gap-1 text-red-600">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                        {{ $item['requiredDocs'] }} required
                                    </span>
                                    @if ($item['optionalDocs'] > 0)
                                        <span class="inline-flex items-center gap-1 text-gray-400">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                            {{ $item['optionalDocs'] }} optional
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Required Document List --}}
                            <div class="space-y-1.5 mb-4">
                                @foreach ($sector->requiredDocuments() as $doc)
                                    <div class="flex items-start gap-1.5 text-xs">
                                        @if ($doc['required'])
                                            <svg class="w-3 h-3 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                        @else
                                            <svg class="w-3 h-3 text-gray-300 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        @endif
                                        <span class="{{ $doc['required'] ? 'text-gray-700' : 'text-gray-400' }}">{{ $doc['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Action --}}
                            <a href="{{ route('register.store-owner', ['sector' => $sector->value]) }}"
                               class="block w-full text-center text-xs font-semibold py-2 rounded-lg border border-{{ $sector->color() }}-200 text-{{ $sector->color() }}-700 hover:bg-{{ $sector->color() }}-50 transition-colors">
                                Register as Supplier
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
                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>
</div>
