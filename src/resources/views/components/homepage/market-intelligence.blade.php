{{-- Market Intelligence — Philippine SME Procurement Insights --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-slate-900 border-b border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Philippine SME Procurement Insights</h2>
            <span class="text-[10px] text-slate-600">Updated {{ now()->format('M d, Y') }}</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- Steel price --}}
            <div class="bg-slate-800 border border-slate-700 p-3.5 rounded-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="h-7 w-7 rounded-sm bg-slate-700 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Steel (Rebar)</p>
                        <p class="text-sm font-bold text-white tabular-nums">₱42,500<span class="text-[10px] text-slate-500 font-normal">/ton</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-[10px]">
                    <span class="text-emerald-400 font-semibold">+2.3%</span>
                    <span class="text-slate-500">vs last month</span>
                </div>
            </div>

            {{-- Cement price --}}
            <div class="bg-slate-800 border border-slate-700 p-3.5 rounded-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="h-7 w-7 rounded-sm bg-slate-700 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008V7.5z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Portland Cement</p>
                        <p class="text-sm font-bold text-white tabular-nums">₱268<span class="text-[10px] text-slate-500 font-normal">/bag</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-[10px]">
                    <span class="text-red-400 font-semibold">-0.8%</span>
                    <span class="text-slate-500">vs last month</span>
                </div>
            </div>

            {{-- Import vs local --}}
            <div class="bg-slate-800 border border-slate-700 p-3.5 rounded-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="h-7 w-7 rounded-sm bg-slate-700 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Import vs Local</p>
                        <p class="text-sm font-bold text-white">Local +14%</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-[10px]">
                    <span class="text-amber-400 font-semibold">Trending</span>
                    <span class="text-slate-500">local sourcing up</span>
                </div>
            </div>

            {{-- Lead time --}}
            <div class="bg-slate-800 border border-slate-700 p-3.5 rounded-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="h-7 w-7 rounded-sm bg-slate-700 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">Avg Lead Time</p>
                        <p class="text-sm font-bold text-white tabular-nums">5.2<span class="text-[10px] text-slate-500 font-normal"> days</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-[10px]">
                    <span class="text-emerald-400 font-semibold">-0.4 days</span>
                    <span class="text-slate-500">improving</span>
                </div>
            </div>
        </div>
        <p class="mt-3 text-[10px] text-slate-600 italic">Indicative market data. Prices and metrics are based on platform aggregate trends.</p>
    </div>
</div>
