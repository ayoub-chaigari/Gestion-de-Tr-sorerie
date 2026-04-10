<x-app-layout>
    <div class="px-4 py-8 sm:px-0 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic tracking-tight uppercase flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Historique des Actions (Audit)
            </h1>
            <div class="bg-blue-50 text-blue-800 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-xl border border-blue-100 flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Surveillance Active
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden relative">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-48">Date & Heure</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-48">Collaborateur</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-32">Action</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Détails (Ancien -> Nouveau)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @forelse($logs as $log)
                            @php
                                $actionColor = match($log->action) {
                                    'created' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'updated' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'deleted' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                                $actionText = match($log->action) {
                                    'created' => 'Création',
                                    'updated' => 'Modification',
                                    'deleted' => 'Suppression',
                                    default => $log->action,
                                };
                                
                                $modelName = class_basename($log->model_type);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-5 align-top">
                                    <div class="text-sm font-bold text-slate-800">{{ $log->created_at->format('d/m/Y') }}</div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $log->created_at->format('H:i:s') }}</div>
                                    <div class="text-[9px] font-black text-slate-300 mt-2">IP: {{ $log->ip_address }}</div>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-600 text-xs uppercase border border-slate-200">
                                            {{ substr(optional($log->user)->name ?? '?', 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-700">{{ optional($log->user)->name ?? 'System' }}</div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ optional($log->user)->role ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest border rounded-xl {{ $actionColor }}">
                                        {{ $actionText }}
                                    </span>
                                    <div class="mt-2 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                        {{ $modelName }} (#{{ $log->model_id }})
                                    </div>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    @if($log->action === 'updated' && is_array($log->new_values))
                                        <div class="space-y-2">
                                            @foreach($log->new_values as $key => $newValue)
                                                @php
                                                    $oldValue = $log->old_values[$key] ?? 'null';
                                                @endphp
                                                <div class="text-xs bg-slate-50 p-2 rounded-xl border border-slate-100 flex flex-wrap items-center gap-2 font-mono">
                                                    <span class="font-black text-slate-500">{{ $key }}:</span>
                                                    <span class="text-red-500 line-through truncate max-w-[150px]">{{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}</span>
                                                    <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                    <span class="text-emerald-600 font-bold truncate max-w-[200px]">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($log->action === 'created')
                                        <div class="text-xs text-slate-500 font-bold italic">Nouveau document généré.</div>
                                    @elseif($log->action === 'deleted')
                                        <div class="text-xs text-red-500 font-bold italic">Document supprimé.</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-500">Aucun historique d'actions pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
