<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">Bordereaux de Remise</h1>
            @if(auth()->user()->hasPermission('remittances', 'create'))
            <a href="{{ route('remittances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouveau Bordereau
            </a>
            @endif
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-500/5 border border-slate-200 overflow-hidden" x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false; setTimeout(() => { if(typeof AOS !== 'undefined') AOS.refresh() }, 50); }, 500)" data-aos="fade-up" data-aos-delay="100">
            
            <template x-if="isLoading">
                <div class="p-8 space-y-4">
                    <!-- Table header skeleton -->
                    <div class="flex gap-4 mb-6 pb-4 border-b border-slate-100">
                        @for($j=0; $j<6; $j++)
                        <div class="h-3 w-24 bg-slate-200 rounded-full animate-shimmer {{ $j == 5 ? 'ml-auto' : '' }}"></div>
                        @endfor
                    </div>
                    <!-- Table rows skeleton -->
                    @for($i=0; $i<5; $i++)
                    <div class="flex items-center gap-6 py-4">
                        <div class="space-y-2">
                            <div class="h-4 w-28 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-2 w-20 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="space-y-2 flex-1">
                            <div class="h-4 w-32 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-2 w-24 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="h-6 w-20 bg-slate-100 rounded-lg animate-shimmer"></div>
                        <div class="h-4 w-24 bg-slate-100 rounded-full animate-shimmer"></div>
                        <div class="h-6 w-24 bg-slate-100 rounded-full animate-shimmer text-center"></div>
                        <div class="h-4 w-12 bg-slate-100 rounded-full animate-shimmer ml-auto"></div>
                    </div>
                    @endfor
                </div>
            </template>

            <div x-show="!isLoading" x-cloak class="overflow-x-auto">
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
                            <tr class="hover:bg-slate-50 transition-all border-l-4 border-transparent hover:border-blue-500" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 50) }}">
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
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100 shadow-inner">
                                            <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-800 tracking-tight">Aucun bordereau généré</h3>
                                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mt-2 text-center leading-relaxed">Générez un bordereau pour transmettre les chèques ou effets à votre banque.</p>
                                        @if(auth()->user()->hasPermission('remittances', 'create'))
                                        <a href="{{ route('remittances.create') }}" class="mt-8 bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-xl font-bold transition-all active:scale-95 text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/10">
                                            + Créer un Bordereau
                                        </a>
                                        @endif
                                    </div>
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
