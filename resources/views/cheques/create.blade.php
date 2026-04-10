<x-app-layout>
    <div class="px-4 py-6 sm:px-0 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-800 mb-8 font-display">Enregistrer un Chèque Entrant</h1>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="p-8 bg-slate-50 border-b border-slate-200">
                <p class="text-slate-500 text-sm leading-relaxed text-center italic">
                    "Toute encaissement commence par une saisie rigoureuse."
                </p>
            </div>

            <form action="{{ route('cheques.store') }}" method="POST" class="p-8 space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Contact Selection -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Client (Source)</label>
                        <select name="contact_id" required class="w-full border-slate-300 @error('contact_id') border-red-500 @enderror rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Sélectionner un client...</option>
                            @forelse($clients as $client)
                                <option value="{{ $client->id }}" {{ old('contact_id') == $client->id ? 'selected' : '' }}>{{ $client->name }} (ICE: {{ $client->ice }})</option>
                            @empty
                                <option value="" disabled>Aucun client trouvé. Créez d'abord un contact de type 'client'.</option>
                            @endforelse
                        </select>
                        @error('contact_id') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Bank Selection -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Banque émettrice</label>
                        <select name="bank_name" required class="w-full border-slate-300 @error('bank_name') border-red-500 @enderror rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 bg-white transition-all">
                            <option value="">Sélectionner la banque...</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank['name'] }}" {{ old('bank_name') == $bank['name'] ? 'selected' : '' }}>{{ $bank['name'] }} ({{ $bank['id_code'] }})</option>
                            @endforeach
                            <option value="Autre" {{ old('bank_name') == 'Autre' ? 'selected' : '' }}>Autre / Inconnue</option>
                        </select>
                        @error('bank_name') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cheque Number -->
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Numéro du Chèque</label>
                        <input type="text" name="cheque_number" value="{{ old('cheque_number') }}" required placeholder="Ex: 12345678"
                               class="w-full border-slate-300 @error('cheque_number') border-red-500 @enderror rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 font-mono">
                        @error('cheque_number') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Amount -->
                    <div class="space-y-4 md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Montant</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required 
                               class="w-full border-slate-300 @error('amount') border-red-500 @enderror rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-lg font-bold" 
                               placeholder="0.00">
                        @error('amount') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-4 md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">Échéance</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}" required 
                               class="w-full border-slate-300 @error('due_date') border-red-500 @enderror rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                        @error('due_date') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Is Effect? -->
                    <div class="space-y-4 md:col-span-1 flex flex-col justify-end">
                        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                            <input id="is_effect" name="is_effect" type="checkbox" value="1" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                            <label for="is_effect" class="text-sm font-medium text-slate-700">Il s'agit d'un effet de commerce</label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-4">
                    <a href="{{ route('cheques.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-emerald-200 transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
