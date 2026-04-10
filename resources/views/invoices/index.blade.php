<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-slate-800 font-display italic tracking-tight">Factures Fournisseurs</h1>
            <a href="{{ route('invoices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 font-bold transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouvelle Facture
            </a>
        </div>

        <!-- Search Bar & Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-8">
            <form action="{{ route('invoices.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par référence, fournisseur..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-medium bg-slate-50 placeholder-slate-400">
                </div>
                
                <div class="md:w-64">
                    <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-medium bg-slate-50 text-slate-700">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En cours</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Réglée</option>
                        <option value="at_risk" {{ request('status') === 'at_risk' ? 'selected' : '' }}>À risque</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>En retard (Loi 69-21)</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-md active:scale-95">
                    Filtrer
                </button>
                
                @if(request()->has('search') && request('search') != '' || request()->has('status') && request('status') != '')
                    <a href="{{ route('invoices.index') }}" class="px-6 py-3 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Effacer
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Référence / Fournisseur</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Date / Échéance</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Montant Total</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Payé / Reste</th>
                            <th class="px-6 py-4 text-center text-xs font-black text-slate-500 uppercase tracking-widest">Status Compliance</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $invoice)
                            @php
                                $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($invoice->due_date)) && $invoice->status !== 'paid';
                                $isAtRisk = \Carbon\Carbon::now()->addDays(7)->gt(\Carbon\Carbon::parse($invoice->due_date)) && !$isOverdue && $invoice->status !== 'paid';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $invoice->reference }}</div>
                                    <div class="text-xs text-slate-500 font-medium">{{ $invoice->supplier->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-slate-600">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</div>
                                    <div class="text-[10px] font-black {{ $isOverdue ? 'text-red-500' : 'text-slate-400' }} uppercase">Dû le {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-black text-slate-900">{{ number_format($invoice->amount, 2) }} MAD</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-xs font-bold text-emerald-600">{{ number_format($invoice->paid_amount, 2) }}</div>
                                    <div class="text-sm font-black text-slate-500">{{ number_format($invoice->remaining_amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($invoice->status === 'paid')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-full uppercase">Réglée</span>
                                    @elseif($isOverdue)
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase animate-pulse">Loi 69-21: Retard</span>
                                    @elseif($isAtRisk)
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black rounded-full uppercase">À Risque</span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black rounded-full uppercase">En cours</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right flex items-center justify-end gap-3 font-bold text-xs uppercase underline">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-slate-400 hover:text-slate-600 no-underline">Détails</a>
                                    
                                    @if($invoice->remaining_amount > 0)
                                        <button onclick="openCashModal({{ $invoice->id }}, '{{ $invoice->reference }}', {{ $invoice->remaining_amount }})" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl shadow-md shadow-emerald-100 no-underline transition-all active:scale-95 flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Encaisser
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium italic">Aucune facture enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Cash Modal -->
    <div id="quick-cash-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden border border-slate-200">
            <form id="quick-cash-form" action="" method="POST">
                @csrf
                <input type="hidden" name="method" value="cash">
                <div class="p-8 bg-emerald-600 text-white">
                    <h3 class="text-xl font-black italic">Encaisser en Espèces</h3>
                    <p class="text-emerald-100 text-[10px] font-bold uppercase mt-1 tracking-widest" id="modal-invoice-ref">Facture #---</p>
                </div>
                <div class="p-8 space-y-5">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Montant à Encaisser (MAD)</label>
                        <input type="number" name="amount" id="modal-cash-amount" step="0.01" min="0.01" required 
                               class="w-full text-2xl font-black border-slate-200 rounded-2xl p-4 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Date de Règlement</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required 
                               class="w-full text-sm font-bold border-slate-200 rounded-2xl p-4 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                    </div>
                </div>
                <div class="p-8 bg-slate-50 flex gap-3">
                    <button type="button" onclick="document.getElementById('quick-cash-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="flex-1 bg-emerald-600 text-white px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-200 active:scale-95 transition-all">Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCashModal(invoiceId, reference, remaining) {
            const modal = document.getElementById('quick-cash-modal');
            const form = document.getElementById('quick-cash-form');
            const refText = document.getElementById('modal-invoice-ref');
            const amountInput = document.getElementById('modal-cash-amount');

            form.action = `/invoices/${invoiceId}/payments`;
            refText.innerText = `Facture #${reference}`;
            amountInput.value = remaining;
            amountInput.max = remaining;
            
            modal.classList.remove('hidden');
        }
    </script>
</x-app-layout>
