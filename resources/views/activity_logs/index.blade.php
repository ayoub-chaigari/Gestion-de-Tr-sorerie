<x-app-layout>
    <div class="p-8 max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 italic">{{ __('Historique des Actions') }}</h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">{{ __('Journal complet des modifications effectuées par votre équipe') }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-8">
            <form action="{{ route('activity-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                {{-- User filter --}}
                <div class="md:w-56">
                    </select>
                </div>
                {{-- Company filter (SuperAdmin only) --}}
                @if($isSuperAdmin)
                <div class="md:w-56">
                    <select name="company_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium bg-slate-50 text-slate-700">
                        <option value="">{{ __('Toutes les entreprises') }}</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                {{-- Model type filter --}}
                <div class="md:w-56">
                    <select name="model" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium bg-slate-50 text-slate-700">
                        <option value="">{{ __('Tous les modules') }}</option>
                        <option value="Invoice" {{ request('model') === 'Invoice' ? 'selected' : '' }}>{{ __('Factures') }}</option>
                        <option value="IncomingCheque" {{ request('model') === 'IncomingCheque' ? 'selected' : '' }}>{{ __('Chèques Recette') }}</option>
                        <option value="OutgoingCheque" {{ request('model') === 'OutgoingCheque' ? 'selected' : '' }}>{{ __('Chèques Émis') }}</option>
                        <option value="Contact" {{ request('model') === 'Contact' ? 'selected' : '' }}>{{ __('Tiers (Clients/Fournisseurs)') }}</option>
                        <option value="Remittance" {{ request('model') === 'Remittance' ? 'selected' : '' }}>{{ __('Bordereaux') }}</option>
                        <option value="InvoicePayment" {{ request('model') === 'InvoicePayment' ? 'selected' : '' }}>{{ __('Paiements') }}</option>
                    </select>
                </div>
                {{-- Action filter --}}
                <div class="md:w-48">
                    <select name="action" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm font-medium bg-slate-50 text-slate-700">
                        <option value="">{{ __('Toutes les actions') }}</option>
                        <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>{{ __('Ajout') }}</option>
                        <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>{{ __('Modification') }}</option>
                        <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>{{ __('Suppression') }}</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-sm active:scale-95">
                    {{ __('Filtrer') }}
                </button>
                @if(request()->hasAny(['user_id', 'model', 'action']))
                    <a href="{{ route('activity-logs.index') }}" class="px-6 py-3 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 hover:bg-slate-200 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Effacer') }}
                    </a>
                @endif
            </form>
        </div>

        {{-- Timeline --}}
        <div class="space-y-3">
            @forelse($logs as $log)
                @php
                    $actionConfig = [
                        'created' => ['color' => 'emerald', 'icon' => 'M12 4v16m8-8H4', 'label' => __('Ajout')],
                        'updated' => ['color' => 'blue', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'label' => __('Modification')],
                        'deleted' => ['color' => 'red', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', 'label' => __('Suppression')],
                    ];
                    $conf  = $actionConfig[$log->action] ?? ['color' => 'slate', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => ucfirst($log->action)];
                    $color = $conf['color'];
                    $modelShort = class_basename($log->model_type);
                    $modelLabels = [
                        'Invoice' => __('Facture'), 'IncomingCheque' => __('Chèque Recette'),
                        'OutgoingCheque' => __('Chèque Émis'), 'Contact' => __('Tiers'),
                        'Remittance' => __('Bordereau'), 'InvoicePayment' => __('Paiement'),
                    ];
                    $modelLabel = $modelLabels[$modelShort] ?? $modelShort;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow p-5">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="w-10 h-10 rounded-xl bg-{{ $color }}-100 flex items-center justify-center flex-shrink-0 mt-0.5 border border-{{ $color }}-200">
                            <svg class="w-5 h-5 text-{{ $color }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $conf['icon'] }}"/>
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Who & What --}}
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <div class="flex items-center gap-2">
                                    @php
                                        $userRole = optional($log->user)->role ?? 'SYSTÈME';
                                        $roleColor = match($userRole) {
                                            'ADMIN', 'SUPER_ADMIN' => 'purple',
                                            'ACCOUNTANT' => 'blue',
                                            default => 'slate',
                                        };
                                    @endphp
                                    <span class="w-7 h-7 rounded-full bg-{{ $roleColor }}-100 border border-{{ $roleColor }}-200 flex items-center justify-center text-xs font-black text-{{ $roleColor }}-700">
                                        {{ strtoupper(substr(optional($log->user)->name ?? 'S', 0, 1)) }}
                                    </span>
                                    <div>
                                        <span class="font-black text-slate-800 text-sm">{{ optional($log->user)->name ?? 'Système' }}</span>
                                        @if($isSuperAdmin)
                                            <span class="ml-2 px-2 py-0.5 text-[9px] font-black uppercase rounded bg-blue-50 text-blue-600 border border-blue-100">
                                                Locataire: {{ $log->company->name ?? 'N/A' }}
                                            </span>
                                        @endif
                                        @if($log->user)
                                            <span class="ml-1 text-[10px] text-slate-400 font-medium">({{ $log->user->email }})</span>
                                            <span class="ml-1 px-1.5 py-0.5 text-[9px] font-black uppercase tracking-widest rounded bg-{{ $roleColor }}-100 text-{{ $roleColor }}-700 border border-{{ $roleColor }}-200">
                                                {{ $userRole }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 text-[10px] font-black uppercase tracking-widest rounded-lg bg-{{ $color }}-100 text-{{ $color }}-700 border border-{{ $color }}-200">
                                    {{ $conf['label'] }}
                                </span>
                                <span class="px-2 py-0.5 text-[10px] font-black uppercase tracking-widest rounded-lg bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $modelLabel }} #{{ $log->model_id }}
                                </span>
                                <span class="ml-auto text-xs text-slate-400 font-medium whitespace-nowrap">
                                    {{ $log->created_at->diffForHumans() }}
                                    <span class="text-slate-300">·</span>
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- Change Details --}}
                            @if($log->action === 'updated' && $log->old_values && $log->new_values)
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($log->new_values as $field => $newValue)
                                        @php $oldValue = $log->old_values[$field] ?? null; @endphp
                                        @if($field !== 'updated_at')
                                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs">
                                            <div class="font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ str_replace('_', ' ', $field) }}</div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="line-through text-red-500 font-medium bg-red-50 px-2 py-0.5 rounded-lg border border-red-100">
                                                    {{ is_array($oldValue) ? json_encode($oldValue) : ($oldValue ?? 'vide') }}
                                                </span>
                                                <svg class="w-3 h-3 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                                <span class="text-emerald-600 font-black bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">
                                                    {{ is_array($newValue) ? json_encode($newValue) : ($newValue ?? 'vide') }}
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($log->action === 'created' && $log->new_values)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach(array_slice($log->new_values, 0, 5) as $field => $value)
                                        @if($field !== 'created_at' && $field !== 'updated_at' && $field !== 'company_id')
                                            <span class="text-[10px] bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-1 rounded-lg font-bold">
                                                {{ str_replace('_', ' ', $field) }}: {{ is_array($value) ? '—' : Str::limit($value, 20) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($log->action === 'deleted' && $log->old_values)
                                <div class="mt-2 text-xs text-red-500 font-bold bg-red-50 rounded-xl px-3 py-2 border border-red-100 inline-block">
                                    Enregistrement supprimé — ID #{{ $log->model_id }}
                                </div>
                            @endif

                            {{-- IP Address --}}
                            @if($log->ip_address)
                                <div class="mt-2 text-[10px] text-slate-300 font-mono">
                                    IP: {{ $log->ip_address }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 py-20 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-slate-500 font-black text-lg">{{ __('Aucune action enregistrée') }}</h3>
                    <p class="text-slate-400 text-sm mt-1 font-medium">{{ __('Le journal sera alimenté automatiquement dès que votre équipe effectue des modifications.') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
