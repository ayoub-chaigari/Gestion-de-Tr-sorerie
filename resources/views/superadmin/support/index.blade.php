<x-app-layout>
    <div class="space-y-10">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter italic">Support <span class="text-blue-600">Hub</span></h1>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-2 italic">Infrastructure Governance • Flux de Communication</p>
        </div>

        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-left border-b border-gray-50">
                            <th class="pb-6 px-4">Locataire / Origine</th>
                            <th class="pb-6 px-4">Objet</th>
                            <th class="pb-6 px-4">Statut</th>
                            <th class="pb-6 px-4">Urgence</th>
                            <th class="pb-6 px-4 text-right">Contrôle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($tickets as $ticket)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="py-6 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-black text-[10px]">
                                        {{ substr($ticket->company->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-900">{{ $ticket->company->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase italic">Par: {{ $ticket->creator->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-6 px-4">
                                <p class="text-xs font-black text-gray-900">{{ $ticket->subject }}</p>
                            </td>
                            <td class="py-6 px-4">
                                <span class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-full {{ $ticket->status === 'open' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-400' }}">
                                    {{ $ticket->status === 'open' ? 'Actif' : 'Clôturé' }}
                                </span>
                            </td>
                            <td class="py-6 px-4">
                                <span class="text-[9px] font-black text-gray-300 uppercase italic italic">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="py-6 px-4 text-right">
                                <a href="{{ route('superadmin.support.show', $ticket->id) }}" class="px-6 py-2 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">
                                    Répondre
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-gray-400 font-bold italic">Aucun ticket actif sur la plateforme.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
