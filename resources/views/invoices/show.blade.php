<x-app-layout>
    <div class="px-4 py-8 sm:px-0 max-w-5xl mx-auto">
        <!-- Back Button & Title -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('invoices.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 font-display italic tracking-tight">Facture #{{ $invoice->reference }}</h1>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">{{ $invoice->supplier->name }}</p>
                </div>
            </div>
            <div class="flex gap-3">
                @if($invoice->remaining_amount > 0)
                    <button onclick="document.getElementById('payment-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 font-black text-xs uppercase transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Nouveau Règlement
                    </button>
                @endif
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Montant Total</p>
                <p class="text-2xl font-black text-slate-900">{{ number_format($invoice->amount, 2) }} <span class="text-sm text-slate-400">MAD</span></p>
            </div>
            <div class="bg-emerald-50 p-6 rounded-3xl shadow-sm border border-emerald-100">
                <p class="text-[10px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Montant Payé</p>
                <p class="text-2xl font-black text-emerald-600">{{ number_format($invoice->paid_amount, 2) }} <span class="text-sm">MAD</span></p>
            </div>
            <div class="bg-slate-900 p-6 rounded-3xl shadow-xl shadow-slate-200">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Reste à Payer</p>
                <p class="text-2xl font-black text-white">{{ number_format($invoice->remaining_amount, 2) }} <span class="text-sm text-slate-500">MAD</span></p>
            </div>
        </div>

        <!-- Payment History -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-800 italic">Historique des Règlements</h3>
                <span class="px-3 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase">{{ $invoice->payments->count() }} Transaction(s)</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/30">
                        <tr>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Méthode</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Référence / Détails</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Montant</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($invoice->payments as $payment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5 text-sm font-bold text-slate-600">
                                    {{ $payment->payment_date->format('d/m/Y') }}
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $methodColors = [
                                            'cash' => 'bg-amber-100 text-amber-700',
                                            'virement' => 'bg-blue-100 text-blue-700',
                                            'cheque' => 'bg-purple-100 text-purple-700',
                                            'endorsed' => 'bg-fuchsia-100 text-fuchsia-700',
                                            'effet' => 'bg-indigo-100 text-indigo-700',
                                        ];
                                        $methodLabels = [
                                            'cash' => 'Espèces',
                                            'virement' => 'Virement',
                                            'cheque' => 'Chèque',
                                            'endorsed' => 'Chèque Endossé',
                                            'effet' => 'Effet',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $methodColors[$payment->method] ?? 'bg-slate-100' }}">
                                        {{ $methodLabels[$payment->method] ?? $payment->method }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($payment->payable)
                                        <div class="text-sm font-black text-slate-700">
                                            {{ $payment->method === 'cheque' ? 'Chèque N° ' . $payment->payable->cheque_number : 'Effet N° ' . $payment->payable->effet_number }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase">Échéance: {{ $payment->payable->due_date->format('d/m/Y') }}</div>
                                    @else
                                        <div class="text-sm font-medium text-slate-500 italic">Paiement Direct</div>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right font-black text-slate-900">
                                    {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <form action="{{ route('invoices.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Supprimer ce règlement ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-bold italic">Aucun règlement enregistré pour cette facture.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="payment-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200">
            <form action="{{ route('invoices.payments.store', $invoice) }}" method="POST">
                @csrf
                <div class="p-8 bg-blue-600">
                    <h3 class="text-2xl font-black text-white italic">Nouveau Règlement</h3>
                    <p class="text-blue-100 text-xs font-bold uppercase mt-1 tracking-widest">Compléter le paiement de la facture</p>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Montant (MAD)</label>
                            <input type="number" name="amount" step="0.01" max="{{ $invoice->remaining_amount }}" value="{{ $invoice->remaining_amount }}" required 
                                   class="w-full text-xl font-black border-slate-200 rounded-2xl p-4 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Date Règlement</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required 
                                   class="w-full text-sm font-bold border-slate-200 rounded-2xl p-4 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Méthode de Paiement</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label for="method_cash" class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="method" id="method_cash" value="cash" class="sr-only" checked onclick="toggleMethodFields('cash')">
                                <span class="text-xs font-black uppercase text-slate-600">Espèces</span>
                            </label>
                            <label for="method_virement" class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="method" id="method_virement" value="virement" class="sr-only" onclick="toggleMethodFields('virement')">
                                <span class="text-xs font-black uppercase text-slate-600">Virement</span>
                            </label>
                            <label for="method_cheque" class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="method" id="method_cheque" value="cheque" class="sr-only" onclick="toggleMethodFields('cheque')">
                                <span class="text-xs font-black uppercase text-slate-600">Chèque</span>
                            </label>
                            <label for="method_effet" class="relative flex items-center justify-center p-4 border-2 rounded-2xl cursor-pointer transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                                <input type="radio" name="method" id="method_effet" value="effet" class="sr-only" onclick="toggleMethodFields('effet')">
                                <span class="text-xs font-black uppercase text-slate-600">Effet</span>
                            </label>
                        </div>
                    </div>

                    <!-- Dynamic Fields for Cheque/Effet -->
                    <div id="extra-fields" class="hidden space-y-4 pt-4 border-t border-slate-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">N° Réf</label>
                                <input type="text" name="reference_number" placeholder="Ex: 1234567" 
                                       class="w-full text-sm font-bold border-slate-200 rounded-2xl p-4">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Échéance</label>
                                <input type="date" name="due_date" value="{{ date('Y-m-d') }}" 
                                       class="w-full text-sm font-bold border-slate-200 rounded-2xl p-4">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Notes (Optionnel)</label>
                        <textarea name="notes" rows="2" class="w-full text-sm font-bold border-slate-200 rounded-2xl p-4" placeholder="Détails supplémentaires..."></textarea>
                    </div>
                </div>

                <div class="p-8 bg-slate-50 flex gap-4">
                    <button type="button" onclick="document.getElementById('payment-modal').classList.add('hidden')" class="flex-1 px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600">Annuler</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-4 rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-blue-200 active:scale-95 transition-all">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleMethodFields(method) {
            const extraFields = document.getElementById('extra-fields');
            if (method === 'cheque' || method === 'effet') {
                extraFields.classList.remove('hidden');
            } else {
                extraFields.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-app-layout>
