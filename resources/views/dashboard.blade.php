<x-app-layout>
    <div class="px-4 py-8 sm:px-0">
        
        @if(auth()->user()->role === 'SUPER_ADMIN' && $platformStats)
        <!-- SuperAdmin Platform Stats -->
        <div class="mb-12">
            <h2 class="text-xs font-black text-blue-600 uppercase tracking-[0.3em] mb-6 animate-pulse">Infrastructure Platform Control</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl border border-slate-800 transform hover:scale-[1.02] transition-all">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Total Entreprises</div>
                    <div class="text-4xl font-black text-white italic tracking-tighter">{{ $platformStats['total_companies'] }}</div>
                    <div class="mt-4 h-1 w-12 bg-blue-500 rounded-full"></div>
                </div>
                <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl border border-slate-800 transform hover:scale-[1.02] transition-all">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Utilisateurs Actifs</div>
                    <div class="text-4xl font-black text-white italic tracking-tighter">{{ $platformStats['total_users'] }}</div>
                    <div class="mt-4 h-1 w-12 bg-emerald-500 rounded-full"></div>
                </div>
                <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl border border-slate-800 transform hover:scale-[1.02] transition-all">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Volume Global (Encaissements)</div>
                    <div class="text-2xl font-black text-white italic tracking-tighter">{{ number_format($platformStats['global_volume'], 2) }} <span class="text-xs">MAD</span></div>
                    <div class="mt-4 h-1 w-12 bg-amber-500 rounded-full"></div>
                </div>
            </div>
        </div>
        <hr class="border-slate-200 mb-12 border-dashed">
        @endif

        <!-- Company Financial Stats -->
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Trésorerie de l'entreprise</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <!-- En Cours -->
            <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-bl-[3rem] flex items-center justify-center transition-all group-hover:scale-110">
                    <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="text-slate-400 text-[9px] font-black uppercase tracking-widest mb-1">En Cours d'Encaissement</div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($enCours, 2) }} <span class="text-[10px] font-bold text-slate-400">MAD</span></div>
                <p class="text-[9px] text-amber-600 font-bold mt-2 uppercase tracking-tighter">Remis à la banque</p>
            </div>

            <!-- Encaissements -->
            <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-bl-[3rem] flex items-center justify-center transition-all group-hover:scale-110">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div class="text-slate-400 text-[9px] font-black uppercase tracking-widest mb-1">Total Recettes</div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($encaissements, 2) }} <span class="text-[10px] font-bold text-slate-400">MAD</span></div>
                <p class="text-[9px] text-emerald-600 font-bold mt-2 uppercase tracking-tighter">Flux Entrant Réel (Payé)</p>
            </div>

            <!-- Décaissements -->
            <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-slate-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-20 h-20 bg-rose-50 rounded-bl-[3rem] flex items-center justify-center transition-all group-hover:scale-110">
                    <svg class="w-6 h-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                </div>
                <div class="text-slate-400 text-[9px] font-black uppercase tracking-widest mb-1">Total Dépenses</div>
                <div class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($decaissements, 2) }} <span class="text-[10px] font-bold text-slate-400">MAD</span></div>
                <p class="text-[9px] text-rose-600 font-bold mt-2 uppercase tracking-tighter">Paiements Sortants</p>
            </div>

            <!-- Solde Net -->
            <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-blue-100 relative overflow-hidden group ring-4 ring-blue-50/50">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-bl-[3rem] flex items-center justify-center transition-all group-hover:scale-110">
                    <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="text-slate-400 text-[9px] font-black uppercase tracking-widest mb-1">Situation Nette</div>
                <div class="text-2xl font-black text-blue-600 tracking-tight">{{ number_format($soldeNet, 2) }} <span class="text-[10px] font-bold text-slate-400">MAD</span></div>
                <p class="text-[9px] text-blue-600 font-bold mt-2 uppercase tracking-tighter italic">Solde Réel Actuel</p>
            </div>
        </div>

        <!-- Real-time Visualization & History -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Chart Section -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-10 shadow-2xl border border-slate-100 flex flex-col">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-xl font-black text-slate-800 italic">Évolution de la Trésorerie</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Flux monétaires des 6 derniers mois</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('exports.print') }}" target="_blank" class="px-5 py-2.5 bg-slate-50 border border-slate-200 text-slate-500 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Exporter PDF
                        </a>
                        <a href="{{ route('exports.csv') }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Rapport Excel
                        </a>
                    </div>
                </div>
                <div class="flex-1 min-h-[350px]">
                    <canvas id="treasuryChart"></canvas>
                </div>
            </div>

            <!-- Historique Transactions Feed -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl border border-slate-100 flex flex-col h-[500px]">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-800 italic">Historique Récent</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Derniers mouvements (Entrées / Sorties)</p>
                </div>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                    @forelse($recentTransactions as $tx)
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
                            @if($tx->type === 'in')
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" /></svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" /></svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-black text-slate-900 truncate" title="{{ $tx->description }}">{{ $tx->description }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">{{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs font-black {{ $tx->type === 'in' ? 'text-emerald-600' : 'text-slate-900' }}">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                                </p>
                                @if($tx->status === 'deposited')
                                    <span class="text-[8px] px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-md font-bold uppercase mt-1 inline-block">Remis</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-400 italic text-xs">
                            Aucun mouvement récent
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Compliance & Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Overdue Invoices -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-red-100 overflow-hidden">
                <div class="px-6 py-5 bg-red-50 border-b border-red-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xs font-black text-red-700 uppercase tracking-widest">En Retard</h3>
                        <p class="text-[9px] text-red-400 font-bold uppercase mt-0.5">Loi 69-21 · Pénalités Encourues</p>
                    </div>
                    <span class="bg-red-600 text-white text-[9px] font-black px-2.5 py-1 rounded-full">{{ $overdueInvoices->count() }}</span>
                </div>
                <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50">
                    @forelse($overdueInvoices as $invoice)
                        <div class="p-5 hover:bg-red-50/30 transition-colors">
                            <div class="font-black text-slate-900 text-sm leading-tight">{{ $invoice->supplier->name }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Échu le {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                            <div class="font-black text-red-600 mt-2">{{ number_format($invoice->remaining_amount, 2) }} MAD</div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic text-xs">✓ Aucune facture en retard</div>
                    @endforelse
                </div>
            </div>

            <!-- At Risk Invoices -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-amber-100 overflow-hidden">
                <div class="px-6 py-5 bg-amber-50 border-b border-amber-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xs font-black text-amber-700 uppercase tracking-widest">À Risque</h3>
                        <p class="text-[9px] text-amber-400 font-bold uppercase mt-0.5">Échéance dans les 7 prochains jours</p>
                    </div>
                    <span class="bg-amber-500 text-white text-[9px] font-black px-2.5 py-1 rounded-full">{{ $atRiskInvoices->count() }}</span>
                </div>
                <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50">
                    @forelse($atRiskInvoices as $invoice)
                        <div class="p-5 hover:bg-amber-50/30 transition-colors">
                            <div class="font-black text-slate-900 text-sm leading-tight">{{ $invoice->supplier->name }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="text-[9px] text-amber-600 font-black uppercase">Dû le {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                                <div class="text-[9px] bg-amber-100 text-amber-700 font-black px-2 py-0.5 rounded-full uppercase">
                                    dans {{ \Carbon\Carbon::now()->diffInDays($invoice->due_date) }}j
                                </div>
                            </div>
                            <div class="font-black text-amber-700 mt-2">{{ number_format($invoice->remaining_amount, 2) }} MAD</div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic text-xs">✓ Aucune facture à risque</div>
                    @endforelse
                </div>
            </div>

            <!-- Unpaid Cheques -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-orange-100 overflow-hidden">
                <div class="px-6 py-5 bg-orange-50 border-b border-orange-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xs font-black text-orange-700 uppercase tracking-widest">Chèques Impayés</h3>
                        <p class="text-[9px] text-orange-400 font-bold uppercase mt-0.5">Titres rejetés en attente</p>
                    </div>
                    <span class="bg-orange-500 text-white text-[9px] font-black px-2.5 py-1 rounded-full">{{ $unpaidCheques->count() }}</span>
                </div>
                <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50">
                    @forelse($unpaidCheques as $cheque)
                        <div class="p-5 hover:bg-orange-50/30 transition-colors">
                            <div class="font-black text-slate-900 text-sm">{{ $cheque->contact->name }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1 font-mono">N° {{ $cheque->cheque_number }}</div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="font-black text-orange-700">{{ number_format($cheque->amount, 2) }} MAD</div>
                                <form action="{{ route('rejections.create', $cheque->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[8px] bg-orange-100 text-orange-700 font-black uppercase px-2 py-1 rounded-lg border border-orange-200 hover:bg-orange-200 transition-all tracking-widest">
                                        → Contentieux
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-slate-400 italic text-xs">✓ Aucun chèque impayé</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('treasuryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($chartData, 'month')) !!},
                datasets: [
                    {
                        label: 'RECETTES',
                        data: {!! json_encode(array_column($chartData, 'incoming')) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 12,
                        barThickness: 25,
                        order: 2
                    },
                    {
                        label: 'DÉPENSES',
                        data: {!! json_encode(array_column($chartData, 'outgoing')) !!},
                        backgroundColor: '#f43f5e',
                        borderRadius: 12,
                        barThickness: 25,
                        order: 2
                    },
                    {
                        label: 'SOLDE CUMULÉ',
                        data: {!! json_encode(array_column($chartData, 'balance')) !!},
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        type: 'line',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: { family: 'Inter', weight: 'bold', size: 10 },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 12,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: { 
                            font: { size: 10, weight: 'bold' },
                            callback: function(value) { return value.toLocaleString() + ' DH'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' } }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
