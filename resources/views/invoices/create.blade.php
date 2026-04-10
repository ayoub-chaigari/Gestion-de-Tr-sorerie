<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-800 mb-8 font-display">Saisie Facture Fournisseur</h1>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <form action="{{ route('invoices.store') }}" method="POST" class="p-8 space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Supplier Selection -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Fournisseur (Tiers)</label>
                        <select name="supplier_id" required class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Sélectionner un fournisseur...</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }} (IF: {{ $supplier->if }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reference -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">N° de Facture (Référence)</label>
                        <input type="text" name="reference" required placeholder="Ex: FAC-2026-0123"
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Amount -->
                    <div class="space-y-4 md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Montant TTC (MAD)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required 
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-lg font-bold" 
                               placeholder="0.00">
                    </div>

                    <!-- Invoice Date -->
                    <div class="space-y-4 md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Date Facture</label>
                        <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required 
                               class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    </div>

                    <!-- Delay Days -->
                    <div class="space-y-4 md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Délai (jours)</label>
                        <div class="relative">
                            <input type="number" name="delay_days" value="60" required 
                                   class="w-full border-slate-300 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 pr-12 font-bold">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">J</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Conformité Loi 69-21</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-4">
                    <a href="{{ route('invoices.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Enregistrer la facture
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
