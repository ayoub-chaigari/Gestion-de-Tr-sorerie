<x-app-layout>
    <div x-data="supportHub({{ $ticket->id }}, '{{ route('superadmin.support.poll', $ticket->id) }}')" class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8">
        
        <!-- Main Chat Area -->
        <div class="flex-1 space-y-8">
            <!-- Chat Header -->
            <div class="flex items-center justify-between bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-xl relative">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 003 20c0-2.554 1.488-4.758 3.592-5.783m1.968-1.9673V3m12 0v18m-4-10a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-xl font-black text-gray-900 tracking-tight italic">{{ $ticket->subject }}</h1>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Statut: <span :class="status === 'open' ? 'text-blue-600' : 'text-emerald-500'" x-text="statusLabel"></span></p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div x-show="status === 'open'">
                        <form action="{{ route('superadmin.support.close', $ticket->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-6 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">Clôturer</button>
                        </form>
                    </div>
                    <a href="{{ route('superadmin.support.index') }}" class="text-[9px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">Retour</a>
                </div>
            </div>

            <!-- Messaging Bubble Container -->
            <div x-ref="messageContainer" class="bg-white rounded-[3rem] p-10 border border-slate-100 min-h-[500px] flex flex-col gap-6 overflow-y-auto max-h-[600px] shadow-sm scroll-smooth custom-scrollbar">
                <template x-for="message in messages" :key="message.id">
                    <div class="flex" :class="message.is_me ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[85%] space-y-2">
                            <div class="flex items-center gap-2" :class="message.is_me ? 'justify-end' : 'justify-start'">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-tight italic" x-text="message.sender_name"></span>
                                <span x-show="message.role === 'SUPER_ADMIN'" class="px-1.5 py-0.5 bg-blue-50 text-blue-500 rounded text-[8px] font-black uppercase tracking-widest">Support Platform</span>
                            </div>
                            <div class="p-5 rounded-[2rem] shadow-sm transform transition-all hover:scale-[1.01]" :class="message.is_me ? 'bg-slate-900 text-white rounded-tr-none shadow-blue-500/10' : 'bg-slate-50 text-gray-800 border border-slate-100 rounded-tl-none'">
                                <p class="text-sm font-bold leading-relaxed whitespace-pre-line italic" x-text="message.content"></p>
                            </div>
                            <p class="text-[8px] font-black text-gray-300 uppercase tracking-tighter" :class="message.is_me ? 'text-right' : 'text-left'" x-text="message.time"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Reply Input -->
            <div x-show="status === 'open'" class="bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl border border-slate-800 transition-all duration-300">
                <form @submit.prevent="sendMessage">
                    <textarea x-model="newMessage" rows="3" class="w-full bg-slate-800 border-transparent focus:ring-2 focus:ring-blue-500 rounded-[1.5rem] p-5 text-sm font-bold text-white transition-all placeholder:text-slate-500 mb-4 font-mono italic" placeholder="Votre réponse officielle..."></textarea>
                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[8px] text-slate-500 uppercase font-black tracking-widest">Connecté au moniteur live</span>
                        </div>
                        <button type="submit" 
                                :disabled="isSending"
                                class="px-10 py-4 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-900/40 hover:bg-blue-500 transition-all disabled:opacity-50 active:scale-95">
                            <span x-text="isSending ? 'Transmission...' : 'Envoyer au Locataire'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Governance Sidebar -->
        <div class="w-full lg:w-80 space-y-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Identité Technique</p>
                <div class="space-y-6">
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Dénomination</p>
                        <p class="text-sm font-black text-slate-900 truncate">{{ $ticket->company->name }}</p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Identifiant (ICE)</p>
                        <p class="text-xs font-mono font-bold text-blue-600 bg-blue-50 px-3 py-2 rounded-xl border border-blue-100">{{ $ticket->company->ice }}</p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Statut Gouvernance</p>
                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $ticket->company->status === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                            {{ strtoupper($ticket->company->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50/50 rounded-[2.5rem] border border-slate-100 p-8 italic">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 text-center">Contact Direct</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-900 font-black shadow-sm border border-slate-100">
                        {{ substr($ticket->creator->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-900">{{ $ticket->creator->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 mt-0.5 truncate">{{ $ticket->creator->email }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('companies.oversight', $ticket->company_id) }}" class="block w-full text-center px-4 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[9px] font-black uppercase tracking-widest hover:border-slate-900 hover:text-slate-900 transition-all">
                        Ouvrir l'Espace d'Audit
                    </a>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function supportHub(ticketId, pollUrl) {
            return {
                messages: [],
                status: 'open',
                newMessage: '',
                isSending: false,
                get statusLabel() { return this.status === 'open' ? 'EN CONCOURS (LIVE)' : 'DOSSIER RÉSOLU'; },
                
                async init() {
                    await this.fetchMessages();
                    this.scrollToBottom();
                    setInterval(() => this.fetchMessages(), 5000);
                },
                
                async fetchMessages() {
                    try {
                        let response = await fetch(pollUrl);
                        let data = await response.json();
                        let oldLength = this.messages.length;
                        this.messages = data.messages;
                        this.status = data.status;
                        
                        if (this.messages.length > oldLength) {
                            this.$nextTick(() => this.scrollToBottom());
                        }
                    } catch (e) {
                        console.error("Hub Polling Error", e);
                    }
                },
                
                async sendMessage() {
                    if (!this.newMessage.trim() || this.isSending) return;
                    this.isSending = true;
                    
                    try {
                        let response = await fetch("{{ route('superadmin.support.reply', $ticket->id) }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({ message: this.newMessage })
                        });
                        
                        if (response.ok) {
                            this.newMessage = '';
                            await this.fetchMessages();
                        }
                    } catch (e) {
                        alert("Erreur lors de la transmission.");
                    } finally {
                        this.isSending = false;
                    }
                },
                
                scrollToBottom() {
                    const container = this.$refs.messageContainer;
                    if (container) container.scrollTop = container.scrollHeight;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
