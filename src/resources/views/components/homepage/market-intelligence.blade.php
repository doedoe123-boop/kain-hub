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
                            <x-heroicon-o-circle-stack class="w-5 h-5 text-amber-400" />
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Steel (Rebar)</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tabular-nums tracking-tight">₱42,500<span class="text-xs text-slate-600 font-semibold ml-1">/ton</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-green font-extrabold">+2.3%</span>
                        <x-heroicon-o-arrow-trending-up class="w-3.5 h-3.5 text-[#00ff88]" />
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
                            <x-heroicon-o-building-office-2 class="w-5 h-5 text-slate-400" />
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.15em]">Portland Cement</p>
                        </div>
                    </div>
                    <p class="text-2xl font-extrabold text-white tabular-nums tracking-tight">₱268<span class="text-xs text-slate-600 font-semibold ml-1">/bag</span></p>
                    <div class="mt-3 flex items-center gap-2 text-xs">
                        <span class="neon-red font-extrabold">-0.8%</span>
                        <x-heroicon-o-arrow-trending-down class="w-3.5 h-3.5 text-[#ff4466]" />
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
                            <x-heroicon-o-globe-alt class="w-5 h-5 text-sky-400" />
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
                            <x-heroicon-o-clock class="w-5 h-5 text-violet-400" />
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
