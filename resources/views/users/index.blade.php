<x-app-layout>
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">Gestion de l'Équipe</h1>
            <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Ajouter un Collaborateur
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden font-sans">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Utilisateur</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rôle / Statut</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Permissions Actives</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Date d'ajout</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-indigo-500">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-black text-slate-400 border border-slate-200 uppercase">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-900 text-lg leading-tight">{{ $user->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-2">
                                        <span class="w-fit px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $user->role === 'ADMIN' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                            {{ $user->role }}
                                        </span>
                                        @if($user->status === 'active')
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-emerald-600 uppercase tracking-tight">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_6px_rgba(16,185,129,0.5)]"></span>
                                                Compte Actif
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1.5 text-[9px] font-black text-red-500 uppercase tracking-tight">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                Compte Suspendu
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if($user->role === 'ADMIN')
                                        <span class="text-[10px] text-slate-500 font-bold uppercase italic">Accès Total</span>
                                    @else
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($user->permissions as $module => $actions)
                                                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[8px] font-black rounded uppercase border border-indigo-100">
                                                    {{ $module }} ({{ count($actions) }})
                                                </span>
                                            @empty
                                                <span class="text-[10px] text-slate-300 font-bold uppercase italic">Aucune</span>
                                            @endforelse
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-medium text-slate-600 italic tracking-tighter">{{ $user->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-5 text-right flex justify-end items-center gap-3">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-2 rounded-xl transition-all {{ $user->status === 'active' ? 'text-slate-300 hover:text-red-500 hover:bg-red-50' : 'text-emerald-500 hover:bg-emerald-50' }}" title="{{ $user->status === 'active' ? 'Suspendre l\'accès' : 'Réactiver l\'accès' }}">
                                                @if($user->status === 'active')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @endif
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('users.edit', $user->id) }}" class="p-2 text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    
                                    @if($user->id !== auth()->id() && $user->role !== 'ADMIN')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-300 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
