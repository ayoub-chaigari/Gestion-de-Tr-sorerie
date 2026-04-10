<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-800 mb-8 font-display">Émettre un Chèque Sortant</h1>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="p-8 bg-slate-50 border-b border-slate-200">
                <p class="text-slate-500 text-sm leading-relaxed">
                    Sélectionnez un fournisseur et un carnet de chèques disponible. Le système attribuera automatiquement le prochain numéro de chèque de la plage.
                </p>
            </div>

            <form action="{{ route('outgoing-cheques.store') }}" method="POST" class="p-8 space-y-8" id="cheque-form">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Supplier Selection -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Bénéficiaire (Fournisseur)</label>
                        <select name="contact_id" id="contact_id" required class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Sélectionner un fournisseur...</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }} (RC: {{ $supplier->rc }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Invoice Selection (Filtered by JS) -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Associer à une Facture (Optionnel)</label>
                        <select name="invoice_id" id="invoice_id" class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Aucune facture (Paiement libre)</option>
                            @foreach($invoices as $invoice)
                                <option value="{{ $invoice->id }}" data-supplier="{{ $invoice->supplier_id }}" data-amount="{{ $invoice->amount - $invoice->paid_amount }}" class="hidden">
                                    {{ $invoice->reference ?? 'Facture #'.$invoice->id }} - Reste: {{ number_format($invoice->amount - $invoice->paid_amount, 2) }} MAD
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Cheque Book / Bank Selection -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Compte & Carnet</label>
                        <select name="cheque_book_id" required class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Sélectionner un carnet...</option>
                            @foreach($chequeBooks as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->bankAccount->bank_name }} - Carnet n°{{ $book->id }} 
                                    (Prochain n°: {{ str_pad($book->current_number, 8, '0', STR_PAD_LEFT) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Date d'échéance</label>
                        <input type="date" name="due_date" required 
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Amount -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Montant (MAD)</label>
                        <div class="relative group">
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01" required 
                                   class="w-full border-slate-300 pl-12 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-lg font-bold" 
                                   placeholder="0.00">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">DH</span>
                        </div>
                        <p id="invoice-info" class="text-xs text-blue-600 font-bold hidden"></p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-4">
                    <a href="{{ route('outgoing-cheques.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Émettre le chèque
                    </button>
                </div>
            </form>

            <script>
                const contactSelect = document.getElementById('contact_id');
                const invoiceSelect = document.getElementById('invoice_id');
                const amountInput = document.getElementById('amount');
                const invoiceInfo = document.getElementById('invoice-info');
                const invoiceOptions = Array.from(invoiceSelect.options);

                contactSelect.addEventListener('change', function() {
                    const supplierId = this.value;
                    invoiceSelect.value = '';
                    invoiceInfo.classList.add('hidden');
                    
                    invoiceOptions.forEach(option => {
                        if (option.value === '' || option.dataset.supplier === supplierId) {
                            option.classList.remove('hidden');
                        } else {
                            option.classList.add('hidden');
                        }
                    });
                });

                invoiceSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const remainingAmount = selectedOption.dataset.amount;

                    if (remainingAmount) {
                        amountInput.value = remainingAmount;
                        invoiceInfo.textContent = `Paiement pour le reste à régler: ${remainingAmount} MAD`;
                        invoiceInfo.classList.remove('hidden');
                    } else {
                        invoiceInfo.classList.add('hidden');
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>
