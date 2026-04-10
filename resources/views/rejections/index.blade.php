<x-app-layout>
    <div class="px-4 py-8 sm:px-0 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic uppercase">Gestion des Contentieux & Impayés</h1>
            <div class="flex gap-4">
                <span class="bg-red-100 text-red-700 text-[10px] font-black px-4 py-2 rounded-full uppercase border border-red-200 shadow-sm">
                    Loi 69-21 Compliance Mode
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h2 class="text-sm font-black text-slate-600 uppercase tracking-[0.2em]">Dossiers en souffrance</h2>
                <div class="flex items-center gap-4">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Filtrer par:</div>
                    <select class="text-[10px] font-black uppercase tracking-widest border-slate-200 rounded-lg">
                        <option>Tous les dossiers</option>
                        <option>Au Tribunal</option>
                        <option>En Recouvrement</option>
                    </select>
                </div>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/30">
                        <tr>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Titre (Numéro)</th>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Client & Origine</th>
                            <th class="px-8 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Montant</th>
                            <th class="px-8 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Phase Juridique</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions de Recouvrement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($rejections as $rejection)
                            <tr class="hover:bg-slate-50/50 transition-all {{ $rejection->resolved ? 'opacity-50 grayscale' : '' }}">
                                <td class="px-8 py-5">
                                    <div class="text-sm font-black text-slate-900 font-mono tracking-tighter">{{ $rejection->cheque->cheque_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $rejection->type === 'incoming' ? 'Chèque Entrant' : 'Chèque Sortant' }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-black text-slate-700 uppercase tracking-tight">{{ $rejection->cheque->contact->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase italic mt-0.5">Échéance initiale: {{ \Carbon\Carbon::parse($rejection->cheque->due_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="text-sm font-black text-red-600">{{ number_format($rejection->cheque->amount, 2) }} MAD</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($rejection->resolved)
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-full uppercase border border-emerald-200">RÉCUPÉRÉ</span>
                                    @elseif($rejection->sent_to_litigation)
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-[9px] font-black rounded-full uppercase border border-purple-200 animate-pulse">AU TRIBUNAL</span>
                                    @else
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[9px] font-black rounded-full uppercase border border-amber-200">AMIABLE</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if(!$rejection->resolved)
                                            <form action="{{ route('rejections.litigation', $rejection->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-[9px] font-black uppercase tracking-widest px-3 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                                                    {{ $rejection->sent_to_litigation ? 'Sortir du Tribunal' : 'Envoyer au Contentieux' }}
                                                </button>
                                            </form>
                                            <button onclick="openResolveModal('{{ $rejection->id }}')" class="text-[9px] font-black uppercase tracking-widest px-3 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">
                                                Clôturer Dossier
                                            </button>
                                        @else
                                            <span class="text-[10px] font-black text-slate-400 uppercase italic">Aucune action requise</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-medium italic bg-slate-50/30">
                                    <svg class="mx-auto h-12 w-12 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    Félicitations ! Aucun dossier en souffrance actuellement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($rejections->hasPages())
                <div class="p-8 bg-slate-50 border-t border-slate-100">
                    {{ $rejections->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Resolution Modal -->
    <div id="resolve-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden border border-slate-200">
            <form id="resolve-form" action="" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-8 bg-emerald-600">
                    <h3 class="text-xl font-black text-white italic">Clôture du Dossier d'Impayé</h3>
                    <p class="text-emerald-100 text-[10px] font-bold uppercase mt-2 tracking-widest">Archivez le dossier après récupération du titre ou règlement.</p>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase mb-3 tracking-widest">Note de Résolution (ex: Repris en espèces)</label>
                        <textarea name="resolution_note" required class="w-full border-slate-200 rounded-2xl p-4 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium" rows="3" placeholder="Saisissez comment l'impayé a été résolu..."></textarea>
                    </div>
                </div>
                <div class="p-8 bg-slate-50 flex gap-4">
                    <button type="button" onclick="document.getElementById('resolve-modal').classList.add('hidden')" class="flex-1 px-4 py-3 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="flex-1 bg-emerald-600 text-white px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all">Valider la Clôture</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResolveModal(rejectionId) {
            const modal = document.getElementById('resolve-modal');
            const form = document.getElementById('resolve-form');
            form.action = `/rejections/${rejectionId}/resolve`;
            modal.classList.remove('hidden');
        }
    </script>
</x-app-layout>
