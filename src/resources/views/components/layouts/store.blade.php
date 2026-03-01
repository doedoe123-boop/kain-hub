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
    <title>{{ isset($currentStore) ? $currentStore->name : 'Store' }} — {{ $title ?? 'Login' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="mb-8 text-center animate-fade-in-up">
            @if (isset($currentStore))
                <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 shadow-lg shadow-sky-500/20 mb-4">
                    <x-heroicon-o-building-storefront class="w-7 h-7 text-white" />
                </div>
                <h1 class="text-3xl font-bold text-sky-600 dark:text-sky-400">{{ $currentStore->name }}</h1>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">Store Management Portal</p>
            @else
                <a href="/" class="inline-flex items-center gap-2.5 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center shadow-lg shadow-sky-500/20">
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

        {{-- Dark mode toggle --}}
        <div class="mt-6">
            <button @click="toggle()" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" :title="'Theme: ' + theme">
                <svg x-show="!darkMode && theme !== 'system'" x-cloak class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>
                <svg x-show="darkMode && theme !== 'system'" x-cloak class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                <svg x-show="theme === 'system'" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25z" /></svg>
                <span x-text="theme === 'system' ? 'System' : (darkMode ? 'Dark' : 'Light')"></span>
            </button>
        </div>
    </div>
    @livewireScripts
</body>
</html>
