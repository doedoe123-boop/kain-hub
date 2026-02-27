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
                            <x-heroicon-o-wrench-screwdriver class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::Technology)
                            <x-heroicon-o-cpu-chip class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::FoodAndBeverage)
                            <x-heroicon-o-cake class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::Healthcare)
                            <x-heroicon-o-heart class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::Chemicals)
                            <x-heroicon-o-beaker class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::Logistics)
                            <x-heroicon-o-truck class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::RealEstate)
                            <x-heroicon-o-home-modern class="w-7 h-7 text-{{ $sector->color() }}-600" />
                            @break
                        @case(App\IndustrySector::Agriculture)
                            <x-heroicon-o-sun class="w-7 h-7 text-{{ $sector->color() }}-600" />
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
