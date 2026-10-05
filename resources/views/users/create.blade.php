<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">
        <h1 class="text-3xl font-black text-slate-800 mb-8 font-display italic tracking-tight uppercase">Nouveau Collaborateur (Comptable)</h1>

        <div class="bg-white rounded-[2rem] shadow-2xl border border-slate-200 overflow-hidden">
            <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name & Email -->
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-4">Informations d'Accès</p>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest">Nom Complet</label>
                            <input type="text" name="name" required class="w-full border-slate-200 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 shadow-sm transition-all focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest">Email Professionnel</label>
                            <input type="email" name="email" required class="w-full border-slate-200 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 shadow-sm transition-all focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase mb-2 tracking-widest">Mot de Passe Initial</label>
                            <input type="password" name="password" required class="w-full border-slate-200 rounded-2xl p-4 text-sm font-bold focus:ring-blue-500 shadow-sm transition-all focus:border-blue-500" placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Permissions Selection -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Permissions Application</p>
                            <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md uppercase">Contrôle d'Accès Granulaire</span>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                                @php
                                    $modules = [
                                        'dashboard' => ['label' => 'Tableau de Bord & Indicateurs', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'view_only' => true],
                                        'contacts' => ['label' => 'Gestion des Tiers', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                        'invoices' => ['label' => 'Facturation & Délais', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'cheques' => ['label' => 'Chèques & Effets', 'icon' => 'M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'remittances' => ['label' => 'Encaissements', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'rejections' => ['label' => 'Gestion des Contentieux', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3', 'view_only' => true],
                                    ];
                                    $actions = ['view' => 'Consulter', 'create' => 'Ajouter', 'edit' => 'Modifier', 'delete' => 'Supprimer'];
                                @endphp

                                @foreach($modules as $key => $module)
                                    <div class="bg-white p-5 rounded-[1.5rem] border border-slate-200 shadow-sm transition-all hover:shadow-md hover:border-indigo-200 group/module" data-module="{{ $key }}">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-8 h-8 bg-slate-50 text-slate-400 group-hover/module:bg-indigo-50 group-hover/module:text-indigo-600 rounded-xl flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $module['icon'] }}" /></svg>
                                            </div>
                                            <div class="font-black text-[11px] text-slate-900 uppercase tracking-widest">{{ $module['label'] }}</div>
                                            @if($module['view_only'] ?? false)
                                                <span class="ml-auto text-[8px] font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded uppercase tracking-tighter shadow-sm border border-amber-100">Consultation Uniquement</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($actions as $action => $actionLabel)
                                                @if(!($module['view_only'] ?? false) || $action === 'view')
                                                <label class="flex items-center gap-2 cursor-pointer py-2 px-3 rounded-xl border border-transparent hover:bg-slate-50 transition-all select-none">
                                                    <input type="checkbox" 
                                                           name="permissions[{{ $key }}][]" 
                                                           value="{{ $action }}" 
                                                           data-module="{{ $key }}"
                                                           data-action="{{ $action }}"
                                                           class="permission-checkbox w-5 h-5 text-indigo-600 border-slate-300 rounded-lg focus:ring-indigo-500 transition-all">
                                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-tight">{{ $actionLabel }}</span>
                                                </label>
                                                @endif
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
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const module = this.dataset.module;
                    const action = this.dataset.action;
                    const siblings = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
                    const viewCheckbox = Array.from(siblings).find(cb => cb.dataset.action === 'view');

                    if (action !== 'view' && this.checked) {
                        // If checking any action, automatically check 'view'
                        if (viewCheckbox) viewCheckbox.checked = true;
                    }

                    if (action === 'view' && !this.checked) {
                        // If unchecking 'view', uncheck all other actions for this module
                        siblings.forEach(cb => {
                            if (cb.dataset.action !== 'view') cb.checked = false;
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
