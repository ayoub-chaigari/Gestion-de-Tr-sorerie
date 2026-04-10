<x-app-layout>
    <div class="p-8 max-w-4xl mx-auto">
        <div class="flex items-center gap-2 text-slate-500 mb-4">
            <a href="{{ route('contacts.index') }}" class="hover:text-blue-600 transition-colors">Contacts</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Nouveau Contact</span>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-700">Ajouter un Client ou Fournisseur</h3>
            </div>
            
            <form action="{{ route('contacts.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                        <select name="type" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="client">Client</option>
                            <option value="supplier">Fournisseur</option>
                        </select>
                        @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nom / Raison Sociale</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: SARL Ma Trésorerie">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Adresse</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- ICE -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ICE (15 chiffres)</label>
                        <input type="text" name="ice" value="{{ old('ice') }}" maxlength="15" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="000000000000000">
                        @error('ice') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- IF -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">IF (Max 9 chiffres)</label>
                        <input type="text" name="if" value="{{ old('if') }}" maxlength="9" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('if') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- RC -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">RC</label>
                        <input type="text" name="rc" value="{{ old('rc') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('contacts.index') }}" class="px-5 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors mt-2">Annuler</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-colors text-sm">Enregistrer le Contact</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
