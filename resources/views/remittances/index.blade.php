<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">Bordereaux de Remise</h1>
            <a href="{{ route('remittances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouveau Bordereau
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Référence / Date</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Banque de Dépôt</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Type de Titres</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Montant Total</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Statut</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @forelse($remittances as $remittance)
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-5">
                                    <div class="font-black text-slate-900 font-mono tracking-tighter text-lg">{{ $remittance->reference }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($remittance->remittance_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-slate-700">{{ $remittance->bankAccount->bank_name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono tracking-tighter uppercase">{{ $remittance->bankAccount->agency ?? 'Agence Standard' }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-black rounded-lg uppercase border border-slate-200 tracking-widest shadow-sm">
                                        {{ $remittance->type === 'cheque' ? 'Chèques' : 'Effets' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="font-black text-slate-900">{{ number_format($remittance->total_amount, 2) }} <span class="text-[10px] text-slate-400 ml-1 uppercase">MAD</span></div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase border border-blue-100 tracking-widest">Transmis</span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('remittances.show', $remittance->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs uppercase underline tracking-widest">Détails</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400 font-medium italic bg-slate-50/30">
                                    <svg class="mx-auto h-12 w-12 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Aucun bordereau généré pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($remittances->hasPages())
                <div class="p-8 bg-slate-50/50 border-t border-slate-100 font-sans">
                    {{ $remittances->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
