<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">Gestion des Tiers</h1>
            <button onclick="document.getElementById('contact-modal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouveau Contact
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden font-sans">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nom / Type</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identifiant (ICE)</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Fiscal (IF) / RC</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contact / Ville</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-indigo-500">
                                <td class="px-6 py-5">
                                    <div class="font-black text-slate-900 text-lg">{{ $contact->name }}</div>
                                    <span class="px-2 py-0.5 {{ $contact->type === 'client' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} text-[9px] font-black rounded uppercase tracking-widest">
                                        {{ $contact->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-mono text-sm font-black text-slate-700 tracking-tighter">{{ $contact->ice }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase">Identifiant Commun Entreprise</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-700">IF: {{ $contact->if ?? '---' }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono tracking-tighter">RC: {{ $contact->rc }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-slate-600">{{ $contact->phone ?? 'Sans téléphone' }}</div>
                                    <div class="text-[10px] text-slate-400 truncate max-w-[150px]">{{ $contact->address ?? 'Adresse non spécifiée' }}</div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('contacts.edit', $contact->id) }}" class="text-slate-400 hover:text-indigo-600 transition-colors inline-block">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-slate-400 font-medium italic">Aucun contact enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Contact Create Modal -->
    <div id="contact-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200">
            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="p-8 bg-indigo-600">
                    <h3 class="text-2xl font-black text-white italic tracking-tight">Nouveau Tier</h3>
                    <p class="text-indigo-100 text-xs font-bold uppercase mt-1 tracking-widest">Enregistrement Client / Fournisseur</p>
                </div>
                <div class="p-8 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Classification</label>
                            <select name="type" required class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                                <option value="client">Client</option>
                                <option value="supplier">Fournisseur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Nom / Raison Sociale</label>
                            <input type="text" name="name" required class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Identifiant Commun (ICE) - 15 chiffres</label>
                        <input type="text" name="ice" required minlength="15" maxlength="15" pattern="[0-9]{15}" placeholder="000000000000000" class="w-full border-slate-200 rounded-xl p-3 font-mono text-sm font-bold focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Identifiant Fiscal (IF)</label>
                            <input type="text" name="if" maxlength="9" class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Registre Commerce (RC)</label>
                            <input type="text" name="rc" required class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Téléphone</label>
                            <input type="text" name="phone" class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Ville / Adresse</label>
                            <input type="text" name="address" class="w-full border-slate-200 rounded-xl p-3 text-sm font-bold focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                <div class="p-8 bg-slate-50 flex gap-4">
                    <button type="button" onclick="document.getElementById('contact-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:text-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-100">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
