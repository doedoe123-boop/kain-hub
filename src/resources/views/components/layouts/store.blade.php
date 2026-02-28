<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') !== null ? localStorage.getItem('darkMode') === 'true' : window.matchMedia('(prefers-color-scheme: dark)').matches }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($currentStore) ? $currentStore->name : 'Store' }} — {{ $title ?? 'Login' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 dark:bg-slate-950 text-gray-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Inter', system-ui, sans-serif;">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="mb-8 text-center animate-fade-in-up">
            @if (isset($currentStore))
                <h1 class="text-3xl font-bold text-sky-600 dark:text-sky-400">{{ $currentStore->name }}</h1>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Store Management Portal</p>
            @else
                <a href="/" class="inline-flex items-center gap-2.5 group">
                    <div class="h-10 w-10 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center">
                        <x-heroicon-o-building-storefront class="w-5 h-5 text-white" />
                    </div>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">NegosyoHub</span>
                </a>
            @endif
        </div>
        <div class="w-full max-w-md animate-fade-in-up-delay-1">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-none border border-slate-200 dark:border-slate-700 p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
