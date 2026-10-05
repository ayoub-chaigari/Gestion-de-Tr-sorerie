<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic uppercase tracking-tighter">Gestion Multitenant (SuperAdmin)</h1>
            <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border border-blue-200">
                Total Entreprises Active: {{ $companies->where('status', 'active')->count() }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($companies as $company)
                <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden group hover:border-blue-500 transition-all">
                    <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-blue-200">
                                {{ substr($company->name, 0, 1) }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $company->status === 'active' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-red-100 text-red-700 border border-red-200 shadow-sm' }}">
                                {{ $company->status === 'active' ? 'Activée' : 'Suspendue' }}
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ $company->name }}</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Enregistrée le: {{ optional($company->registration_date)->format('d/m/Y') ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="p-8 grid grid-cols-2 gap-4">
                        <a href="{{ route('companies.users', $company->id) }}" class="text-center p-3 bg-slate-50 rounded-2xl border border-slate-100 group-hover:border-blue-200 group-hover:bg-blue-50/50 transition-all">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-500">Utilisateurs</div>
                            <div class="text-lg font-black text-slate-900 group-hover:text-blue-700">{{ $company->users_count ?? 0 }}</div>
                        </a>
                        <a href="{{ route('companies.oversight', $company->id) }}" class="text-center p-3 bg-blue-50 rounded-2xl border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                            <div class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1 group-hover:text-blue-100">Oversight</div>
                            <div class="flex justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                        </a>
                    </div>

                    <div class="px-8 pb-8 flex gap-3">
                        @if($company->status === 'active')
                            <form action="{{ route('companies.suspend', $company->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full py-3 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">Suspendre</button>
                            </form>
                        @else
                            <form action="{{ route('companies.activate', $company->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-full py-3 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">Activer</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-slate-400 font-medium italic">Aucune entreprise enregistrée dans la plateforme.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
