<x-app-layout>
    <div x-data="supportChat({{ $ticket->id }}, '{{ route('support.poll', $ticket->id) }}')" class="max-w-4xl mx-auto space-y-8">
        
        <!-- Suspension Banner (Conditional) -->
        @if(auth()->user()->company->status !== 'active')
        <div class="bg-amber-50 border border-amber-200 p-8 rounded-[2.5rem] flex items-center gap-6 shadow-xl shadow-amber-500/5 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-200/20 blur-3xl rounded-full"></div>
            <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center font-black animate-pulse shadow-lg shadow-amber-200 z-10 text-xl">!</div>
            <div class="relative z-10">
                <p class="text-lg font-black text-amber-900 leading-tight">Accès Limité : Suspension Active</p>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mt-1">Utilisez ce canal direct pour la réactivation de votre compte entreprise.</p>
            </div>
        </div>
        @endif

        <!-- Chat Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl relative shadow-blue-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight italic">{{ $ticket->subject }}</h1>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Ticket #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} • <span x-text="statusLabel" :class="status === 'open' ? 'text-blue-600' : 'text-gray-400'"></span></p>
                </div>
            </div>
            <a href="{{ route('support.index') }}" class="text-[9px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-xl border border-slate-100 transition-all">Retour</a>
        </div>

        <!-- Messaging Bubble Container -->
        <div x-ref="messageContainer" class="bg-slate-50/50 rounded-[3rem] p-10 border border-slate-100 min-h-[500px] flex flex-col gap-6 overflow-y-auto max-h-[600px] shadow-sm scroll-smooth custom-scrollbar">
            <template x-for="message in messages" :key="message.id">
                <div class="flex" :class="message.is_me ? 'justify-end' : 'justify-start'">
                    <div class="max-w-[85%] space-y-2">
                        <div class="flex items-center gap-2" :class="message.is_me ? 'justify-end' : 'justify-start'">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tight italic" x-text="message.sender_name"></span>
                            <span x-show="message.role === 'SUPER_ADMIN'" class="px-1.5 py-0.5 bg-blue-100 text-blue-600 rounded text-[7px] font-black uppercase tracking-widest">Support Officiel</span>
                        </div>
                        <div class="p-5 rounded-[2rem] shadow-sm transform transition-all hover:scale-[1.01]" :class="message.is_me ? 'bg-blue-600 text-white rounded-tr-none shadow-blue-500/10' : 'bg-white text-gray-800 border border-gray-100 rounded-tl-none'">
                            <p class="text-sm font-bold leading-relaxed whitespace-pre-line italic" x-text="message.content"></p>
                        </div>
                        <p class="text-[8px] font-black text-gray-300 uppercase tracking-tighter" :class="message.is_me ? 'text-right' : 'text-left'" x-text="message.time"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Reply Input -->
        <div x-show="status === 'open'" class="bg-white rounded-[2.5rem] p-8 shadow-2xl border border-blue-50 transition-all duration-300">
            <form @submit.prevent="sendMessage">
                <textarea x-model="newMessage" rows="3" class="w-full bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-blue-600 rounded-[1.5rem] p-5 text-sm font-bold transition-all placeholder:text-gray-400 mb-4 italic" placeholder="Décrivez votre besoin ici..."></textarea>
                <div class="flex justify-between items-center">
                    <div class="flex gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[8px] text-gray-400 uppercase font-black tracking-widest">Canal de synchronisation actif</span>
                    </div>
                    <button type="submit" 
                            :disabled="isSending"
                            class="px-10 py-4 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all disabled:opacity-50 active:scale-95">
                        <span x-text="isSending ? 'Envoi...' : 'Transmettre le Message'"></span>
                    </button>
                </div>
            </form>
        </div>

        <div x-show="status !== 'open'" class="bg-gray-100 rounded-[2rem] p-10 text-center border border-dashed border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest italic">Ce dossier a été marqué comme résolu par l'administration.</p>
        </div>
    </div>

    @push('scripts')
    <script>
        function supportChat(ticketId, pollUrl) {
            return {
                messages: [],
                status: 'open',
                newMessage: '',
                isSending: false,
                get statusLabel() { return this.status === 'open' ? 'Synchronisation Active' : 'RÉSOLU'; },
                
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
                        console.error("Polling error", e);
                    }
                },
                
                async sendMessage() {
                    if (!this.newMessage.trim() || this.isSending) return;
                    this.isSending = true;
                    
                    try {
                        let response = await fetch("{{ route('support.reply', $ticket->id) }}", {
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
                        alert("Erreur lors de l'envoi.");
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
