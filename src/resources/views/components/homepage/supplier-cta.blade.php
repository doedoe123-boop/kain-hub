{{-- CTA: Register as supplier --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-sm font-bold text-white">Register your business as a verified supplier</h2>
                <p class="mt-0.5 text-xs text-slate-400">Submit your KYC documents and get listed within 3–5 business days. Free to register.</p>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                @guest
                    <a href="{{ route('register.sector') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-sm text-slate-900 bg-white hover:bg-slate-100 transition-colors">
                        Apply Now
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </a>
                @endguest
                @auth
                    @if (auth()->user()->isStoreOwner() && auth()->user()->store?->isApproved())
                        <a href="/lunar" class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-sm text-slate-900 bg-white hover:bg-slate-100 transition-colors">
                            Supplier Dashboard
                        </a>
                    @elseif (auth()->user()->isAdmin())
                        <a href="/admin" class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-sm text-slate-900 bg-white hover:bg-slate-100 transition-colors">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
