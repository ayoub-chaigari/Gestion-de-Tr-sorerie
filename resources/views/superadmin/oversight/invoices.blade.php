<x-app-layout>
    <div class="px-8 py-10 bg-slate-50 min-h-screen">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 italic tracking-tighter uppercase leading-none">Surveillance <span class="text-blue-600">Globale</span> : Factures</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Contrôle de l'Endettement Locataire & Conformité Loi 69-21</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('superadmin.oversight.cheques') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-blue-600 transition-all shadow-sm">Chèques</a>
                <a href="{{ route('superadmin.oversight.contacts') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-blue-600 transition-all shadow-sm">Contacts</a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-slate-100 mb-8">
            <form action="{{ route('superadmin.oversight.invoices') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest pl-1">Recherche (N° Facture, Fournisseur...)</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Ex: INV-2024-..." 
                           class="w-full border-slate-100 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 bg-slate-50/50 shadow-sm transition-all focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest pl-1">Entreprise Locataire</label>
                    <select name="company_id" class="w-full border-slate-100 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 bg-slate-50/50 shadow-sm transition-all focus:border-blue-500">
                        <option value="">Tous les locataires</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-slate-900 text-white p-4 rounded-2xl font-black shadow-lg shadow-blue-200 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase text-[10px] tracking-widest">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Audit Infrastructure
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-left border-b border-slate-50">
                            <th class="py-6 px-8 bg-slate-50/50">N° Facture</th>
                            <th class="py-6 px-4 bg-slate-50/50">Propriétaire</th>
                            <th class="py-6 px-4 bg-slate-50/50">Fournisseur</th>
                            <th class="py-6 px-4 bg-slate-50/50">Montant Total</th>
                            <th class="py-6 px-4 bg-slate-50/50">Dû à l'échéance</th>
                            <th class="py-6 px-8 text-right bg-slate-50/50">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($invoices as $invoice)
                            <tr class="group hover:bg-blue-50/30 transition-all">
                                <td class="py-6 px-8 font-black text-sm text-slate-900">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="py-6 px-4">
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-tight">
                                        {{ $invoice->company->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-6 px-4">
                                    <p class="text-xs font-bold text-slate-700">{{ $invoice->supplier->name ?? 'N/A' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 italic">CREE LE: {{ $invoice->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td class="py-6 px-4 font-black text-sm text-slate-900">
                                    {{ number_format($invoice->amount, 2) }} MAD
                                </td>
                                <td class="py-6 px-4">
                                    <p class="text-xs font-black {{ $invoice->due_date && $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-600' : 'text-slate-600' }}">
                                        {{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </td>
                                <td class="py-6 px-8 text-right">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        {{ $invoice->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 
                                           ($invoice->status === 'unpaid' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $invoice->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center text-slate-400 font-medium italic">Aucune facture détectée sur la plateforme.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
