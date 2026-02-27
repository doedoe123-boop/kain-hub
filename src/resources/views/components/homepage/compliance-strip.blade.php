{{-- Trust & Compliance — Dark trust banner with shield motif --}}
<div class="bg-slate-800 dark:bg-slate-900 relative overflow-hidden" id="trust-compliance">
    {{-- Subtle background pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;)"></div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="max-w-4xl mx-auto">
            {{-- Header with trust seal --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 mb-4">
                    <x-heroicon-s-shield-check class="w-8 h-8 text-emerald-400" />
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Trust & Compliance</h2>
                <p class="mt-2 text-sm text-slate-400">Every seller on NegosyoHub is verified. Every transaction is protected.</p>
            </div>

            {{-- Trust items grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- KYC --}}
                <div class="flex items-start gap-4 p-5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.06] transition-colors duration-200">
                    <div class="shrink-0 h-10 w-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                        <x-heroicon-o-finger-print class="w-5 h-5 text-emerald-400" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white mb-1">KYC-Verified Sellers</p>
                        <p class="text-xs text-slate-400 leading-relaxed">Identity verification and document checks for every store owner before going live.</p>
                    </div>
                </div>

                {{-- Secure Data --}}
                <div class="flex items-start gap-4 p-5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.06] transition-colors duration-200">
                    <div class="shrink-0 h-10 w-10 rounded-lg bg-sky-500/10 flex items-center justify-center">
                        <x-heroicon-o-lock-closed class="w-5 h-5 text-sky-400" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white mb-1">Encrypted & Secure</p>
                        <p class="text-xs text-slate-400 leading-relaxed">End-to-end encrypted data storage and secure payment processing channels.</p>
                    </div>
                </div>

                {{-- Moderation --}}
                <div class="flex items-start gap-4 p-5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.06] transition-colors duration-200">
                    <div class="shrink-0 h-10 w-10 rounded-lg bg-amber-500/10 flex items-center justify-center">
                        <x-heroicon-o-eye class="w-5 h-5 text-amber-400" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white mb-1">Active Moderation</p>
                        <p class="text-xs text-slate-400 leading-relaxed">Platform oversight, listing review, and dispute resolution by our admin team.</p>
                    </div>
                </div>

                {{-- PH Compliance --}}
                <div class="flex items-start gap-4 p-5 rounded-xl bg-white/[0.04] border border-white/[0.06] hover:bg-white/[0.06] transition-colors duration-200">
                    <div class="shrink-0 h-10 w-10 rounded-lg bg-violet-500/10 flex items-center justify-center">
                        <x-heroicon-o-document-check class="w-5 h-5 text-violet-400" />
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white mb-1">Philippine Business Compliance</p>
                        <p class="text-xs text-slate-400 leading-relaxed">DTI/SEC registration, BIR tax compliance, and PhilGEPS-aligned standards.</p>
                    </div>
                </div>
            </div>

            {{-- Bottom trust seals row --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/[0.04] border border-white/[0.06]">
                    <x-heroicon-s-check-badge class="w-4 h-4 text-emerald-400" />
                    <span class="text-xs font-semibold text-slate-300">DTI Registered</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/[0.04] border border-white/[0.06]">
                    <x-heroicon-s-check-badge class="w-4 h-4 text-sky-400" />
                    <span class="text-xs font-semibold text-slate-300">PhilGEPS Aligned</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-white/[0.04] border border-white/[0.06]">
                    <x-heroicon-s-check-badge class="w-4 h-4 text-amber-400" />
                    <span class="text-xs font-semibold text-slate-300">BIR Compliant</span>
                </div>
            </div>
        </div>
    </div>
</div>
