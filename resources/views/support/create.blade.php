<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-10">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tighter italic">Nouveau <span class="text-blue-600">Ticket</span></h1>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mt-2 italic">Dites-nous comment nous pouvons vous aider</p>
        </div>

        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100">
            <form action="{{ route('support.store') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Sujet de la demande</label>
                    <input type="text" name="subject" required class="w-full bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 rounded-2xl p-4 text-sm font-bold transition-all placeholder:text-gray-400" placeholder="Ex: Problème d'importation de chèques">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">Message détaillé</label>
                    <textarea name="message" rows="6" required class="w-full bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 rounded-2xl p-4 text-sm font-bold transition-all placeholder:text-gray-400" placeholder="Décrivez votre besoin..."></textarea>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 py-4 bg-blue-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">
                        Envoyer ma Demande
                    </button>
                    <a href="{{ route('support.index') }}" class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-900 transition-all">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
