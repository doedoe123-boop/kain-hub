<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Marketplace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 dark:bg-slate-950 text-gray-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Inter', system-ui, sans-serif;">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="mb-8 animate-fade-in-up">
            <a href="/" class="inline-flex items-center gap-2.5 group">
                <div class="h-10 w-10 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-slate-800 dark:text-white">NegosyoHub</span>
            </a>
        </div>
        <div class="w-full {{ $maxWidth ?? 'max-w-3xl' }} animate-fade-in-up-delay-1">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>
</html>
