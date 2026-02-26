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
<body class="antialiased bg-slate-50 text-slate-900">
    {{-- Top utility bar --}}
    <div class="bg-slate-800 text-slate-300 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-8">
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline">Philippines B2B Marketplace</span>
                <span class="text-slate-500 hidden sm:inline">|</span>
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    KYC-verified suppliers
                </span>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-slate-400">{{ auth()->user()->email }}</span>
                    @if (auth()->user()->isCustomer())
                        <span class="text-slate-600">|</span>
                        <a href="{{ route('register.store-owner') }}" class="hover:text-white transition-colors">Become a Supplier</a>
                    @endif
                @else
                    <a href="{{ route('register.store-owner') }}" class="hover:text-white transition-colors">Become a Supplier</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Main navigation --}}
    <nav class="bg-white sticky top-0 z-50 border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center gap-6">
                    <a href="/" class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded bg-slate-800 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-slate-900 tracking-tight">KainHub</span>
                    </a>

                    <div class="hidden md:flex items-center gap-1 text-sm">
                        <a href="/" class="text-slate-600 hover:text-slate-900 hover:bg-slate-100 px-3 py-1.5 rounded-md transition-colors font-medium">Suppliers</a>
                        <span class="text-slate-300 px-1">|</span>
                        @auth
                            @if (auth()->user()->isAdmin())
                                <a href="/admin" class="text-slate-600 hover:text-slate-900 hover:bg-slate-100 px-3 py-1.5 rounded-md transition-colors">Admin</a>
                            @endif

                            @if (auth()->user()->isStoreOwner())
                                @if (auth()->user()->store?->isApproved())
                                    <a href="/lunar" class="text-slate-600 hover:text-slate-900 hover:bg-slate-100 px-3 py-1.5 rounded-md transition-colors">Dashboard</a>
                                @else
                                    <a href="{{ route('store.pending') }}" class="text-amber-600 hover:text-amber-800 hover:bg-amber-50 px-3 py-1.5 rounded-md transition-colors">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Under Review
                                        </span>
                                    </a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="hidden sm:flex items-center gap-2 text-sm">
                                <div class="h-7 w-7 rounded bg-slate-200 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-slate-600">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-slate-700">{{ auth()->user()->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs text-slate-400 hover:text-red-600 px-2 py-1 rounded transition-colors">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('register.store-owner') }}"
                            class="inline-flex items-center px-4 py-1.5 text-sm font-semibold rounded-md text-white bg-slate-800 hover:bg-slate-700 transition-colors">
                            Register as Supplier
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded bg-slate-800 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-slate-800">KainHub</span>
                    </div>
                    <p class="mt-2 text-xs text-slate-400 leading-relaxed">Connecting verified Philippine suppliers with SME buyers. KYC-compliant B2B procurement platform.</p>
                </div>
                {{-- Links --}}
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Platform</h3>
                    <ul class="space-y-1.5 text-xs text-slate-500">
                        <li><a href="/" class="hover:text-slate-700 transition-colors">Browse Suppliers</a></li>
                        <li><a href="{{ route('register.store-owner') }}" class="hover:text-slate-700 transition-colors">Register as Supplier</a></li>
                    </ul>
                </div>
                {{-- Compliance --}}
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Compliance</h3>
                    <ul class="space-y-1.5 text-xs text-slate-500">
                        <li class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            DTI/SEC Verification
                        </li>
                        <li class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            KYC-verified Suppliers
                        </li>
                        <li class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Secure Payment Processing
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} KainHub. All rights reserved.</p>
                <p class="text-xs text-slate-400">Built in the Philippines</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
