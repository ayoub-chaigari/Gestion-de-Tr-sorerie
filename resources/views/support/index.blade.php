<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex justify-between items-end mb-12">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic">Support Center</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Direct assistance & account management</p>
            </div>
            <a href="{{ route('support.create') }}" class="group relative inline-flex items-center px-8 py-4 bg-[#0b1120] text-white rounded-2xl font-black text-sm shadow-xl shadow-slate-900/20 hover:bg-black hover:scale-[1.02] transition-all transform opacity-90 hover:opacity-100">
                <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                Ouvrir un Ticket
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 group hover:shadow-xl transition-all">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $tickets->where('status', 'open')->count() }}</h3>
                <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-2">Tickets Ouverts</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 group hover:shadow-xl transition-all">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $tickets->where('status', 'closed')->count() }}</h3>
                <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-2">Résolus</p>
            </div>
            <div class="bg-[#0b1120] p-8 rounded-[2.5rem] shadow-xl shadow-slate-900/20 group transition-all">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#CDA833] mb-6">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                </div>
                <h3 class="text-3xl font-black text-white leading-none">VIP</h3>
                <p class="text-[10px] uppercase font-black tracking-widest text-slate-400 mt-2">Support Prioritaire</p>
            </div>
        </div>

        <!-- Ticket List (Modern Cards) -->
        <div class="space-y-6">
            @forelse($tickets as $ticket)
            <a href="{{ route('support.show', $ticket->id) }}" class="block bg-white p-8 rounded-[2.5rem] border border-slate-50 hover:border-[#006C4A] hover:shadow-2xl hover:shadow-[#006C4A]/5 group transition-all relative overflow-hidden">
                @if($ticket->status === 'open')
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#006C4A]/5 blur-[80px] group-hover:bg-[#006C4A]/10 transition-all"></div>
                @endif

                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all {{ $ticket->status === 'open' ? 'bg-amber-100 text-amber-600 group-hover:bg-amber-600 group-hover:text-white' : 'bg-slate-50 text-slate-400' }}">
                            @if($ticket->status === 'open')
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            @else
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 group-hover:text-[#006C4A] transition-colors">{{ $ticket->subject }}</h2>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $ticket->status === 'open' ? 'text-amber-500' : 'text-slate-400' }}">
                                    {{ $ticket->status === 'open' ? 'En cours' : 'Résolu' }}
                                </span>
                                <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                <span class="text-[10px] font-bold text-slate-400 lowercase">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Dernier message</p>
                            <p class="text-xs font-bold text-slate-900 mt-1">{{ $ticket->messages->last()->created_at->format('d M, H:i') }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-[#0b1120] group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-20 bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 italic">Aucun ticket actif</h3>
                <p class="text-slate-400 font-bold mt-2">Nos techniciens sont à votre disposition si besoin.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
