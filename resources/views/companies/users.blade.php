<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 gap-2">
                    <a href="{{ route('companies.index') }}" class="hover:text-blue-600 transition-colors">Entreprises</a>
                    <span>/</span>
                    <span class="text-slate-600">{{ $company->name }}</span>
                </nav>
                <h1 class="text-3xl font-black text-slate-800 font-display italic tracking-tight uppercase">Gestion des Utilisateurs</h1>
            </div>
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Comptes</p>
                    <p class="text-xl font-black text-slate-900">{{ $company->users->count() }}</p>
                </div>
                <div class="w-px h-8 bg-slate-100"></div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Actifs</p>
                    <p class="text-xl font-black text-emerald-600">{{ $company->users->where('status', 'active')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Utilisateur</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rôle</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Statut</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($company->users as $user)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-slate-400 border border-slate-200 group-hover:border-blue-200 group-hover:bg-blue-50 group-hover:text-blue-600 transition-all">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ $user->name }}</p>
                                    <p class="text-xs font-bold text-slate-400 tracking-tight">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black uppercase rounded-lg border border-slate-200">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @if($user->status === 'active')
                                <span class="flex items-center gap-2 text-emerald-600 font-bold text-xs">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                    Compte Actif
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-red-500 font-bold text-xs" title="Suspendu le {{ $user->suspended_at?->format('d/m/Y H:i') }}">
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    Suspendu
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <form action="{{ route('companies.users.toggle', $user->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" 
                                    class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest font-black transition-all shadow-xl shadow-slate-100
                                           {{ $user->status === 'active' 
                                              ? 'bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-100' 
                                              : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-100' }}">
                                    {{ $user->status === 'active' ? 'Stopper le Compte' : 'Réactiver le Compte' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
