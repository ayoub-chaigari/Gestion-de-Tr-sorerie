<x-app-layout>
    <div class="space-y-10 pb-12 opacity-0 animate-fade-in-up" x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 500)">
        
        @if(auth()->user()->role === 'SUPER_ADMIN' && $platformStats)
        <!-- SuperAdmin Platform Stats -->
        <div class="mb-12">
            <h2 class="text-[10px] font-black text-[#006C4A] uppercase tracking-[0.3em] mb-6 font-headline">{{ __('Platform Command Authority') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-[#0b1120] rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl border border-white/5 group hover:border-[#006C4A]/50 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ __('Active Tenants') }}</div>
                        <span class="material-symbols-outlined text-[#006C4A] opacity-50">corporate_fare</span>
                    </div>
                    <div class="text-4xl font-black text-white italic tracking-tighter font-headline">{{ $platformStats['total_companies'] }}</div>
                    <div class="mt-6 h-1 w-12 bg-[#006C4A] rounded-full group-hover:w-full transition-all duration-700"></div>
                </div>
                <div class="bg-[#0b1120] rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl border border-white/5 group hover:border-[#006C4A]/50 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ __('Global Operators') }}</div>
                        <span class="material-symbols-outlined text-[#006C4A] opacity-50">badge</span>
                    </div>
                    <div class="text-4xl font-black text-white italic tracking-tighter font-headline">{{ $platformStats['total_users'] }}</div>
                    <div class="mt-6 h-1 w-12 bg-emerald-500 rounded-full group-hover:w-full transition-all duration-700"></div>
                </div>
                <div class="bg-[#0b1120] rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl border border-white/5 group hover:border-[#CDA833]/50 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ __('Total Sovereign Volume') }}</div>
                        <span class="material-symbols-outlined text-[#CDA833] opacity-50">account_balance_wallet</span>
                    </div>
                    <div class="text-2xl font-black text-white italic tracking-tighter font-headline">{{ number_format($platformStats['global_volume'] / 1000000, 1) }}M <span class="text-[10px] text-slate-500 not-italic">MAD</span></div>
                    <div class="mt-6 h-1 w-12 bg-[#CDA833] rounded-full group-hover:w-full transition-all duration-700"></div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Uncleared Assets -->
            <a href="{{ route('cheques.index', ['status' => 'deposited']) }}" class="bg-white rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl shadow-slate-200/40 border border-slate-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Uncleared Assets') }}</h3>
                        <p class="text-3xl font-black text-slate-900 mt-2 font-headline italic tracking-tighter">
                            {{ number_format($enCours, 0, '.', ',') }} <span class="text-lg text-slate-400 not-italic">MAD</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                        <span class="material-symbols-outlined text-[1.4rem]">content_paste_search</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-blue-600">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    {{ __('Processing Settlement') }}
                </div>
            </a>

            <!-- Total Revenue Flow -->
            <a href="{{ route('cheques.index', ['status' => 'paid']) }}" class="bg-white rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl shadow-slate-200/40 border border-slate-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-[#006C4A]"></div>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Total Revenue Flow') }}</h3>
                        <p class="text-3xl font-black text-slate-900 mt-2 font-headline italic tracking-tighter">
                            {{ number_format($encaissements, 0, '.', ',') }} <span class="text-lg text-slate-400 not-italic">MAD</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-[#006C4A]">
                        <span class="material-symbols-outlined text-[1.4rem]">trending_up</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 uppercase tracking-tighter">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    {{ __('Verified Inflow') }}
                </div>
            </a>

            <!-- Total Expenditure -->
            <a href="{{ route('invoices.index', ['status' => 'paid']) }}" class="bg-white rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl shadow-slate-200/40 border border-slate-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-rose-500"></div>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('Total Expenditure') }}</h3>
                        <p class="text-3xl font-black text-slate-900 mt-2 font-headline italic tracking-tighter">
                            {{ number_format($decaissements, 0, '.', ',') }} <span class="text-lg text-slate-400 not-italic">MAD</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500">
                        <span class="material-symbols-outlined text-[1.4rem]">trending_down</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-rose-600 uppercase tracking-tighter">
                    <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    {{ __('Cleared Liabilities') }}
                </div>
            </a>

            <!-- Net Treasury Position -->
            <a href="{{ route('bank-accounts.index') }}" class="bg-[#0b1120] rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-2xl shadow-[#0b1120]/20 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ __('Net Treasury Position') }}</h3>
                        <p class="text-3xl font-black text-white mt-2 font-headline italic tracking-tighter">
                            {{ number_format($soldeNet, 0, '.', ',') }} <span class="text-lg text-slate-500 not-italic">MAD</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-[1.4rem]">account_balance</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold text-[#CDA833] uppercase lg:tracking-tighter">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">verified</span>
                    {{ __('Institutional Grade Vault') }}
                </div>
            </a>
        </div>

        <!-- Pulse & Ledger Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Treasury Flux Intelligence (Chart) -->
            <div class="lg:col-span-2 bg-white rounded-3xl lg:rounded-[3rem] p-6 lg:p-10 shadow-xl shadow-slate-200/30 border border-slate-50 flex flex-col min-h-[400px] lg:min-h-[500px]" id="chartCard">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-8 lg:mb-12">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 font-headline italic tracking-tight">{{ __('Treasury Flux Intelligence') }}</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ __('Real-time institutional cash-flow matrix') }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <!-- Toggle Monthly / Weekly -->
                        <div class="flex bg-slate-50 p-1 rounded-xl">
                            <button id="btnMonthly" onclick="switchChart('monthly')" class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest bg-white shadow-sm rounded-lg text-[#006C4A] transition-all">{{ __('Monthly') }}</button>
                            <button id="btnWeekly" onclick="switchChart('weekly')" class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all">{{ __('Weekly') }}</button>
                        </div>
                        <!-- Export Buttons -->
                        <button onclick="downloadChartImage()" title="{{ __('Export Image') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition-all rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                            <span class="material-symbols-outlined text-[1rem]">image</span>
                            {{ __('Image') }}
                        </button>
                        <button onclick="downloadExcel()" title="{{ __('Export Excel') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition-all rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                            <span class="material-symbols-outlined text-[1rem]">table_chart</span>
                            Excel
                        </button>
                        <button onclick="downloadPDF()" title="{{ __('Export PDF') }}" class="flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white transition-all rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-100">
                            <span class="material-symbols-outlined text-[1rem]">picture_as_pdf</span>
                            PDF
                        </button>
                    </div>
                </div>
                
                <div class="flex-1 w-full relative">
                    <canvas id="treasuryChart"></canvas>
                </div>

                <div class="mt-8 flex justify-center gap-10">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 bg-[#006C4A] rounded-full"></span>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">{{ __('Inbound Liquidity') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 bg-[#0b1120] rounded-full"></span>
                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-widest">{{ __('Outbound Settlement') }}</span>
                    </div>
                </div>
            </div>

            <!-- Live Ledger (Feed) -->
            <div class="bg-white rounded-3xl lg:rounded-[3rem] p-6 lg:p-10 shadow-xl shadow-slate-200/30 border border-slate-50 flex flex-col h-full">
                <div class="flex justify-between items-center mb-10">
                    <h2 class="text-xl font-black text-slate-900 font-headline italic tracking-tight">{{ __('Live Ledger') }}</h2>
                    <a href="{{ route('activity-logs.index') }}" class="text-[10px] font-black uppercase tracking-widest text-[#006C4A] hover:underline">{{ __('View All') }}</a>
                </div>
                
                <div class="flex-1 space-y-8 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($recentTransactions as $tx)
                        <div class="flex items-center gap-5 group relative">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 transition-all {{ $tx->type === 'in' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                <span class="material-symbols-outlined text-[1.4rem] transition-transform group-hover:scale-110">{{ $tx->type === 'in' ? 'north_east' : 'south_east' }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-slate-900 truncate leading-none">{{ $tx->description }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">
                                    {{ $tx->date }} &bull; {{ $tx->time }}
                                </p>
                            </div>
                            <div class="text-right shrink-0 group-hover:opacity-0 transition-opacity">
                                <p class="text-sm font-black {{ $tx->type === 'in' ? 'text-emerald-600' : 'text-rose-600' }} tracking-tight">{{ $tx->type === 'in' ? '+' : '-' }}{{ number_format($tx->amount, 0, '.', ',') }} <span class="text-[9px] text-slate-400 font-bold">MAD</span></p>
                                @php
                                    $statusColors = [
                                        'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'deposited' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'endorsed' => 'bg-purple-50 text-purple-700 border-purple-100',
                                        'unpaid' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    ];
                                    $statusLabel = [
                                        'paid' => __('Cleared'),
                                        'pending' => __('Pending'),
                                        'deposited' => __('Deposited'),
                                        'endorsed' => __('Endorsed'),
                                        'unpaid' => __('Rejected'),
                                    ][$tx->status] ?? $tx->status;
                                    $colorClass = $statusColors[$tx->status] ?? 'bg-slate-50 text-slate-500 border-slate-100';
                                @endphp
                                <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $colorClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            
                            <!-- Detail Overlay -->
                            <div class="absolute right-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <a href="{{ $tx->link }}" class="bg-[#0b1120] text-white px-4 py-2 rounded-xl text-[8px] font-black uppercase tracking-widest shadow-xl">{{ __('Details') }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center text-slate-300 italic text-[10px] font-bold uppercase tracking-widest">{{ __('No Ledger Signals') }}</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Alert Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Breach Alert -->
            <div class="bg-rose-700 rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-2xl shadow-rose-900/40 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 flex flex-col">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-110 transition-transform duration-700 pointer-events-none"></div>
                <div class="flex items-start gap-6 relative z-10 mb-4">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center shadow-inner shrink-0 text-white text-3xl">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white font-headline">{{ __('Breach Alert') }}</h3>
                        <p class="text-[11px] text-white/70 font-bold mt-1 leading-relaxed">
                            {{ $overdueInvoices->count() }} {{ __('high severity breaches detected.') }}
                        </p>
                    </div>
                </div>
                <div class="relative z-10 space-y-2 mt-auto">
                    @foreach($overdueInvoices->take(3) as $inv)
                        <div class="flex justify-between items-center text-white/90 text-[10px] bg-white/10 rounded-xl px-4 py-2">
                            <span class="font-bold truncate max-w-[120px]">{{ $inv->supplier->name ?? 'Unknown' }}</span>
                            <span class="font-black tracking-widest">{{ number_format($inv->total_ttc, 0, '.', ',') }}</span>
                        </div>
                    @endforeach
                    <a href="{{ route('invoices.index', ['status' => 'overdue']) }}" class="block text-center text-[9px] font-black uppercase tracking-widest text-white/50 hover:text-white mt-4 border-t border-white/10 pt-3">{{ __('View All') }}</a>
                </div>
            </div>

            <!-- Pre-Default Warning -->
            <div class="bg-[#CDA833] rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-2xl shadow-[#CDA833]/40 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 flex flex-col">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-700 pointer-events-none"></div>
                <div class="flex items-start gap-6 relative z-10 mb-4">
                    <div class="w-14 h-14 bg-[#111827]/10 backdrop-blur-xl rounded-2xl flex items-center justify-center shadow-inner shrink-0 text-[#111827] text-3xl">
                        <span class="material-symbols-outlined">report</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-[#111827] font-headline">{{ __('Pre-Default Warning') }}</h3>
                        <p class="text-[11px] text-[#111827]/70 font-bold mt-1 leading-relaxed">
                            {{ $atRiskInvoices->count() }} {{ __('contracts approaching threshold.') }}
                        </p>
                    </div>
                </div>
                <div class="relative z-10 space-y-2 mt-auto">
                    @foreach($atRiskInvoices->take(3) as $inv)
                        <div class="flex justify-between items-center text-[#111827] text-[10px] bg-[#111827]/10 rounded-xl px-4 py-2">
                            <span class="font-bold truncate max-w-[120px]">{{ $inv->supplier->name ?? 'Unknown' }}</span>
                            <span class="font-black tracking-widest">{{ number_format($inv->total_ttc, 0, '.', ',') }}</span>
                        </div>
                    @endforeach
                    <a href="{{ route('invoices.index', ['status' => 'at_risk']) }}" class="block text-center text-[9px] font-black uppercase tracking-widest text-[#111827]/50 hover:text-[#111827] mt-4 border-t border-[#111827]/10 pt-3">{{ __('View All') }}</a>
                </div>
            </div>

            <!-- Asset Rejections -->
            <div class="bg-white rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-8 shadow-xl shadow-slate-200/40 border border-slate-50 relative overflow-hidden group transition-all duration-300 flex flex-col hover:scale-[1.02]">
                <div class="flex items-start gap-6 mb-4">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 shrink-0 text-slate-900 text-3xl">
                        <span class="material-symbols-outlined">cancel</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900 font-headline">{{ __('Asset Rejections') }}</h3>
                        <p class="text-[11px] text-slate-400 font-bold mt-1 leading-relaxed">
                            {{ $unpaidCheques->count() }} {{ __('assets flagged for verification mismatch.') }}
                        </p>
                    </div>
                </div>
                <div class="relative z-10 space-y-2 mt-auto">
                    @foreach($unpaidCheques->take(3) as $chq)
                        <div class="flex justify-between items-center text-slate-700 text-[10px] bg-slate-50 rounded-xl px-4 py-2 border border-slate-100">
                            <span class="font-bold truncate max-w-[120px]">{{ $chq->contact->name ?? 'Unknown' }}</span>
                            <span class="font-black tracking-widest">{{ number_format($chq->amount, 0, '.', ',') }}</span>
                        </div>
                    @endforeach
                    <a href="{{ route('rejections.index') }}" class="block text-center text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 mt-4 border-t border-slate-100 pt-3 hover:bg-slate-50 py-2 rounded-xl transition-all">{{ __('Review All Rejections') }}</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script>
        // ── Transaction data from server ──────────────────────────────────────
        const allTransactions = @json($recentTransactions);
        const allTransactionsForPdf = @json($allTransactions);

        // ── Summary stats for PDF ────────────────────────────────────────────
        const pdfStats = {
            encaissements: {{ $encaissements }},
            decaissements: {{ $decaissements }},
            soldeNet: {{ $soldeNet }},
            enCours: {{ $enCours }},
        };

        // ── Chart data from server ────────────────────────────────────────────
        const monthlyData = {
            labels:   {!! json_encode(array_column($chartData, 'month')) !!},
            incoming: {!! json_encode(array_column($chartData, 'incoming')) !!},
            outgoing: {!! json_encode(array_column($chartData, 'outgoing')) !!},
        };
        const weeklyData = {
            labels:   {!! json_encode(array_column($weeklyChartData, 'week')) !!},
            incoming: {!! json_encode(array_column($weeklyChartData, 'incoming')) !!},
            outgoing: {!! json_encode(array_column($weeklyChartData, 'outgoing')) !!},
        };

        // ── Chart Setup ───────────────────────────────────────────────────────
        const barRadius = { topLeft: 50, topRight: 50, bottomLeft: 50, bottomRight: 50 };
        const ctx = document.getElementById('treasuryChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyData.labels,
                datasets: [
                    { label: 'Inbound',  data: monthlyData.incoming, backgroundColor: '#006C4A', borderRadius: barRadius, borderSkipped: false, barThickness: 24 },
                    { label: 'Outbound', data: monthlyData.outgoing, backgroundColor: '#0b1120', borderRadius: barRadius, borderSkipped: false, barThickness: 24 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0b1120', padding: 12, cornerRadius: 16, displayColors: false,
                        titleFont: { family: 'Plus Jakarta Sans', weight: '800', size: 12 },
                        bodyFont:  { family: 'Plus Jakarta Sans', weight: '600', size: 10 },
                        callbacks: { label: (ctx) => `${ctx.dataset.label}: ${Math.abs(ctx.parsed.y).toLocaleString('fr-MA')} MAD` }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', weight: '700', size: 10 }, color: '#94a3b8', padding: 10 } },
                    y: { display: true, grid: { color: '#f1f5f9', borderDash: [5, 5] }, border: { display: false },
                         ticks: { font: { family: 'Plus Jakarta Sans', weight: '700', size: 10 }, color: '#cbd5e1', callback: v => v >= 1000 ? (v/1000).toFixed(0)+'K' : v } }
                }
            }
        });

        // ── Toggle Monthly / Weekly ───────────────────────────────────────────
        let currentMode = 'monthly';

        function switchChart(mode) {
            if (mode === currentMode) return;
            currentMode = mode;
            const source = mode === 'weekly' ? weeklyData : monthlyData;
            chart.data.labels            = source.labels;
            chart.data.datasets[0].data  = source.incoming;
            chart.data.datasets[1].data  = source.outgoing;
            chart.update('active');

            const btnM = document.getElementById('btnMonthly');
            const btnW = document.getElementById('btnWeekly');
            if (mode === 'monthly') {
                btnM.classList.add('bg-white','shadow-sm','text-[#006C4A]');    btnM.classList.remove('text-slate-400');
                btnW.classList.remove('bg-white','shadow-sm','text-[#006C4A]'); btnW.classList.add('text-slate-400');
            } else {
                btnW.classList.add('bg-white','shadow-sm','text-[#006C4A]');    btnW.classList.remove('text-slate-400');
                btnM.classList.remove('bg-white','shadow-sm','text-[#006C4A]'); btnM.classList.add('text-slate-400');
            }
        }

        // ── Chart Export (Image) ─────────────────────────────────────────────
        async function downloadChartImage() {
            const card = document.getElementById('chartCard');
            const canvas = await html2canvas(card, { 
                scale: 3, 
                backgroundColor: '#ffffff',
                useCORS: true,
                logging: false
            });
            const link = document.createElement('a');
            link.download = 'treasury-pulse-' + new Date().toISOString().slice(0,10) + '.png';
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        }

        // ── PDF Export — Professional Transaction Report (Tables Only) ────────
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
            const pageW = doc.internal.pageSize.getWidth();
            const pageH = doc.internal.pageSize.getHeight();

            const today = new Date().toLocaleDateString('fr-MA', { year: 'numeric', month: 'long', day: 'numeric' });
            const filename = 'financial-report-' + new Date().toISOString().slice(0,10) + '.pdf';
            const fmtNum = (n) => Number(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // ── Page 1: Header Banner ─────────────────────────────────────────
            doc.setFillColor(11, 17, 32);
            doc.roundedRect(10, 8, pageW - 20, 22, 4, 4, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            doc.text('SovereignPay — Rapport Financier Institutionnel', 16, 22);
            doc.setFontSize(9);
            doc.setTextColor(180, 180, 200);
            doc.text('Généré le : ' + today, pageW - 80, 22);

            // ── Summary KPI Cards Row ─────────────────────────────────────────
            const cardY = 38;
            const cardH = 22;
            const cardGap = 5;
            const cardW = (pageW - 20 - cardGap * 3) / 4;
            const cards = [
                { label: 'Encaissements',     value: fmtNum(pdfStats.encaissements), color: [0, 108, 74] },
                { label: 'Décaissements',     value: fmtNum(pdfStats.decaissements), color: [190, 30, 30] },
                { label: 'En Cours',          value: fmtNum(pdfStats.enCours),       color: [59, 130, 246] },
                { label: 'Solde Net',         value: fmtNum(pdfStats.soldeNet),      color: [11, 17, 32] },
            ];
            cards.forEach((c, i) => {
                const x = 10 + i * (cardW + cardGap);
                // Card background
                doc.setFillColor(...c.color);
                doc.roundedRect(x, cardY, cardW, cardH, 3, 3, 'F');
                // Label
                doc.setFontSize(8);
                doc.setTextColor(255, 255, 255);
                doc.setFont('helvetica', 'normal');
                doc.text(c.label.toUpperCase(), x + 5, cardY + 8);
                // Value
                doc.setFontSize(13);
                doc.setFont('helvetica', 'bold');
                doc.text(c.value + ' MAD', x + 5, cardY + 17);
            });

            // ── Section Title ──────────────────────────────────────────────────
            const tableStartY = cardY + cardH + 10;
            doc.setFontSize(11);
            doc.setTextColor(30, 30, 50);
            doc.setFont('helvetica', 'bold');
            doc.text('Registre Complet des Transactions', 10, tableStartY);
            doc.setFontSize(8);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(130, 130, 150);
            doc.text('Toutes les opérations enregistrées — ' + allTransactionsForPdf.length + ' transactions', 10, tableStartY + 5);

            // ── Build Table Rows from ALL transactions ─────────────────────────
            let totalIn = 0, totalOut = 0;
            const rows = allTransactionsForPdf.map((tx, idx) => {
                if (tx.type === 'in') totalIn += Number(tx.amount);
                else totalOut += Number(tx.amount);
                return [
                    (idx + 1).toString(),
                    tx.description,
                    tx.date,
                    tx.time || '-',
                    tx.type === 'in' ? 'Entrée' : 'Sortie',
                    fmtNum(tx.amount) + ' MAD',
                    tx.status.charAt(0).toUpperCase() + tx.status.slice(1),
                ];
            });

            // ── Transactions Table ─────────────────────────────────────────────
            let pageCount = 0;
            doc.autoTable({
                startY: tableStartY + 9,
                head: [['#', 'Description', 'Date', 'Heure', 'Type', 'Montant', 'Statut']],
                body: rows,
                margin: { left: 10, right: 10 },
                styles: { fontSize: 7.5, cellPadding: 2.5, font: 'helvetica', valign: 'middle', lineColor: [230, 230, 230], lineWidth: 0.2 },
                headStyles: { fillColor: [11, 17, 32], textColor: 255, fontStyle: 'bold', fontSize: 8, cellPadding: 3 },
                alternateRowStyles: { fillColor: [248, 250, 252] },
                columnStyles: {
                    0: { halign: 'center', cellWidth: 10, fontStyle: 'bold', textColor: [150, 150, 150] },
                    1: { cellWidth: 80 },
                    2: { halign: 'center', cellWidth: 25 },
                    3: { halign: 'center', cellWidth: 22 },
                    4: { halign: 'center', cellWidth: 20 },
                    5: { halign: 'right', fontStyle: 'bold', cellWidth: 35 },
                    6: { halign: 'center', cellWidth: 25 }
                },
                didParseCell: (data) => {
                    if (data.column.index === 4 && data.section === 'body') {
                        data.cell.styles.textColor = data.cell.raw === 'Entrée' ? [0, 108, 74] : [190, 30, 30];
                        data.cell.styles.fontStyle = 'bold';
                    }
                    if (data.column.index === 5 && data.section === 'body') {
                        const row = data.row.raw;
                        const isIn = row[4] === 'Entrée';
                        data.cell.styles.textColor = isIn ? [0, 108, 74] : [190, 30, 30];
                    }
                    if (data.column.index === 6 && data.section === 'body') {
                        const s = (data.cell.raw || '').toLowerCase();
                        if (s === 'paid' || s === 'payé') data.cell.styles.textColor = [0, 108, 74];
                        else if (s === 'deposited' || s === 'déposé') data.cell.styles.textColor = [59, 130, 246];
                        else if (s === 'unpaid' || s === 'impayé') data.cell.styles.textColor = [190, 30, 30];
                        else if (s === 'endorsed' || s === 'endossé') data.cell.styles.textColor = [124, 58, 237];
                    }
                },
                didDrawPage: function (data) {
                    pageCount++;
                    // Footer with branding
                    doc.setFillColor(248, 250, 252);
                    doc.rect(0, pageH - 12, pageW, 12, 'F');
                    doc.setFontSize(7);
                    doc.setTextColor(150, 150, 160);
                    doc.setFont('helvetica', 'normal');
                    doc.text('SovereignPay · Gestion de Trésorerie Institutionnelle', 10, pageH - 5);
                    doc.text('Page ' + pageCount, pageW - 25, pageH - 5);

                    // Re-draw header on subsequent pages
                    if (pageCount > 1) {
                        doc.setFillColor(11, 17, 32);
                        doc.roundedRect(10, 5, pageW - 20, 12, 3, 3, 'F');
                        doc.setTextColor(255, 255, 255);
                        doc.setFont('helvetica', 'bold');
                        doc.setFontSize(9);
                        doc.text('SovereignPay — Rapport Financier (suite)', 16, 13);
                        doc.setFontSize(7);
                        doc.setTextColor(180, 180, 200);
                        doc.text(today, pageW - 50, 13);
                    }
                }
            });

            // ── Summary Footer Row after table ────────────────────────────────
            const finalY = doc.lastAutoTable.finalY + 6;
            if (finalY + 18 < pageH - 15) {
                // Totals bar
                doc.setFillColor(248, 250, 252);
                doc.roundedRect(10, finalY, pageW - 20, 16, 3, 3, 'F');
                doc.setDrawColor(220, 220, 230);
                doc.roundedRect(10, finalY, pageW - 20, 16, 3, 3, 'S');

                doc.setFontSize(8);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(0, 108, 74);
                doc.text('Total Entrées: ' + fmtNum(totalIn) + ' MAD', 16, finalY + 10);
                doc.setTextColor(190, 30, 30);
                doc.text('Total Sorties: ' + fmtNum(totalOut) + ' MAD', 100, finalY + 10);
                doc.setTextColor(11, 17, 32);
                doc.text('Solde Net: ' + fmtNum(totalIn - totalOut) + ' MAD', 190, finalY + 10);
                doc.setTextColor(130, 130, 150);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(7);
                doc.text(allTransactionsForPdf.length + ' transactions au total', pageW - 60, finalY + 10);
            }

            doc.save(filename);
        }

        // ── Excel Export ──────────────────────────────────────────────────────
        function downloadExcel() {
            const source    = currentMode === 'weekly' ? weeklyData : monthlyData;
            const labelKey  = currentMode === 'weekly' ? 'Semaine' : 'Mois';

            const rows = source.labels.map((lbl, i) => ({
                [labelKey]:              lbl,
                'Encaissements (MAD)':   source.incoming[i],
                'Décaissements (MAD)':   source.outgoing[i],
                'Net (MAD)':             source.incoming[i] - source.outgoing[i],
            }));

            const ws = XLSX.utils.json_to_sheet(rows);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Trésorerie');
            XLSX.writeFile(wb, 'treasury-flux-' + new Date().toISOString().slice(0,10) + '.xlsx');
        }
    </script>
    @endpush
</x-app-layout>
