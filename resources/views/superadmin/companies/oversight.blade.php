<x-app-layout>
    <div class="space-y-10">
        
        <!-- Oversight Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-slate-900 text-white rounded-[2rem] flex items-center justify-center text-2xl font-black shadow-xl">
                    {{ substr($company->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-black text-gray-900 tracking-tighter italic">Oversight: <span class="text-blue-600">{{ $company->name }}</span></h1>
                        <span class="px-3 py-1 bg-{{ $company->status === 'active' ? 'emerald' : 'rose' }}-100 text-{{ $company->status === 'active' ? 'emerald' : 'rose' }}-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $company->status === 'active' ? 'Opérationnelle' : 'Suspendue' }}
                        </span>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-2 italic">Analyse Profonde du Locataire · Infrastructure Monolith</p>
                </div>
            </div>

            <!-- New: Company Quick Info -->
            <div class="flex items-center gap-10 bg-white px-8 py-4 rounded-[2rem] border border-gray-100 shadow-sm">
                <div class="text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">ICE</p>
                    <p class="text-xs font-black text-slate-900">{{ $company->ice ?? 'Non renseigné' }}</p>
                </div>
                <div class="w-px h-8 bg-gray-100"></div>
                <div class="text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Registre Comm.</p>
                    <p class="text-xs font-black text-slate-900">{{ $company->rc ?? 'Non renseigné' }}</p>
                </div>
                <div class="w-px h-8 bg-gray-100"></div>
                <div class="text-center">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Localisation</p>
                    <p class="text-xs font-black text-slate-900">{{ $company->city ?? 'Plateforme' }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('companies.index') }}" class="px-6 py-2.5 bg-white border border-gray-100 text-gray-400 rounded-xl text-[10px] font-black uppercase tracking-widest hover:text-gray-900 transition-all">Retour</a>
                <a href="{{ route('companies.users', $company->id) }}" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-gray-200">Gérer Utilisateurs</a>
            </div>
        </div>

        <!-- Metric Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Flux Entrant (Payé/Endossé)</p>
                <div class="flex items-end gap-3">
                    <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($totalEncaissements, 0) }}</h3>
                    <span class="text-xs font-bold text-gray-400 mb-1 uppercase">MAD</span>
                </div>
            </div>
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Flux Sortant (Payé)</p>
                <div class="flex items-end gap-3">
                    <h3 class="text-4xl font-black text-gray-900 tracking-tighter">{{ number_format($totalDecaissements, 0) }}</h3>
                    <span class="text-xs font-bold text-gray-400 mb-1 uppercase">MAD</span>
                </div>
            </div>
            <div class="bg-blue-600 rounded-[2rem] p-8 shadow-xl shadow-blue-100">
                <p class="text-[10px] font-black text-blue-100 uppercase tracking-widest mb-3">Situation Nette</p>
                <div class="flex items-end gap-3 text-white">
                    <h3 class="text-4xl font-black tracking-tighter">{{ number_format($soldeNet, 0) }}</h3>
                    <span class="text-xs font-bold text-blue-200 mb-1 uppercase">MAD</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Details Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Company Entity Details -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-bl-[5rem] -mr-10 -mt-10 group-hover:scale-110 transition-transform"></div>
                    <h2 class="text-xl font-black text-gray-900 tracking-tight italic mb-8 flex items-center gap-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Informations Locataire
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Email de Contact</p>
                            <p class="text-sm font-black text-gray-900">{{ $company->email ?? 'Non fourni' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Téléphone</p>
                            <p class="text-sm font-black text-gray-900">{{ $company->phone ?? 'Non fourni' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Adresse Siège</p>
                            <p class="text-sm font-black text-gray-900 leading-relaxed">{{ $company->address ?? 'Non fournie' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Ville</p>
                            <p class="text-sm font-black text-gray-900">{{ $company->city ?? 'Non fournie' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Accounts -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight italic mb-8">Comptes Bancaires Locaux</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($bankAccounts as $bank)
                        <div class="p-6 rounded-3xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-4 mb-4">
                                @if($bank->logo_path)
                                    <img src="{{ asset('storage/' . $bank->logo_path) }}" class="w-10 h-10 object-contain">
                                @else
                                    <div class="w-10 h-10 bg-gray-900 text-white rounded-xl flex items-center justify-center font-black">
                                        {{ substr($bank->bank_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $bank->bank_name }}</p>
                                    <p class="text-[10px] font-bold text-gray-400">{{ $bank->account_number }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Solde Actuel</span>
                                <span class="text-sm font-black text-gray-900">{{ number_format($bank->balance, 2) }} MAD</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight italic mb-8">Flux de Titres Récents</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-left border-b border-gray-50">
                                    <th class="pb-6">Contact</th>
                                    <th class="pb-6">Numéro</th>
                                    <th class="pb-6">Montant</th>
                                    <th class="pb-6 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recentCheques as $cheque)
                                <tr>
                                    <td class="py-5 font-black text-sm text-gray-900">{{ $cheque->contact->name }}</td>
                                    <td class="py-5 font-bold text-xs text-gray-400 italic">{{ $cheque->cheque_number }}</td>
                                    <td class="py-5 font-black text-sm text-gray-900">{{ number_format($cheque->amount, 2) }}</td>
                                    <td class="py-5 text-right">
                                        <span class="px-2 py-1 bg-gray-100 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            {{ $cheque->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Audit Sidebar -->
            <div class="bg-white rounded-[3rem] p-8 shadow-sm border border-gray-100">
                <h2 class="text-xl font-black text-gray-900 tracking-tight italic mb-8">Auditer le Locataire</h2>
                <div class="space-y-6">
                    @foreach($auditLogs as $log)
                    <div class="relative pl-6 pb-6 border-l-2 border-gray-50 last:border-0 last:pb-0">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white border-4 border-gray-100 shadow-sm"></div>
                        <div class="flex flex-col gap-1">
                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ $log->action }}</p>
                            <p class="text-xs font-bold text-gray-900 leading-tight">
                                {{ $log->description }}
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase italic">{{ $log->user->name }}</span>
                                <span class="text-[9px] font-bold text-gray-300">•</span>
                                <span class="text-[9px] font-bold text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
