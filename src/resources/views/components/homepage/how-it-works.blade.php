{{-- How It Works — Simple 3-step flow --}}
<div class="bg-slate-50/50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800/60" id="how-it-works">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center mb-12 lg:mb-16">
            <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3">Getting Started</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Start selling in 3 simple steps</h2>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">Set up your store, list your products, and start receiving orders — all in under 10 minutes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 max-w-4xl mx-auto">
            @php
                $steps = [
                    [
                        'step' => '01',
                        'title' => 'Create Your Account',
                        'desc' => 'Register as a seller and complete your business profile. Upload your DTI/SEC documents for verification.',
                        'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
                        'gradient' => 'from-sky-500 to-blue-600',
                    ],
                    [
                        'step' => '02',
                        'title' => 'Set Up Your Store',
                        'desc' => 'Customize your storefront, add your products with photos and pricing, and configure your delivery options.',
                        'icon' => 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35',
                        'gradient' => 'from-emerald-500 to-teal-600',
                    ],
                    [
                        'step' => '03',
                        'title' => 'Start Selling',
                        'desc' => 'Go live and let customers discover your store. Manage orders, track sales, and grow your business.',
                        'icon' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941',
                        'gradient' => 'from-amber-500 to-orange-600',
                    ],
                ];
            @endphp

            @foreach ($steps as $idx => $step)
                <div class="relative text-center">
                    {{-- Connector line (not on last) --}}
                    @if (!$loop->last)
                        <div class="hidden md:block absolute top-10 left-[60%] w-[80%] border-t-2 border-dashed border-slate-200 dark:border-slate-700"></div>
                    @endif

                    {{-- Step number badge --}}
                    <div class="relative inline-flex items-center justify-center h-20 w-20 rounded-3xl bg-gradient-to-br {{ $step['gradient'] }} shadow-lg mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" /></svg>
                        <span class="absolute -top-2 -right-2 h-7 w-7 rounded-full bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 flex items-center justify-center text-xs font-extrabold text-slate-700 dark:text-slate-200 shadow-sm">{{ $step['step'] }}</span>
                    </div>

                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-[280px] mx-auto">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('register.sector') }}" class="inline-flex items-center gap-2.5 px-8 py-4 text-sm font-extrabold rounded-xl text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 shadow-lg shadow-sky-500/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl group">
                Get Started — It's Free
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>
</div>
