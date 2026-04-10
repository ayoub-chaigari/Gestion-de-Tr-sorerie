<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-black text-slate-800 italic uppercase tracking-tight">Générer un Bordereau</h1>
                <div class="px-4 py-2 bg-slate-100 rounded-2xl text-[10px] font-black text-slate-500 uppercase tracking-widest border border-slate-200">
                    Bordereau de Remise en Banque
                </div>
            </div>

            @if($errors->any())
                <div class="mb-8 p-6 bg-rose-50 border-l-4 border-rose-500 rounded-2xl">
                    <div class="flex items-center gap-3 text-rose-800 font-bold mb-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Erreur de validation
                    </div>
                    <ul class="text-sm text-rose-600 font-medium list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('remittances.generate') }}" method="POST" id="remittanceForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Config Panel -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100 sticky top-8">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Compte de Recette</label>
                                    <select name="bank_account_id" id="bankSelector" required onchange="filterTable()" class="w-full border-slate-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4 bg-slate-50 font-bold text-slate-800 transition-all border-2">
                                        <option value="" disabled selected>Choisir un compte...</option>
                                        @foreach($bankAccounts as $account)
                                            <option value="{{ $account->id }}" data-bank-name="{{ $account->bank_name }}">{{ $account->bank_name }} ({{ substr($account->rib, -8) }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Filtrer par Banque (Émetteur)</label>
                                    <select id="drawerBankFilter" onchange="filterTable()" class="w-full border-slate-200 rounded-2xl shadow-sm focus:ring-slate-500 focus:border-slate-500 p-4 bg-white font-bold text-slate-800 transition-all border-2">
                                        <option value="">TOUTES LES BANQUES</option>
                                        @foreach($drawerBanks as $bank)
                                            <option value="{{ $bank }}">{{ $bank }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Type d'Éléments</label>
                                    <select name="type" id="typeSelector" required onchange="filterTable()" class="w-full border-blue-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4 bg-blue-50 font-black text-blue-700 transition-all border-2">
                                        <option value="cheque">RÉCAPITULATIF CHÈQUES</option>
                                        <option value="effect">RÉCAPITULATIF EFFETS</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Date du Dépôt</label>
                                    <input type="date" name="remittance_date" value="{{ date('Y-m-d') }}" required class="w-full border-slate-200 rounded-2xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4 bg-slate-50 font-bold">
                                </div>

                                <div class="pt-6 border-t border-slate-100">
                                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white px-8 py-5 rounded-[2rem] font-black shadow-2xl transition-all active:scale-95 flex items-center justify-center gap-3 text-xs uppercase tracking-[0.2em]">
                                        Générer le bordereau
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Titles Table -->
                    <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h2 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">Sélection des Titres</h2>
                            <div class="flex items-center gap-2">
                                <span class="text-[9px] font-black text-slate-400 uppercase">Tout sélectionner</span>
                                <input type="checkbox" onclick="toggleAll(this)" class="h-5 w-5 text-blue-600 border-slate-300 rounded-lg focus:ring-blue-500 border-2">
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100" id="titresTable">
                                <thead>
                                    <tr class="bg-white">
                                        <th class="px-8 py-4 w-10"></th>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Échéance</th>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Référence</th>
                                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Montant</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($pendingCheques as $cheque)
                                        <tr class="hover:bg-slate-50/50 transition-all titre-row" 
                                            data-is-effect="{{ $cheque->is_effect ? 'true' : 'false' }}"
                                            data-bank-name="{{ $cheque->bank_name }}">
                                            <td class="px-8 py-5">
                                                <input type="checkbox" name="cheque_ids[]" value="{{ $cheque->id }}" class="h-5 w-5 text-blue-600 border-slate-300 rounded-lg focus:ring-blue-500 border-2">
                                            </td>
                                            <td class="px-8 py-5">
                                                @if($cheque->is_effect)
                                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-[9px] font-black rounded-full uppercase">Effet</span>
                                                @else
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-full uppercase">Chèque</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-5 text-xs font-bold text-slate-500">
                                                {{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="text-xs font-black text-slate-800 font-mono tracking-tighter">{{ $cheque->cheque_number }}</div>
                                                <div class="text-[9px] font-bold text-slate-400 uppercase truncate max-w-[150px]">{{ $cheque->contact->name }}</div>
                                            </td>
                                            <td class="px-8 py-5 text-right font-black text-slate-900 text-sm">
                                                {{ number_format($cheque->amount, 2, ',', ' ') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-20 text-center">
                                                <div class="text-slate-300 italic text-sm">Désolé, aucun titre en attente n'a été trouvé.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>

    <script>
        function filterTable() {
            const selectedType = document.getElementById('typeSelector').value;
            const filterBank = document.getElementById('drawerBankFilter').value;
            const bankSelect = document.getElementById('bankSelector');
            const selectedDestBank = bankSelect.options[bankSelect.selectedIndex]?.dataset.bankName || '';
            
            const isEffectTarget = (selectedType === 'effect');
            const rows = document.querySelectorAll('.titre-row');
            
            rows.forEach(row => {
                const isEffectRow = (row.dataset.isEffect === 'true');
                const rowBank = row.dataset.bankName;
                
                // 1. Matches Type (Cheque/Effect)
                const matchesType = (isEffectRow === isEffectTarget);
                
                // 2. Matches Manual Bank Filter (or no filter)
                const matchesFilterBank = !filterBank || (rowBank === filterBank);
                
                const checkbox = row.querySelector('input[type="checkbox"]');

                if (matchesType && matchesFilterBank) {
                    row.style.display = 'table-row';
                    
                    // AUTO-SELECT logic: 
                    // If we choose a Destination Account, auto-check only the matching ones
                    if (selectedDestBank && rowBank === selectedDestBank) {
                        checkbox.checked = true;
                        row.classList.add('bg-blue-50/50');
                    }
                } else {
                    row.style.display = 'none';
                    checkbox.checked = false;
                    row.classList.remove('bg-blue-50/50');
                }
            });
        }

        function toggleAll(source) {
            const rows = document.querySelectorAll('.titre-row');
            
            rows.forEach(row => {
                // Only toggle if the row is currently VISIBLE (matches both type and bank filters)
                if (row.style.display !== 'none') {
                    const checkbox = row.querySelector('input[type="checkbox"]');
                    checkbox.checked = source.checked;
                    if (source.checked) {
                        row.classList.add('bg-blue-50/50');
                    } else {
                        row.classList.remove('bg-blue-50/50');
                    }
                }
            });
        }

        // Initialize table filter on load
        document.addEventListener('DOMContentLoaded', filterTable);
    </script>
</x-app-layout>
