{{-- Trust & Compliance — Premium Security Banner --}}
<div class="relative bg-white dark:bg-[#0B1120] border-b border-slate-200 dark:border-slate-800/60 overflow-hidden" id="trust-compliance">
    {{-- Decorative Backgrounds --}}
    <div class="absolute inset-0 bg-slate-50/50 dark:bg-slate-900/50"></div>
    
    {{-- Security watermark seal --}}
    <div class="absolute -right-20 -top-20 opacity-[0.03] dark:opacity-[0.02] transform -rotate-12 pointer-events-none">
        <x-heroicon-s-shield-check class="w-[400px] h-[400px] text-slate-900 dark:text-white" />
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="max-w-5xl mx-auto">
            
            <div class="flex flex-col lg:flex-row gap-12 lg:items-center">
                {{-- Left Text Area --}}
                <div class="lg:w-5/12 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 mb-6 shadow-sm shadow-emerald-500/5">
                        <x-heroicon-s-shield-check class="w-8 h-8 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15] mb-4">
                        Enterprise-grade Security & Compliance
                    </h2>
                    <p class="text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-md mx-auto lg:mx-0">
                        We maintain a strict zero-tolerance policy for fraudulent listings. Every seller on NegosyoHub undergoes rigorous verification to protect your procurement pipeline.
                    </p>
                    
                    {{-- Bottom trust seals row --}}
                    <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 shadow-sm">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">DTI / SEC Compliant</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 shadow-sm">
                            <x-heroicon-s-check-badge class="w-3.5 h-3.5 text-sky-500" />
                            <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">PhilGEPS Aligned</span>
                        </div>
                    </div>
                </div>

                {{-- Right Grid Grid --}}
                <div class="lg:w-7/12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- KYC --}}
                        <div class="group flex flex-col gap-3 p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 hover:border-emerald-300 dark:hover:border-emerald-500/50 transition-colors duration-300 shadow-sm hover:shadow-md">
                            <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <x-heroicon-o-finger-print class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">KYC-Verified Sellers</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Mandatory identity verification and document checks for every store owner before account activation.</p>
                            </div>
                        </div>

                        {{-- Secure Data --}}
                        <div class="group flex flex-col gap-3 p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 hover:border-sky-300 dark:hover:border-sky-500/50 transition-colors duration-300 shadow-sm hover:shadow-md">
                            <div class="h-10 w-10 rounded-xl bg-sky-50 dark:bg-sky-500/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <x-heroicon-o-lock-closed class="w-5 h-5 text-sky-600 dark:text-sky-400" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Encrypted & Secure</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">End-to-end encrypted data storage and secure communication channels protect your business data.</p>
                            </div>
                        </div>

                        {{-- Moderation --}}
                        <div class="group flex flex-col gap-3 p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 hover:border-amber-300 dark:hover:border-amber-500/50 transition-colors duration-300 shadow-sm hover:shadow-md">
                            <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <x-heroicon-o-eye class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Active Moderation</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Continuous platform oversight, listing reviews, and dedicated dispute resolution by our human admin team.</p>
                            </div>
                        </div>

                        {{-- PH Compliance --}}
                        <div class="group flex flex-col gap-3 p-6 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/50 hover:border-violet-300 dark:hover:border-violet-500/50 transition-colors duration-300 shadow-sm hover:shadow-md">
                            <div class="h-10 w-10 rounded-xl bg-violet-50 dark:bg-violet-500/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <x-heroicon-o-document-check class="w-5 h-5 text-violet-600 dark:text-violet-400" />
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Tax & Legal Compliance</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Structured to support Official Receipts (OR), automated BIR tax compliance, and legal enterprise structuring.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
