<x-app-layout>
    <div class="px-8 py-10 bg-slate-50 min-h-screen">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 italic tracking-tighter uppercase leading-none">Surveillance <span class="text-blue-600">Globale</span> : Tiers</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Répertoire Global des Clients & Fournisseurs SaaS</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('superadmin.oversight.cheques') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-blue-600 transition-all shadow-sm">Chèques</a>
                <a href="{{ route('superadmin.oversight.invoices') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-blue-600 transition-all shadow-sm">Factures</a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-[2rem] p-8 shadow-xl border border-slate-100 mb-8">
            <form action="{{ route('superadmin.oversight.contacts') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest pl-1">Recherche (Nom, ICE, Identifiant...)</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Ex: Entreprise SARL..." 
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
                    Recherche Plateforme
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-left border-b border-slate-50">
                            <th class="py-6 px-8 bg-slate-50/50">Details Tiers</th>
                            <th class="py-6 px-4 bg-slate-50/50">Locataire Responsable</th>
                            <th class="py-6 px-4 bg-slate-50/50">Type</th>
                            <th class="py-6 px-4 bg-slate-50/50">Ville / Contact</th>
                            <th class="py-6 px-8 text-right bg-slate-50/50">Identifiants Légaux</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($contacts as $contact)
                            <tr class="group hover:bg-blue-50/30 transition-all">
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center font-black group-hover:bg-blue-600 group-hover:text-white transition-all">
                                            {{ substr($contact->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900">{{ $contact->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $contact->email ?? 'Aucun email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-4">
                                    <span class="text-xs font-black text-slate-500">
                                        {{ $contact->company->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-6 px-4">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        {{ $contact->type === 'supplier' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $contact->type === 'supplier' ? 'Fournisseur' : 'Client' }}
                                    </span>
                                </td>
                                <td class="py-6 px-4">
                                    <p class="text-xs font-bold text-slate-700">{{ $contact->city ?? 'N/A' }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 italic">{{ $contact->phone ?? 'N/A' }}</p>
                                </td>
                                <td class="py-6 px-8 text-right font-mono text-[10px] font-black text-slate-500">
                                    ICE: {{ $contact->ice ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-slate-400 font-medium italic">Aucun tiers trouvé dans le répertoire global.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
