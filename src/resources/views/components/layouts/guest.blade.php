<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          theme: localStorage.getItem('theme') || 'system',
          darkMode: false,
          resolve() {
              this.darkMode = this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
          },
          toggle() {
              const next = { system: 'dark', dark: 'light', light: 'system' };
              this.theme = next[this.theme];
              this.theme === 'system' ? localStorage.removeItem('theme') : localStorage.setItem('theme', this.theme);
              this.resolve();
          }
      }"
      x-init="
          resolve();
          window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => resolve());
          if (localStorage.getItem('darkMode') !== null) { localStorage.removeItem('darkMode'); }
      "
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Marketplace') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">

    @if ($fullWidth ?? false)
        {{-- Full-width layout: used by registration forms with their own sidebar --}}
        <div class="min-h-screen">
            {{ $slot }}
        </div>
    @else
        {{-- Centered card layout: used by login, simple guest pages --}}
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            <div class="mb-8 animate-fade-in-up">
                <a href="/" class="inline-flex items-center gap-2.5 group">
                    <div class="h-10 w-10 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center">
                        <x-heroicon-o-building-storefront class="w-5 h-5 text-white" />
                    </div>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">NegosyoHub</span>
                </a>
            </div>
            <div class="w-full {{ $maxWidth ?? 'max-w-md' }} animate-fade-in-up-delay-1">
                {{ $slot }}
            </div>
        </div>
    @endif

    @livewireScripts
</body>
</html>
