{{-- Recently Awarded Contracts — marketplace legitimacy --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <h2 class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-3">Recently Awarded Contracts</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-2 pr-4 font-semibold text-slate-500 uppercase text-[10px] tracking-wider">Category</th>
                        <th class="text-left py-2 pr-4 font-semibold text-slate-500 uppercase text-[10px] tracking-wider">Awarded To</th>
                        <th class="text-left py-2 pr-4 font-semibold text-slate-500 uppercase text-[10px] tracking-wider hidden sm:table-cell">Region</th>
                        <th class="text-right py-2 font-semibold text-slate-500 uppercase text-[10px] tracking-wider">Value Range</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $contracts = [
                            ['category' => 'Office IT Equipment', 'supplier' => 'TechSource Manila', 'region' => 'NCR', 'value' => '₱250K–500K', 'verified' => true],
                            ['category' => 'Construction Materials', 'supplier' => 'BuildRight Corp', 'region' => 'Central Luzon', 'value' => '₱1.2M–2.5M', 'verified' => true],
                            ['category' => 'PPE & Safety Gear', 'supplier' => 'SafeGuard PH', 'region' => 'CALABARZON', 'value' => '₱80K–150K', 'verified' => false],
                            ['category' => 'Food & Bev Wholesale', 'supplier' => 'FreshHub Trading', 'region' => 'Central Visayas', 'value' => '₱500K–1M', 'verified' => true],
                            ['category' => 'Janitorial Supplies', 'supplier' => 'CleanPro Inc', 'region' => 'NCR', 'value' => '₱45K–90K', 'verified' => true],
                        ];
                    @endphp
                    @foreach ($contracts as $c)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 pr-4 text-slate-700 font-medium">{{ $c['category'] }}</td>
                            <td class="py-2.5 pr-4">
                                <div class="flex items-center gap-1">
                                    <span class="text-slate-700">{{ $c['supplier'] }}</span>
                                    @if ($c['verified'])
                                        <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="py-2.5 pr-4 text-slate-500 hidden sm:table-cell">{{ $c['region'] }}</td>
                            <td class="py-2.5 text-right font-semibold text-slate-700 tabular-nums">{{ $c['value'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="mt-3 text-[10px] text-slate-400 italic">Sample data. Actual contract data will be populated as transactions are processed.</p>
    </div>
</div>
