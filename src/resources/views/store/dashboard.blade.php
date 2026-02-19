<x-layouts.app>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Store Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>

        @if (auth()->user()->store)
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ auth()->user()->store->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Status:
                    <span @class([
                        'px-2 py-1 rounded-full text-xs font-medium',
                        'bg-yellow-100 text-yellow-800' => auth()->user()->store->status->value === 'pending',
                        'bg-green-100 text-green-800' => auth()->user()->store->status->value === 'approved',
                        'bg-red-100 text-red-800' => auth()->user()->store->status->value === 'suspended',
                    ])>
                        {{ ucfirst(auth()->user()->store->status->value) }}
                    </span>
                </p>
                <div class="mt-3 p-3 bg-white rounded border border-gray-200">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Your Store Login URL</p>
                    @php
                        $storeUrl = auth()->user()->store->slug . '.' . config('app.domain');
                        $port = parse_url(config('app.url'), PHP_URL_PORT);
                        if ($port) { $storeUrl .= ':' . $port; }
                    @endphp
                    <p class="mt-1 text-sm font-mono text-indigo-600">{{ $storeUrl }}/login</p>
                </div>
            </div>
        @else
            <div class="mt-6 bg-blue-50 rounded-lg p-4">
                <p class="text-blue-700">You don't have a store yet. Store registration will be available soon.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
