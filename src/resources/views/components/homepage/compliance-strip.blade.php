{{-- Compliance & Trust strip --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 border-b border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <h2 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-3 text-center">Platform Compliance & Trust</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @php
                $badges = [
                    ['label' => 'KYC Verified', 'desc' => 'ID & document checks', 'color' => 'text-emerald-600', 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z'],
                    ['label' => 'SEC Registered', 'desc' => 'Corporate entity', 'color' => 'text-sky-600', 'icon' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z'],
                    ['label' => 'DTI Compliant', 'desc' => 'Trade licensed', 'color' => 'text-sky-600', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                    ['label' => 'BIR VAT', 'desc' => 'Tax compliant', 'color' => 'text-amber-600', 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z'],
                    ['label' => 'PhilGEPS', 'desc' => 'Gov procurement', 'color' => 'text-violet-600', 'icon' => 'M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6'],
                    ['label' => 'Secure Pay', 'desc' => 'PCI gateway', 'color' => 'text-emerald-600', 'icon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z'],
                ];
            @endphp
            @foreach ($badges as $badge)
                <div class="flex flex-col items-center text-center gap-1.5 py-2">
                    <div class="h-8 w-8 rounded-sm bg-slate-50 border border-slate-100 flex items-center justify-center {{ $badge['color'] }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $badge['icon'] }}" /></svg>
                    </div>
                    <p class="text-[11px] font-semibold text-slate-700">{{ $badge['label'] }}</p>
                    <p class="text-[10px] text-slate-400">{{ $badge['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
