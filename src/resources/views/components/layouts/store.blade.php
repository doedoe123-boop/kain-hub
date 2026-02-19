<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($currentStore) ? $currentStore->name : 'Store' }} — {{ $title ?? 'Login' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="mb-8 text-center">
            @if (isset($currentStore))
                <h1 class="text-3xl font-bold text-indigo-600">{{ $currentStore->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">Store Management Portal</p>
            @else
                <a href="/" class="text-2xl font-bold text-indigo-600">Marketplace</a>
            @endif
        </div>
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>
</html>
