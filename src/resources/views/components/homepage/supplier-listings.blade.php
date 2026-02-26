{{-- Supplier listings with sidebar filters --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex flex-col lg:flex-row gap-4">

        {{-- LEFT SIDEBAR: Filters --}}
        <aside class="w-full lg:w-56 shrink-0 space-y-3">
            {{-- Verification --}}
            <div class="bg-white border border-slate-200 p-3.5">
                <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2.5">Compliance Status</h3>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" checked class="rounded-sm border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        KYC Verified
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" class="rounded-sm border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        DTI/SEC Registered
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" class="rounded-sm border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        BIR VAT Registered
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" class="rounded-sm border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        PhilGEPS Compatible
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" class="rounded-sm border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        ISO Certified
                    </label>
                </div>
            </div>

            {{-- Region --}}
            <div class="bg-white border border-slate-200 p-3.5">
                <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2.5">Region</h3>
                <select class="block w-full border-slate-200 text-xs text-slate-600 focus:border-sky-500 focus:ring-sky-500 py-1.5 rounded-sm">
                    <option>All Regions</option>
                    <option>NCR — Metro Manila</option>
                    <option>Region III — Central Luzon</option>
                    <option>Region IV-A — CALABARZON</option>
                    <option>Region VII — Central Visayas</option>
                    <option>Region XI — Davao</option>
                </select>
            </div>

            {{-- MOQ --}}
            <div class="bg-white border border-slate-200 p-3.5">
                <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2.5">Min. Order Value</h3>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5" checked>
                        Any
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        ₱5,000+
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        ₱25,000+
                    </label>
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="radio" name="min_order" class="border-slate-300 text-sky-600 focus:ring-sky-500 h-3.5 w-3.5">
                        ₱100,000+
                    </label>
                </div>
            </div>

            {{-- Sort --}}
            <div class="bg-white border border-slate-200 p-3.5">
                <h3 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2.5">Sort By</h3>
                <select class="block w-full border-slate-200 text-xs text-slate-600 focus:border-sky-500 focus:ring-sky-500 py-1.5 rounded-sm">
                    <option>Relevance</option>
                    <option>Newest Listed</option>
                    <option>Most Verified</option>
                    <option>Alphabetical</option>
                </select>
            </div>

            {{-- RFQ promo --}}
            <div class="bg-slate-800 border border-slate-700 p-3.5">
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-2">Need Quotes?</p>
                <p class="text-xs text-slate-300 leading-relaxed mb-3">Post an RFQ and let verified suppliers bid on your requirements.</p>
                <a href="#" class="block w-full text-center px-3 py-1.5 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-sm transition-colors">
                    Post RFQ
                </a>
            </div>
        </aside>

        {{-- RIGHT: Listings --}}
        <div class="flex-1 min-w-0">
            {{-- Results header --}}
            <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-200">
                <p class="text-xs text-slate-500">
                    Showing <span class="font-semibold text-slate-700">{{ \App\Models\Store::where('status', 'approved')->count() }}</span> verified suppliers
                </p>
                <div class="flex items-center gap-1.5">
                    <button class="p-1 border border-slate-200 text-slate-400 hover:text-slate-600 hover:border-slate-300 rounded-sm" title="Grid view">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    </button>
                    <button class="p-1 border border-sky-200 bg-sky-50 text-sky-600 rounded-sm" title="List view">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                    </button>
                </div>
            </div>

            {{-- Cards --}}
            <div class="space-y-2">
                @forelse (\App\Models\Store::where('status', 'approved')->latest()->take(10)->get() as $store)
                    <x-homepage.supplier-card :store="$store" />
                @empty
                    <div class="bg-white border border-dashed border-slate-300 p-10 text-center">
                        <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" />
                        </svg>
                        <p class="mt-2 text-sm font-medium text-slate-600">No suppliers listed yet</p>
                        <p class="mt-1 text-xs text-slate-400">Be the first to register your business on the platform.</p>
                        @guest
                            <a href="{{ route('register.sector') }}" class="inline-flex items-center mt-3 px-4 py-1.5 text-xs font-semibold rounded-sm text-white bg-sky-600 hover:bg-sky-700 transition-colors">
                                Register as Supplier
                            </a>
                        @endguest
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>
</div>
