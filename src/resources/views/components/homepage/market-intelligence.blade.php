{{-- Market Intelligence — High-End Financial Dashboard --}}
<div class="bg-[#0a0f1a] dark:bg-[#050810]" id="market-intelligence">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] font-bold text-sky-400 uppercase tracking-[0.2em] mb-2">Market Intelligence</p>
                <h2 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">Philippine Marketplace Insights</h2>
            </div>
            <span class="text-xs text-slate-600 font-semibold tabular-nums">Updated {{ now()->format('M d, Y') }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Steel Rebar --}}
            <div class="group relative rounded-2xl bg-[#0e1524] border border-[#1a2338] hover:border-[#243050] p-6 transition-all duration-300 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-11 w-11 rounded-xl bg-amber-500/10 border border-amber-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Steel (Rebar)</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tabular-nums tracking-tight">₱42,500<span class="text-xs text-slate-600 font-semibold ml-1">/ton</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-green font-extrabold">+2.3%</span>
                        <svg class="w-3.5 h-3.5 text-[#00ff88]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                        <span class="text-slate-600 font-medium">vs last month</span>
                    </div>
                    {{-- Spark line --}}
                    <div class="mt-4 flex items-end gap-px h-8">
                        @foreach ([40, 55, 45, 60, 50, 65, 55, 70, 60, 75, 68, 80] as $val)
                            <div class="flex-1 rounded-t-sm bg-gradient-to-t from-amber-500/30 to-amber-400/60 transition-all duration-300 group-hover:from-amber-500/40 group-hover:to-amber-400/80" style="height: {{ $val }}%"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Portland Cement --}}
            <div class="group relative rounded-2xl bg-[#0e1524] border border-[#1a2338] hover:border-[#243050] p-6 transition-all duration-300 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-400/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-11 w-11 rounded-xl bg-slate-500/10 border border-slate-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008V7.5z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Portland Cement</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tabular-nums tracking-tight">₱268<span class="text-xs text-slate-600 font-semibold ml-1">/bag</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-red font-extrabold">-0.8%</span>
                        <svg class="w-3.5 h-3.5 text-[#ff4466]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" /></svg>
                        <span class="text-slate-600 font-medium">vs last month</span>
                    </div>
                    <div class="mt-4 flex items-end gap-px h-8">
                        @foreach ([70, 65, 60, 55, 58, 52, 48, 50, 45, 42, 44, 40] as $val)
                            <div class="flex-1 rounded-t-sm bg-gradient-to-t from-slate-500/20 to-slate-400/40 transition-all duration-300 group-hover:from-red-500/20 group-hover:to-red-400/50" style="height: {{ $val }}%"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Import vs Local --}}
            <div class="group relative rounded-2xl bg-[#0e1524] border border-[#1a2338] hover:border-[#243050] p-6 transition-all duration-300 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-500/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-11 w-11 rounded-xl bg-sky-500/10 border border-sky-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Import vs Local</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tracking-tight">Local <span class="neon-green">+14%</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-amber font-extrabold">Trending</span>
                        <span class="text-slate-600 font-medium">local sourcing up</span>
                    </div>
                    <div class="mt-4 flex items-end gap-px h-8">
                        @foreach ([30, 35, 40, 38, 45, 50, 55, 58, 62, 65, 70, 75] as $val)
                            <div class="flex-1 rounded-t-sm bg-gradient-to-t from-sky-500/20 to-sky-400/50 transition-all duration-300 group-hover:from-sky-500/30 group-hover:to-sky-400/70" style="height: {{ $val }}%"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Avg Lead Time --}}
            <div class="group relative rounded-2xl bg-[#0e1524] border border-[#1a2338] hover:border-[#243050] p-6 transition-all duration-300 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="h-11 w-11 rounded-xl bg-violet-500/10 border border-violet-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Avg Lead Time</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tabular-nums tracking-tight">5.2<span class="text-xs text-slate-600 font-semibold ml-1">days</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-green font-extrabold">-0.4 days</span>
                        <span class="text-slate-600 font-medium">improving</span>
                    </div>
                    <div class="mt-4 flex items-end gap-px h-8">
                        @foreach ([80, 75, 72, 68, 65, 60, 62, 58, 55, 52, 50, 48] as $val)
                            <div class="flex-1 rounded-t-sm bg-gradient-to-t from-violet-500/20 to-violet-400/50 transition-all duration-300 group-hover:from-violet-500/30 group-hover:to-violet-400/70" style="height: {{ $val }}%"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <p class="mt-6 text-xs text-slate-700 italic">Indicative market data. Prices and metrics are based on platform aggregate trends.</p>
    </div>
</div>
