<x-app-layout>
    <div class="px-4 py-8 sm:px-0 max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 italic uppercase tracking-tighter">
                    Bordereau de Remise {{ $remittance->type === 'effect' ? "d'Effets" : "de Chèques" }}
                </h1>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1 italic">Document Officiel de Transmission en Banque</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('remittances.index') }}" class="px-6 py-2.5 bg-white border-2 border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all text-[10px] uppercase tracking-widest">Retour</a>
                <a href="{{ route('remittances.bank-export', $remittance->id) }}" target="_blank" class="px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:bg-emerald-700 transition-all text-[10px] uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Bancaire (9 Cols)
                </a>
                <button onclick="window.print()" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-2xl shadow-xl hover:bg-black transition-all text-[10px] uppercase tracking-widest flex items-center gap-2 border-2 border-slate-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Imprimer (Ctrl+P)
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 print:block">
            <!-- Summary Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Référence</div>
                    <div class="text-xl font-black text-slate-900 font-mono tracking-tighter mb-6">{{ $remittance->reference }}</div>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Banque de Dépôt</span>
                            <span class="text-sm font-black text-slate-800">{{ $remittance->bankAccount->bank_name }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">RIB</span>
                            <span class="text-[10px] font-mono font-bold text-slate-600 tracking-tighter">{{ $remittance->bankAccount->rib }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Total Bordereau</span>
                            <span class="text-lg font-black text-blue-600">{{ number_format($remittance->total_amount, 2) }} MAD</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 p-8 rounded-[2.5rem] shadow-xl text-white">
                    <div class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-4">Statut de Transmission</div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                        <span class="text-sm font-black uppercase tracking-widest">En Banque (Deposited)</span>
                    </div>
                </div>
            </div>

            <!-- Titles List -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h2 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em]">Titres inclus dans ce bordereau</h2>
                        <span class="bg-slate-200 text-slate-700 text-[10px] font-black px-3 py-1 rounded-full uppercase">{{ $remittance->cheques->count() }} ELEMENTS</span>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="bg-slate-50/30">
                                    <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date Échéance</th>
                                    <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Numéro</th>
                                    <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tiers (Emetteur)</th>
                                    <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-sans">
                                @foreach($remittance->cheques as $cheque)
                                    <tr class="hover:bg-slate-50/50 transition-all">
                                        <td class="px-8 py-5 text-sm font-bold text-slate-600">
                                            {{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-8 py-5 text-sm font-black text-slate-900 font-mono tracking-tighter italic">
                                            {{ $cheque->cheque_number }}
                                        </td>
                                        <td class="px-8 py-5 text-sm font-bold text-slate-600 uppercase">
                                            {{ $cheque->contact->name }}
                                        </td>
                                        <td class="px-8 py-5 text-right font-black text-slate-900">
                                            {{ number_format($cheque->amount, 2) }} MAD
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-900 text-white">
                                <tr>
                                    <td colspan="3" class="px-8 py-6 text-right text-xs font-black uppercase tracking-widest text-slate-400">Total Général</td>
                                    <td class="px-8 py-6 text-right text-xl font-black italic">{{ number_format($remittance->total_amount, 2) }} MAD</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <div class="mt-8 p-8 border border-dashed border-slate-300 rounded-[2.5rem] bg-slate-50 italic text-slate-500 text-sm text-center">
                    "Ce document fait office de preuve de remise pour les titres listés ci-dessus à la banque {{ $remittance->bankAccount->bank_name }}."
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
