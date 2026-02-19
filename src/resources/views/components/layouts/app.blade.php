<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Marketplace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    {{-- Navigation --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-indigo-600">Marketplace</a>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="/admin" class="ml-8 text-sm text-gray-600 hover:text-gray-900">Admin Panel</a>
                        @endif

                        @if (auth()->user()->isStoreOwner())
                            @if (auth()->user()->store?->isApproved())
                                <a href="/lunar" class="ml-8 text-sm text-gray-600 hover:text-gray-900">Store Dashboard</a>
                            @else
                                <a href="{{ route('store.pending') }}" class="ml-8 text-sm text-yellow-600 hover:text-yellow-800">Store Status</a>
                            @endif
                        @endif

                        @if (auth()->user()->isCustomer())
                            <a href="{{ route('register.store-owner') }}" class="ml-8 text-sm text-indigo-600 hover:text-indigo-800 font-medium">Open a Store</a>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">{{ auth()->user()->role->value }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
