<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Your Tickets</x-slot>
        <x-slot name="description">
            Track the status of your support requests. Use the <strong>New Ticket</strong> button to reach our admin team.
        </x-slot>
        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
