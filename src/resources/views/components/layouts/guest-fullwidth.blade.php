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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased text-gray-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Inter', system-ui, sans-serif;">
    <div class="min-h-screen">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
