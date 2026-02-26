<div>
    {{-- Header --}}
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-gray-900">Choose Your Industry</h2>
        <p class="mt-2 text-sm text-gray-500 max-w-lg mx-auto">
            Select the sector that best describes your business. This helps us tailor the registration process and features to your needs.
        </p>
    </div>

    @error('sector')
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-center">
            <p class="text-sm text-red-600">{{ $message }}</p>
        </div>
    @enderror

    {{-- Sector Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($sectors as $sector)
            <button
                wire:click="selectSector('{{ $sector->value }}')"
                wire:loading.attr="disabled"
                class="group relative flex flex-col items-center p-6 bg-white rounded-xl border-2 border-gray-200 shadow-sm hover:border-indigo-500 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 cursor-pointer"
            >
                {{-- Icon --}}
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-{{ $sector->color() }}-50 group-hover:bg-{{ $sector->color() }}-100 transition-colors duration-200">
                    @switch($sector)
                        @case(App\IndustrySector::Construction)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
                            </svg>
                            @break
                        @case(App\IndustrySector::Technology)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z" />
                            </svg>
                            @break
                        @case(App\IndustrySector::FoodAndBeverage)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.126-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265z" />
                            </svg>
                            @break
                        @case(App\IndustrySector::Healthcare)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            @break
                        @case(App\IndustrySector::Chemicals)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                            @break
                        @case(App\IndustrySector::Logistics)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            @break
                        @case(App\IndustrySector::RealEstate)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                            </svg>
                            @break
                        @case(App\IndustrySector::Agriculture)
                            <svg class="w-7 h-7 text-{{ $sector->color() }}-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            @break
                    @endswitch
                </div>

                {{-- Label --}}
                <h3 class="text-sm font-semibold text-gray-900 text-center group-hover:text-indigo-600 transition-colors">
                    {{ $sector->label() }}
                </h3>

                {{-- Description --}}
                <p class="mt-1.5 text-xs text-gray-500 text-center leading-relaxed">
                    {{ $sector->description() }}
                </p>

                {{-- Hover indicator --}}
                <div class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500 rounded-b-xl scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></div>
            </button>
        @endforeach
    </div>

    {{-- Footer --}}
    <div class="mt-10 text-center space-y-3">
        <p class="text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
        </p>
        <p class="text-sm text-gray-500">
            Want to register as a customer?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Create account</a>
        </p>
    </div>
</div>
