<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code }} — {{ $title }} | NegosyoHub</title>
    {{-- Apply dark class immediately to prevent flash --}}
    <script>
        (function() {
            var theme = localStorage.getItem('theme') || 'system';
            var isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300"
      style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">

    <div class="min-h-screen flex flex-col">
        {{-- Minimal top bar --}}
        <header class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <a href="/" class="inline-flex items-center gap-2.5 group">
                    <div class="h-9 w-9 rounded-xl bg-sky-600 dark:bg-sky-500 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-slate-800 dark:text-white">NegosyoHub</span>
                </a>
            </div>
        </header>

        {{-- Error content --}}
        <main class="flex-1 flex items-center justify-center px-4 py-16 sm:py-24">
            <div class="text-center max-w-lg mx-auto">
                {{-- Animated error code --}}
                <div class="relative mb-8">
                    <span class="text-[10rem] sm:text-[12rem] font-black leading-none tracking-tighter
                                 bg-gradient-to-br from-sky-500 via-sky-600 to-indigo-600
                                 dark:from-sky-400 dark:via-sky-500 dark:to-indigo-500
                                 bg-clip-text text-transparent select-none opacity-90">
                        {{ $code }}
                    </span>
                    {{-- Decorative ring --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-full border-2 border-dashed border-sky-300/40 dark:border-sky-600/30 animate-[spin_20s_linear_infinite]"></div>
                    </div>
                </div>

                {{-- Icon per error type --}}
                <div class="mb-6 inline-flex items-center justify-center w-16 h-16 rounded-2xl
                            {{ $code === 404 ? 'bg-amber-100 dark:bg-amber-900/30' : '' }}
                            {{ $code === 403 ? 'bg-rose-100 dark:bg-rose-900/30' : '' }}
                            {{ $code === 500 ? 'bg-red-100 dark:bg-red-900/30' : '' }}
                            {{ $code === 503 ? 'bg-orange-100 dark:bg-orange-900/30' : '' }}
                            {{ $code === 419 ? 'bg-violet-100 dark:bg-violet-900/30' : '' }}
                            {{ $code === 429 ? 'bg-yellow-100 dark:bg-yellow-900/30' : '' }}
                            {{ !in_array($code, [404, 403, 500, 503, 419, 429]) ? 'bg-slate-100 dark:bg-slate-800' : '' }}">
                    @switch($code)
                        @case(404)
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            @break
                        @case(403)
                            <svg class="w-8 h-8 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            @break
                        @case(500)
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            @break
                        @case(503)
                            <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
                            </svg>
                            @break
                        @case(419)
                            <svg class="w-8 h-8 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            @break
                        @case(429)
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                            </svg>
                            @break
                        @default
                            <svg class="w-8 h-8 text-slate-600 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                    @endswitch
                </div>

                {{-- Title --}}
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white mb-3">
                    {{ $title }}
                </h1>

                {{-- Description --}}
                <p class="text-base sm:text-lg text-slate-500 dark:text-slate-400 mb-10 leading-relaxed max-w-md mx-auto">
                    {{ $message }}
                </p>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="/"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700
                              dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-semibold text-sm
                              shadow-lg shadow-sky-600/25 dark:shadow-sky-500/25
                              transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Go Home
                    </a>

                    <button onclick="history.back()"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                                   bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700
                                   text-slate-700 dark:text-slate-300 font-semibold text-sm
                                   transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Go Back
                    </button>
                </div>

                {{-- Help text for specific errors --}}
                @if ($code === 419)
                    <p class="mt-8 text-sm text-slate-400 dark:text-slate-500">
                        Your session has expired. Please refresh the page and try again.
                    </p>
                @elseif ($code === 429)
                    <p class="mt-8 text-sm text-slate-400 dark:text-slate-500">
                        You've made too many requests. Please wait a moment and try again.
                    </p>
                @elseif ($code === 503)
                    <p class="mt-8 text-sm text-slate-400 dark:text-slate-500">
                        We're performing scheduled maintenance. We'll be back shortly.
                    </p>
                @endif
            </div>
        </main>

        {{-- Minimal footer --}}
        <footer class="border-t border-slate-200 dark:border-slate-800 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-slate-400 dark:text-slate-500">
                    &copy; {{ date('Y') }} NegosyoHub. All rights reserved.
                </p>
                <div class="flex items-center gap-4 text-xs text-slate-400 dark:text-slate-500">
                    <a href="/" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Home</a>
                    <span class="text-slate-300 dark:text-slate-700">&middot;</span>
                    <a href="/stores" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Browse Stores</a>
                    <span class="text-slate-300 dark:text-slate-700">&middot;</span>
                    <a href="/register/sector" class="hover:text-sky-600 dark:hover:text-sky-400 transition-colors">Become a Seller</a>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>
