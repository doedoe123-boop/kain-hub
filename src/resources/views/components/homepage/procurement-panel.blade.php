{{-- ============================================================
     HERO: Clean marketplace positioning with split layout & SaaS feel
     ============================================================ --}}
<div class="relative overflow-hidden bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800" id="hero-section" x-data="heroNetwork()" x-init="startSequence()">
    {{-- Abstract Philippine Map Background with Connections --}}
    <!-- Make the map text darker so it is visible on white background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0 flex items-center justify-center lg:justify-end lg:pr-[10%] opacity-80 dark:opacity-[0.25]">
        <x-svg-ph-map class="w-[900px] h-[900px] text-slate-300 dark:text-slate-300 transform -translate-x-20 lg:-translate-x-10" />
    </div>
    
    {{-- Decorative Background Gradients --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[20%] -right-[10%] w-[800px] h-[800px] bg-sky-500/15 dark:bg-sky-500/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen opacity-70"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[600px] h-[600px] bg-emerald-500/15 dark:bg-emerald-500/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen opacity-70"></div>
    </div>

    <div class="relative z-10 max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
            
            {{-- Left Column: Copy & Actions --}}
            <div class="lg:col-span-6 text-center lg:text-left relative z-20 md:max-w-2xl md:mx-auto lg:max-w-none lg:mx-0">
                {{-- Eyebrow --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 mb-6 shadow-sm">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-emerald-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-300 tracking-wide uppercase">The Philippines' Premium B2B Platform</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-[1.1] tracking-tight">
                    Scale your business.
                    <br>
                    Streamline orders.
                    <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-emerald-500">All in one place.</span>
                </h1>
                
                @php
                    $activeNames = \App\Models\Sector::active()->pluck('name')->map(fn($n) => strtolower($n))->toArray();
                    $heroList = count($activeNames) > 0 
                        ? implode(', ', array_slice($activeNames, 0, 3)) . (count($activeNames) > 3 ? ', and more' : '') 
                        : 'multiple industries';
                @endphp
                
                <p class="mt-6 text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    NegosyoHub isn't just a directory — it's a powerful sales engine. We connect verified professionals across {{ $heroList }}.
                </p>

                {{-- CTAs --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('register.sector') }}"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 text-sm font-bold rounded-xl text-white bg-slate-900 dark:bg-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-50 shadow-xl shadow-slate-900/10 dark:shadow-white/10 transition-all duration-300 group">
                        Start Selling Today
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </a>
                    <a href="{{ route('stores.index') }}"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 text-sm font-bold rounded-xl text-slate-700 dark:text-slate-300 bg-white dark:bg-transparent border-2 border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300">
                        Explore Marketplace
                    </a>
                </div>

                {{-- Quick Stats / Social Proof in a horizontal row on desktop --}}
                @php
                    $verifiedSellersCount = \App\Models\Store::query()->where('status', \App\StoreStatus::Approved)->count();
                    $activeSectorsCount = \App\Models\Sector::active()->count();
                @endphp
                <div class="mt-10 sm:mt-12 flex items-center justify-center lg:justify-start gap-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col items-center sm:items-start lg:items-center">
                        <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $verifiedSellersCount }}+</span>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-1">Sellers</span>
                    </div>
                    <div class="w-px h-8 bg-slate-300 dark:bg-slate-800"></div>
                    <div class="flex flex-col items-center sm:items-start lg:items-center">
                        <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $activeSectorsCount }}</span>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-1">Sectors</span>
                    </div>
                    <div class="w-px h-8 bg-slate-300 dark:bg-slate-800"></div>
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 border-2 border-white dark:border-slate-900 flex items-center justify-center"><x-heroicon-s-user class="w-4 h-4 text-slate-500" /></div>
                            <div class="w-8 h-8 rounded-full bg-slate-300 dark:bg-slate-600 border-2 border-white dark:border-slate-900 flex items-center justify-center"><x-heroicon-s-user class="w-4 h-4 text-white" /></div>
                            <div class="w-8 h-8 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900 flex items-center justify-center"><x-heroicon-s-check class="w-4 h-4 text-white" /></div>
                        </div>
                        <div class="flex flex-col items-start ml-2">
                            <div class="flex items-center text-amber-500">
                                <x-heroicon-s-star class="w-3.5 h-3.5"/>
                                <x-heroicon-s-star class="w-3.5 h-3.5"/>
                                <x-heroicon-s-star class="w-3.5 h-3.5"/>
                                <x-heroicon-s-star class="w-3.5 h-3.5"/>
                                <x-heroicon-s-star class="w-3.5 h-3.5"/>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 tracking-wide mt-0.5">Trusted by partners</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Dashboard UI Mockup --}}
            <div class="hidden lg:block lg:col-span-6 relative mt-16 lg:mt-0 lg:pl-10">
                 {{-- Main Glass Card --}}
                 <div class="relative z-10 w-full rounded-2xl bg-white/40 dark:bg-slate-800/30 backdrop-blur-xl border border-white/60 dark:border-white/10 shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:shadow-2xl p-6 transform rotate-2 hover:-translate-y-2 hover:rotate-0 transition-all duration-500">
                    
                    {{-- Mock Header --}}
                    <div class="flex items-center justify-between border-b border-white/60 dark:border-slate-700/50 pb-4 mb-5">
                       <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-sky-600 shadow-md flex items-center justify-center">
                             <x-heroicon-o-chart-bar class="w-5 h-5 text-white" />
                          </div>
                          <div>
                             <div class="text-sm font-bold text-slate-900 dark:text-white transition-opacity duration-300" x-text="cities[activeIndex].name">Seller Dashboard</div>
                             <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold flex items-center gap-1 mt-0.5"><x-heroicon-s-check-circle class="w-3.5 h-3.5" /> <span x-text="cities[activeIndex].subtitle">Performance Optimized</span></div>
                          </div>
                       </div>
                       <div class="flex gap-2">
                           <div class="h-2 w-2 rounded-full bg-slate-200 dark:bg-slate-600"></div>
                           <div class="h-2 w-2 rounded-full bg-slate-200 dark:bg-slate-600"></div>
                           <div class="h-2 w-2 rounded-full bg-slate-200 dark:bg-slate-600"></div>
                       </div>
                    </div>

                    {{-- Mock Stats --}}
                    <div class="grid grid-cols-2 gap-4 mb-6 relative">
                       <div class="bg-white/60 dark:bg-slate-900/40 backdrop-blur-md border border-white/60 dark:border-slate-700/50 rounded-xl p-4 transition-all duration-300 hover:bg-white/80 dark:hover:bg-slate-800 shadow-sm relative overflow-hidden"
                            :class="isAnimating ? 'scale-[1.03] ring-1 ring-emerald-500/50 transform-gpu' : 'scale-100 ring-0 ring-transparent'">
                          <div class="flex justify-between items-start mb-2">
                              <div class="text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Revenue</div>
                              <x-heroicon-s-arrow-trending-up class="w-4 h-4 text-emerald-600" />
                          </div>
                          <div class="text-2xl font-black text-slate-900 dark:text-white mb-1 transition-opacity duration-300" x-text="cities[activeIndex].revenue">₱428.5k</div>
                          <div class="text-[10px] font-bold text-emerald-800 dark:text-emerald-300 bg-emerald-100/80 dark:bg-emerald-500/20 px-2 py-0.5 rounded inline-flex">+14.2% from last month</div>
                       </div>
                       <div class="bg-white/60 dark:bg-slate-900/40 backdrop-blur-md border border-white/60 dark:border-slate-700/50 rounded-xl p-4 transition-all duration-300 hover:bg-white/80 dark:hover:bg-slate-800 shadow-sm relative overflow-hidden"
                            :class="isAnimating ? 'scale-[1.03] ring-1 ring-emerald-500/50 transform-gpu' : 'scale-100 ring-0 ring-transparent'">
                          <div class="flex justify-between items-start mb-2">
                              <div class="text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Inquiries</div>
                              <x-heroicon-o-chat-bubble-oval-left-ellipsis class="w-4 h-4 text-sky-600" />
                          </div>
                          <div class="text-2xl font-black text-slate-900 dark:text-white mb-1 transition-opacity duration-300" x-text="cities[activeIndex].inquiries">84 Active</div>
                          <div class="text-[10px] font-bold text-sky-800 dark:text-sky-300 bg-sky-100/80 dark:bg-sky-500/20 px-2 py-0.5 rounded inline-flex transition-opacity duration-300" x-text="cities[activeIndex].pending">12 awaiting response</div>
                       </div>
                    </div>

                    {{-- Mock List / Recent Activity --}}
                    <div>
                        <div class="text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest mb-3">Recent Orders</div>
                        <div class="space-y-3 relative">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-white/60 dark:bg-slate-800/50 backdrop-blur-md shadow-sm border border-white/60 dark:border-slate-700/80 transition-all duration-300 relative overflow-hidden">
                                <template x-if="activeIndex % 2 === 0">
                                    <div class="absolute inset-0 bg-white/40 dark:bg-white/5 opacity-0 pointer-events-none transition-opacity duration-500 animate-pulse"></div>
                                </template>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-500/30 flex items-center justify-center">
                                        <x-heroicon-o-user class="w-4 h-4 text-orange-600 dark:text-orange-400" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white transition-opacity duration-300" x-text="cities[activeIndex].recent1">XYZ Catering Corp.</div>
                                        <div class="text-[10px] text-slate-600 dark:text-slate-400 font-medium mt-0.5 transition-opacity duration-300" x-text="cities[activeIndex].type1">Bulk ingredients order</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white transition-opacity duration-300" x-text="cities[activeIndex].val1">₱15,200</div>
                                    <div class="text-[10px] text-emerald-700 dark:text-emerald-400 font-bold mt-0.5">Paid</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-white/60 dark:bg-slate-800/50 backdrop-blur-md shadow-sm border border-white/60 dark:border-slate-700/80 transition-all duration-300 relative overflow-hidden">
                                <template x-if="activeIndex % 2 !== 0">
                                    <div class="absolute inset-0 bg-white/40 dark:bg-white/5 opacity-0 pointer-events-none transition-opacity duration-500 animate-pulse"></div>
                                </template>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-violet-100 dark:bg-violet-500/30 flex items-center justify-center">
                                        <x-heroicon-o-building-office-2 class="w-4 h-4 text-violet-600 dark:text-violet-400" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white transition-opacity duration-300" x-text="cities[activeIndex].recent2">Prime Properties Inc</div>
                                        <div class="text-[10px] text-slate-600 dark:text-slate-400 font-medium mt-0.5 transition-opacity duration-300" x-text="cities[activeIndex].type2">Brokerage partnership</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white transition-opacity duration-300" x-text="cities[activeIndex].val2">Contract</div>
                                    <div class="text-[10px] text-sky-700 dark:text-sky-400 font-bold mt-0.5"><span x-text="cities[activeIndex].val2 == 'Contract' || cities[activeIndex].val2 == 'Review' ? 'Under Review' : 'Processed'"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>

                 {{-- Floating "New Verification" Element --}}
                 <div class="absolute z-20 -right-4 -bottom-6 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl p-4 shadow-xl shadow-slate-900/5 dark:shadow-black/30 border border-white dark:border-slate-700 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <x-heroicon-s-shield-check class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900 dark:text-white">Store Verified</div>
                            <div class="text-[10px] text-slate-600 dark:text-slate-400 font-medium">DTI/SEC documents approved</div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('heroNetwork', () => ({
        activeIndex: 0,
        isAnimating: false,
        cities: [
            { id: 'manila', name: 'Manila Primary Hub', subtitle: 'National Distribution Center', revenue: '₱1.2M', inquiries: '243 Active', pending: 'Logistics processing', recent1: 'TechCorp Solutions', type1: 'Bulk IT Equipment', val1: '₱450,000', recent2: 'City Grocers', type2: 'FMCG Distribution', val2: 'Processing' },
            { id: 'iloilo', name: 'Iloilo Agri-Center', subtitle: 'Visayas Agricultural Hub', revenue: '₱350k', inquiries: '85 Active', pending: 'Farm-to-B2B routing', recent1: 'Panay Farmers Coop.', type1: 'Raw Agricultural', val1: '₱85,000', recent2: 'Western Seafoods', type2: 'Cold Chain Supply', val2: 'Manifested' },
            { id: 'cebu', name: 'Cebu Trans-Hub', subtitle: 'Central Logistics Node', revenue: '₱890k', inquiries: '156 Active', pending: 'Maritime freight processing', recent1: 'Island Retailers', type1: 'Consumer Goods', val1: '₱210,000', recent2: 'Mactan Manufacturing', type2: 'Industrial Supplies', val2: 'In Transit' },
            { id: 'davao', name: 'Davao Exchange', subtitle: 'Mindanao Export Gateway', revenue: '₱620k', inquiries: '112 Active', pending: 'Export clearance in progress', recent1: 'Mindanao Plantations', type1: 'Bulk Fruit Export', val1: '₱320,000', recent2: 'Southern Builders', type2: 'Construction Materials', val2: 'Delivered' }
        ],
        timer: null,
        startSequence() {
            this.timer = setInterval(() => {
                this.isAnimating = true;
                setTimeout(() => this.isAnimating = false, 500);
                this.activeIndex = (this.activeIndex + 1) % this.cities.length;
            }, 3000); // changes every 3 seconds to show progress
        }
    }));
});
</script>
