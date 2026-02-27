@php
    $legalPages = \App\Models\LegalPage::published()
        ->orderByRaw("CASE type WHEN 'terms' THEN 1 WHEN 'privacy' THEN 2 WHEN 'store_agreement' THEN 3 ELSE 4 END")
        ->get(['title', 'slug', 'type']);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} — {{ config('app.name', 'NegosyoHub') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">

    {{-- ===== Sticky Header ===== --}}
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-5xl mx-auto px-5 sm:px-8 h-14 flex items-center justify-between gap-4">
            {{-- Logo --}}
            <a href="/" class="inline-flex items-center gap-2.5 flex-shrink-0 group">
                <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                    <x-heroicon-o-building-storefront class="w-4 h-4 text-white" />
                </div>
                <span class="font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">NegosyoHub</span>
            </a>

            {{-- Quick-jump nav --}}
            <nav class="flex items-center gap-1 overflow-x-auto">
                @foreach ($legalPages as $lp)
                    <a href="{{ route('legal.show', $lp->slug) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-all duration-150
                              {{ $lp->slug === $page->slug
                                  ? 'bg-indigo-50 text-indigo-700 border border-indigo-200'
                                  : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800' }}">
                        {{ $lp->title }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    {{-- ===== Main Content ===== --}}
    <main class="flex-1">
        <div class="max-w-3xl mx-auto px-5 sm:px-8 py-12">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
                <a href="/" class="hover:text-indigo-600 transition-colors">Home</a>
                <x-heroicon-o-chevron-right class="w-3 h-3" />
                <span class="text-slate-500 font-medium">Legal</span>
                <x-heroicon-o-chevron-right class="w-3 h-3" />
                <span class="text-slate-700 font-medium">{{ $page->title }}</span>
            </nav>

            {{-- Page header card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-7 mb-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-11 w-11 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <x-heroicon-o-scale class="w-6 h-6 text-indigo-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-widest mb-1">Legal Document</p>
                        <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">{{ $page->title }}</h1>
                        <div class="mt-2.5 flex flex-wrap items-center gap-x-5 gap-y-1.5 text-xs text-slate-400">
                            @if ($page->published_at)
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                                    Effective {{ $page->published_at->format('F j, Y') }}
                                </span>
                            @endif
                            @if ($page->last_reviewed_at)
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-arrow-path class="w-3.5 h-3.5" />
                                    Last reviewed {{ $page->last_reviewed_at->format('F j, Y') }}
                                </span>
                            @endif
                            @if ($page->editor)
                                <span class="inline-flex items-center gap-1.5">
                                    <x-heroicon-o-user class="w-3.5 h-3.5" />
                                    Updated by {{ $page->editor->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rich content --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-8 py-8">
                <div class="legal-content">
                    {!! $page->content !!}
                </div>
            </div>

            {{-- Quick links to other legal pages --}}
            @if ($legalPages->count() > 1)
                <div class="mt-8">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-3">Other Legal Documents</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($legalPages->where('slug', '!=', $page->slug) as $lp)
                            <a href="{{ route('legal.show', $lp->slug) }}"
                               class="flex items-center gap-3 p-4 bg-white rounded-xl border border-slate-200 hover:border-indigo-300 hover:shadow-md shadow-sm transition-all duration-150 group">
                                <div class="flex-shrink-0 h-8 w-8 rounded-lg bg-slate-50 group-hover:bg-indigo-50 flex items-center justify-center transition-colors">
                                    <x-heroicon-o-document-text class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-colors" />
                                </div>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-indigo-700 transition-colors">{{ $lp->title }}</span>
                                <x-heroicon-o-arrow-right class="w-4 h-4 text-slate-300 group-hover:text-indigo-400 ml-auto transition-colors" />
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Back + contact --}}
            <div class="mt-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <a href="{{ route('register.sector') }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Back to Registration
                </a>
                <p class="text-xs text-slate-400">
                    Questions? Email
                    <a href="mailto:legal@negosyohub.ph" class="text-indigo-600 hover:underline">legal@negosyohub.ph</a>
                </p>
            </div>
        </div>
    </main>

    {{-- ===== Footer ===== --}}
    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-5xl mx-auto px-5 sm:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-400">© {{ date('Y') }} NegosyoHub. All rights reserved.</p>
            <nav class="flex flex-wrap items-center justify-center gap-x-5 gap-y-1.5">
                @foreach ($legalPages as $lp)
                    <a href="{{ route('legal.show', $lp->slug) }}"
                       class="text-xs text-slate-400 hover:text-indigo-600 transition-colors {{ $lp->slug === $page->slug ? 'font-semibold text-indigo-600' : '' }}">
                        {{ $lp->title }}
                    </a>
                @endforeach
            </nav>
        </div>
    </footer>

</body>
</html>
