<x-filament-panels::page>
    {{-- Stats Overview --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($stats as $stat)
            <x-filament::section>
                <div class="flex items-center gap-x-3">
                    <x-filament::icon
                        :icon="$stat->getIcon()"
                        class="h-8 w-8 text-{{ $stat->getColor() }}-500"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $stat->getLabel() }}
                        </p>
                        <p class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ $stat->getValue() }}
                        </p>
                        @if ($stat->getDescription())
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $stat->getDescription() }}
                            </p>
                        @endif
                    </div>
                </div>
            </x-filament::section>
        @endforeach
    </div>

    {{-- Payouts Table --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Payout History</x-slot>
        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
