<x-app-layout>
    <div class="px-4 py-12 sm:px-0 max-w-5xl mx-auto animate-fade-in-up">
        <h1 class="text-3xl font-black text-[#0f172a] mb-10 font-headline italic tracking-tight">Enregistrer un Chèque Entrant</h1>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden transition-all duration-500 hover:shadow-slate-300/50">
            <div class="p-10 border-b border-slate-50">
                <p class="text-slate-400 text-xs font-bold leading-relaxed text-center italic tracking-wider">
                    "Toute encaissement commence par une saisie rigoureuse."
                </p>
            </div>

            <form action="{{ route('cheques.store') }}" method="POST" class="p-12 space-y-12">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <!-- Contact Selection -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-[#0f172a] uppercase tracking-[0.2em] ml-1">Client (Source)</label>
                        <div class="relative">
                            <select name="contact_id" required class="w-full bg-slate-50 border-transparent @error('contact_id') border-red-500 @enderror rounded-2xl p-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all appearance-none cursor-pointer">
                                <option value="">Sélectionner un client...</option>
                                @forelse($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('contact_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} (ICE: {{ $client->ice }})</option>
                                @empty
                                    <option value="" disabled>Aucun client trouvé.</option>
                                @endforelse
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                        @error('contact_id') <p class="text-red-500 text-[10px] font-black uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Bank Selection -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-[#0f172a] uppercase tracking-[0.2em] ml-1">Banque émettrice</label>
                        <div class="relative">
                            <select name="bank_name" required class="w-full bg-slate-50 border-transparent @error('bank_name') border-red-500 @enderror rounded-2xl p-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all appearance-none cursor-pointer">
                                <option value="">Sélectionner la banque...</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank['name'] }}" {{ old('bank_name') == $bank['name'] ? 'selected' : '' }}>{{ $bank['name'] }}</option>
                                @endforeach
                                <option value="Autre" {{ old('bank_name') == 'Autre' ? 'selected' : '' }}>Autre / Inconnue</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                        @error('bank_name') <p class="text-red-500 text-[10px] font-black uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cheque Number -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-[#0f172a] uppercase tracking-[0.2em] ml-1">Numéro du Chèque</label>
                        <input type="text" name="cheque_number" value="{{ old('cheque_number') }}" required placeholder="Ex: 12345678"
                               class="w-full bg-slate-50 border-transparent @error('cheque_number') border-red-500 @enderror rounded-2xl p-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all placeholder:text-slate-300">
                        @error('cheque_number') <p class="text-red-500 text-[10px] font-black uppercase mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <!-- Amount -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-[#0f172a] uppercase tracking-[0.2em] ml-1">Montant</label>
                        <div class="relative">
                            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required 
                                   class="w-full bg-slate-50 border-transparent @error('amount') border-red-500 @enderror rounded-2xl p-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all" 
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">MAD</span>
                            </div>
                        </div>
                        @error('amount') <p class="text-red-500 text-[10px] font-black uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-[#0f172a] uppercase tracking-[0.2em] ml-1">Échéance</label>
                        <div class="relative">
                            <input type="date" name="due_date" value="{{ old('due_date') }}" required 
                                   class="w-full bg-slate-50 border-transparent @error('due_date') border-red-500 @enderror rounded-2xl p-4 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all appearance-none">
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[1.2rem]">calendar_today</span>
                            </div>
                        </div>
                        @error('due_date') <p class="text-red-500 text-[10px] font-black uppercase mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Is Effect? -->
                    <div class="flex flex-col justify-end pb-[2px]">
                        <div class="flex items-center space-x-4 p-4 bg-emerald-50/20 rounded-2xl border border-dashed border-emerald-100 hover:bg-emerald-50/40 transition-all">
                            <input id="is_effect" name="is_effect" type="checkbox" value="1" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-200 rounded-lg cursor-pointer">
                            <label for="is_effect" class="text-[11px] font-bold text-slate-600 uppercase tracking-tight cursor-pointer">Il s'agit d'un effet de commerce</label>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-50 flex justify-end items-center gap-8">
                    <a href="{{ route('cheques.index') }}" class="text-slate-400 hover:text-slate-600 text-[11px] font-black uppercase tracking-[0.2em] transition-all">
                        Annuler
                    </a>
                    <button type="submit" class="bg-[#00966d] hover:bg-[#0f172a] text-white px-10 py-5 rounded-2xl font-black shadow-2xl shadow-emerald-200 transition-all active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest group">
                        <span class="material-symbols-outlined group-hover:rotate-90 transition-transform">add</span>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
