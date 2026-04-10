<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">
        <h1 class="text-3xl font-black text-slate-800 mb-8 font-display italic tracking-tight uppercase">Modifier Collaborateur ({{ $user->name }})</h1>

        <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8 space-y-10">
                @csrf @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name & Email -->
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-4">Informations d'Accès</p>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest">Nom Complet</label>
                            <input type="text" name="name" value="{{ $user->name }}" required class="w-full border-slate-200 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 shadow-sm transition-all focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest">Email Professionnel</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full border-slate-200 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 shadow-sm transition-all focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest text-emerald-600">Prochain Mot de Passe (Optionnel)</label>
                            <input type="password" name="password" class="w-full border-emerald-100 bg-emerald-50/30 rounded-2xl p-4 text-sm font-bold focus:ring-emerald-500 shadow-sm transition-all focus:border-emerald-500" placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Permissions Selection -->
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-4">Permissions Application</p>
                        <div class="grid grid-cols-1 gap-4">
                            @php
                                $modules = [
                                    'contacts' => 'Gestion des Tiers (Clients/Fournisseurs)',
                                    'invoices' => 'Facturation et Délais (Loi 69-21)',
                                    'cheques' => 'Gestion des Chèques et Effets',
                                    'remittances' => 'Bordereaux et Encaissements'
                                ];
                                $actions = ['view' => 'Consulter', 'create' => 'Ajouter', 'edit' => 'Modifier', 'delete' => 'Supprimer'];
                                $userPermissions = $user->permissions ?? [];
                            @endphp

                            @foreach($modules as $key => $label)
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <div class="font-black text-[10px] text-slate-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                                        {{ $label }}
                                    </div>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach($actions as $action => $actionLabel)
                                            <label class="flex items-center gap-2 cursor-pointer group">
                                                @php
                                                    $isChecked = isset($userPermissions[$key]) && in_array($action, $userPermissions[$key]);
                                                @endphp
                                                <input type="checkbox" name="permissions[{{ $key }}][]" value="{{ $action }}" {{ $isChecked ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-200 rounded-lg focus:ring-indigo-500 transition-all">
                                                <span class="text-[11px] font-bold text-slate-500 group-hover:text-indigo-600 transition-colors">{{ $actionLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-100 flex justify-end items-center gap-4">
                    <a href="{{ route('users.index') }}" class="text-slate-400 hover:text-slate-600 text-xs font-black uppercase tracking-widest transition-colors mr-4">Annuler</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-slate-900 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-indigo-100 transition-all active:scale-95 flex items-center gap-3 uppercase text-xs tracking-[0.2em]">
                        Mettre à jour le collaborateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
