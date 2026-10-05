<x-app-layout>
    <div class="space-y-10">
        
        <!-- Top Analytics Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tighter italic">Platform <span class="text-blue-600">Command</span> Center</h1>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-2">Infrastucture Multi-Locataire · Analyse en Temps Réel</p>
            </div>
            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
                <div class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    Cluster: Stable
                </div>
                <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest border-l border-gray-50 italic">
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>

        <!-- Metric Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Global Cash-In -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Total Encaissements Global</p>
                    <div class="flex items-end gap-3">
                        <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($globalEncaissements, 0) }}</h3>
                        <span class="text-xs font-bold text-gray-400 mb-2 uppercase">MAD</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-lg">↑ 12% Mensuel</span>
                        <span class="text-[9px] font-bold text-gray-400 uppercase">Flux Réel</span>
                    </div>
                </div>
            </div>

            <!-- Global Cash-Out -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-gray-50 rounded-full blur-2xl group-hover:bg-gray-100 transition-colors"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Total Décaissements Global</p>
                    <div class="flex items-end gap-3">
                        <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($globalDecaissements, 0) }}</h3>
                        <span class="text-xs font-bold text-gray-400 mb-2 uppercase">MAD</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-black rounded-lg">Neutral</span>
                        <span class="text-[9px] font-bold text-gray-400 uppercase">Sorties Infrastructure</span>
                    </div>
                </div>
            </div>

            <!-- Global Balance -->
            <div class="bg-[#0b1120] rounded-[2rem] p-8 shadow-2xl shadow-[#0b1120]/30 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-[#CDA833] uppercase tracking-widest mb-3">Solde de Trésorerie Net</p>
                    <div class="flex items-end gap-3">
                        <h3 class="text-4xl font-black text-white tracking-tighter">{{ number_format($globalSoldeNet, 0) }}</h3>
                        <span class="text-xs font-bold text-[#CDA833] mb-2 uppercase">MAD</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <div class="px-2 py-0.5 bg-[#CDA833]/20 text-[#CDA833] text-[9px] font-black rounded-lg backdrop-blur-md italic">Situation en Direct</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Global Flow -->
            <div class="lg:col-span-2 bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 flex flex-col min-h-[500px]">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-xl font-black text-gray-900 tracking-tight italic">Flux de Trésorerie Global</h2>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Analyse consolidée sur 6 mois d'activité</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-[#0b1120] rounded-full shadow-lg shadow-gray-200"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase">Entrées</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase">Sorties</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <canvas id="globalFlowChart"></canvas>
                </div>
            </div>

            <!-- Expense Source -->
            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 flex flex-col items-center">
                <div class="w-full mb-8 text-center">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight italic">Impact Locataires</h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Répartition du volume par entreprise</p>
                </div>
                <div class="flex-1 w-full max-w-[250px] flex items-center">
                    <canvas id="tenantImpactChart"></canvas>
                </div>
                <div class="mt-8 w-full space-y-3">
                    @foreach($topCompanies as $index => $company)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-2 h-2 rounded-full" style="background-color: {{ ['#0b1120', '#006C4A', '#CDA833', '#8b5cf6', '#ef4444'][$index] ?? '#cbd5e1' }}"></div>
                            <span class="text-[10px] font-black text-gray-900 hover:text-[#0b1120] cursor-default truncate">{{ $company->name }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">{{ number_format($company->volume, 0) }} MAD</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Activity Hub -->
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight italic">Direct Platform Activity</h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Derniers titres de paiement consolidés</p>
                </div>
                <a href="{{ route('superadmin.oversight.cheques') }}" class="px-6 py-2.5 bg-[#0b1120] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all">View All Activity</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-left border-b border-gray-50">
                            <th class="pb-6 px-4">Entity/Contact</th>
                            <th class="pb-6 px-4">Origin Company</th>
                            <th class="pb-6 px-4">Amount</th>
                            <th class="pb-6 px-4">Due Date</th>
                            <th class="pb-6 px-4 text-right">Status Badge</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($lastFiveCheques as $cheque)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="py-6 px-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center font-black text-[10px] group-hover:bg-[#006C4A] transition-colors">
                                        {{ strtoupper(substr($cheque->contact->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900">{{ $cheque->contact->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">N° {{ $cheque->cheque_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-4">
                                <span class="text-[10px] font-black text-[#006C4A] bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100 uppercase tracking-tighter">
                                    {{ $cheque->company->name }}
                                </span>
                            </td>
                            <td class="py-6 px-4">
                                <p class="text-sm font-black text-gray-900">{{ number_format($cheque->amount, 2) }}</p>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">MAD</p>
                            </td>
                            <td class="py-6 px-4">
                                <p class="text-xs font-bold text-gray-600">{{ $cheque->due_date ? $cheque->due_date->format('d/m/Y') : 'N/A' }}</p>
                            </td>
                            <td class="py-6 px-4 text-right">
                                @php
                                    $statusClasses = [
                                        'paid' => 'bg-emerald-100 text-emerald-700',
                                        'deposited' => 'bg-amber-100 text-amber-700',
                                        'unpaid' => 'bg-rose-100 text-rose-700',
                                        'endorsed' => 'bg-purple-100 text-purple-700',
                                    ];
                                    $statusLabels = [
                                        'paid' => 'Payé',
                                        'deposited' => 'En attente',
                                        'unpaid' => 'Impayé',
                                        'endorsed' => 'Endossé',
                                    ];
                                    $cls = $statusClasses[$cheque->status] ?? 'bg-gray-100 text-gray-600';
                                    $lbl = $statusLabels[$cheque->status] ?? $cheque->status;
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $cls }}">
                                    {{ $lbl }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Flow Chart
        new Chart(document.getElementById('globalFlowChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'month')) !!},
                datasets: [{
                    label: 'Global Cash-In',
                    data: {!! json_encode(array_column($chartData, 'incoming')) !!},
                    borderColor: '#0b1120',
                    backgroundColor: 'rgba(11, 17, 32, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2
                }, {
                    label: 'Global Cash-Out',
                    data: {!! json_encode(array_column($chartData, 'outgoing')) !!},
                    borderColor: '#e2e8f0',
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' }, ticks: { font: { size: 9, weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' } } }
                }
            }
        });

        // Tenant Impact Chart
        new Chart(document.getElementById('tenantImpactChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($topCompanies->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($topCompanies->pluck('volume')) !!},
                    backgroundColor: ['#0b1120', '#006C4A', '#CDA833', '#8b5cf6', '#ef4444'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endpush
</x-app-layout>
