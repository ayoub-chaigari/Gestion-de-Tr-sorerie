<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">Paiements Émis (Sortants)</h1>
            <a href="{{ route('outgoing-cheques.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Émettre un chèque
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">N° Chèque / Carnet</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Bénéficiaire (Fournisseur)</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Date Échéance</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Banque Émettrice</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Montant TTC</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($outgoingCheques as $cheque)
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-indigo-500">
                                <td class="px-6 py-5">
                                    <div class="font-black text-slate-900 font-mono tracking-tighter text-lg">{{ $cheque->cheque_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Carnet n°{{ $cheque->cheque_book_id }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-800">{{ $cheque->contact->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium">IF: {{ $cheque->contact->if ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-black text-slate-600">{{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-700">{{ $cheque->chequeBook->bankAccount->bank_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono tracking-tighter">RIB: ...{{ substr($cheque->chequeBook->bankAccount->rib, -8) }}</div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="font-black text-slate-900">{{ number_format($cheque->amount, 2) }} <span class="text-[10px] text-slate-400 ml-1 uppercase">MAD</span></div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <form action="{{ route('outgoing-cheques.status', $cheque->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-[10px] font-black border-slate-200 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8 cursor-pointer bg-slate-50 uppercase tracking-widest">
                                            <option value="pending" {{ $cheque->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="paid" {{ $cheque->status === 'paid' ? 'selected' : '' }}>Payé</option>
                                            <option value="unpaid" {{ $cheque->status === 'unpaid' ? 'selected' : '' }}>Rejeté</option>
                                        </select>
                                    </form>
                                    @if($cheque->invoice_id)
                                        <div class="mt-2 text-[9px] text-blue-500 font-bold uppercase tracking-tight">
                                            Lié à: {{ $cheque->invoice->reference ?? 'Fct #'.$cheque->invoice_id }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400 font-medium italic bg-slate-50/30">
                                    <svg class="mx-auto h-12 w-12 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Aucun chèque émis pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($outgoingCheques->hasPages())
                <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                    {{ $outgoingCheques->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
