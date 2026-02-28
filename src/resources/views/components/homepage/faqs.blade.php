{{-- FAQs — Accordion Style --}}
@php
    $faqs = \App\Models\Faq::active()->get();
@endphp

@if ($faqs->isNotEmpty())
<div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="faqs">
    {{-- Decorative background --}}
    <div class="absolute inset-0 bg-slate-50/30 dark:bg-slate-900/30"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="max-w-3xl mx-auto">

            {{-- Header --}}
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 mb-5 shadow-sm">
                    <x-heroicon-s-question-mark-circle class="w-7 h-7 text-indigo-600 dark:text-indigo-400" />
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15] mb-3">
                    Frequently Asked Questions
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-lg mx-auto">
                    Everything you need to know about NegosyoHub. Can't find what you're looking for? Reach out to our support team.
                </p>
            </div>

            {{-- Accordion --}}
            <div class="space-y-3" x-data="{ openFaq: null }">
                @foreach ($faqs as $faq)
                    <div class="rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800/40 overflow-hidden transition-shadow duration-200"
                         :class="{ 'shadow-md border-indigo-200 dark:border-indigo-500/30': openFaq === {{ $faq->id }}, 'shadow-sm hover:shadow-md': openFaq !== {{ $faq->id }} }">
                        <button
                            type="button"
                            @click="openFaq = openFaq === {{ $faq->id }} ? null : {{ $faq->id }}"
                            class="flex items-center justify-between w-full px-6 py-5 text-left gap-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900 rounded-xl"
                        >
                            <span class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white leading-snug pr-2">
                                {{ $faq->question }}
                            </span>
                            <span class="flex-shrink-0 h-8 w-8 rounded-lg flex items-center justify-center transition-colors duration-200"
                                  :class="openFaq === {{ $faq->id }} ? 'bg-indigo-100 dark:bg-indigo-500/20' : 'bg-slate-100 dark:bg-slate-700/60'">
                                <x-heroicon-o-chevron-down
                                    class="w-4 h-4 transition-transform duration-300"
                                    ::class="openFaq === {{ $faq->id }} ? 'rotate-180 text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500'"
                                />
                            </span>
                        </button>
                        <div
                            x-show="openFaq === {{ $faq->id }}"
                            x-collapse
                            x-cloak
                        >
                            <div class="px-6 pb-5 -mt-1">
                                <div class="prose prose-sm prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-400 leading-relaxed">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endif
