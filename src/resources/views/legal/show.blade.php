@php
    $legalPages = \App\Models\LegalPage::published()
        ->orderByRaw("CASE type WHEN 'terms' THEN 1 WHEN 'privacy' THEN 2 WHEN 'store_agreement' THEN 3 ELSE 4 END")
        ->get(['title', 'slug', 'type']);
@endphp

<x-layouts.app :title="$page->title.' — NegosyoHub Legal'">

    {{-- Premium Hero Section --}}
    <div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="legal-hero">
        
        {{-- Decorative Background Gradients --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 hidden dark:block">
            <div class="absolute -top-1/4 right-1/4 w-[500px] h-[500px] bg-slate-500/10 rounded-full blur-[100px] mix-blend-screen opacity-50"></div>
        </div>

        {{-- Background Dot Pattern --}}
        <div class="absolute inset-0 z-0 opacity-[0.03] dark:opacity-[0.05] bg-[radial-gradient(#000_1px,transparent_1px)] dark:bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 text-center">
            <nav class="flex items-center justify-center gap-2 text-[11px] font-bold tracking-wider text-slate-400 uppercase mb-6">
                <a href="{{ route('home') }}" class="hover:text-slate-600 dark:hover:text-slate-300 transition-colors">Home</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200">Legal Agreements</span>
            </nav>
            
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.15] mb-6">
                {{ $page->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                @if ($page->published_at)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50">
                        <x-heroicon-o-calendar class="w-4 h-4 text-emerald-500" />
                        Effective {{ $page->published_at->format('F j, Y') }}
                    </span>
                @endif
                @if ($page->last_reviewed_at)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50">
                        <x-heroicon-o-arrow-path class="w-4 h-4 text-sky-500" />
                        Reviewed {{ $page->last_reviewed_at->format('F j, Y') }}
                    </span>
                @endif
                @if ($page->editor)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50">
                        <x-heroicon-o-shield-check class="w-4 h-4 text-amber-500" />
                        Compliance Verification
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Two-Column Layout --}}
    <div class="bg-slate-50/50 dark:bg-[#060A13]">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
            <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 relative items-start">
                
                {{-- Sticky Sidebar --}}
                <aside class="w-full lg:w-72 shrink-0 lg:sticky lg:top-28 z-10 transition-all">
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-6 sm:p-8 shadow-sm">
                        <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Legal Directory</h3>
                        <nav class="space-y-1.5">
                            @foreach ($legalPages as $lp)
                                <a href="{{ route('legal.show', $lp->slug) }}" class="group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $lp->slug === $page->slug ? 'bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white font-bold border border-slate-200 dark:border-slate-600 shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900/50 font-semibold' }}">
                                    <span>{{ $lp->title }}</span>
                                    @if ($lp->slug === $page->slug)
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    @endif
                                </a>
                            @endforeach
                        </nav>
                        
                        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700/50">
                            <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">Enterprise Support</h3>
                            <a href="mailto:legal@negosyohub.ph" class="flex items-center gap-2.5 px-4 py-3 rounded-xl bg-slate-900 dark:bg-slate-700 text-white font-semibold hover:bg-slate-800 dark:hover:bg-slate-600 transition-colors shadow-sm">
                                <x-heroicon-s-envelope class="w-4 h-4 text-emerald-400" />
                                Contact Legal Team
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- Rich Document Content --}}
                <div class="flex-1 min-w-0">
                    <div class="bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 sm:p-12 lg:p-16 shadow-sm">
                        <div class="prose prose-slate dark:prose-invert prose-lg max-w-none text-slate-600 dark:text-slate-300 font-medium">
                            {!! $page->content !!}
                        </div>
                    </div>

                    {{-- Back + contact --}}
                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('register.sector') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                            <x-heroicon-o-arrow-left class="w-4 h-4" />
                            Return to Enterprise Onboarding
                        </a>
                        <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                            Official Compliance Document
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.app>
