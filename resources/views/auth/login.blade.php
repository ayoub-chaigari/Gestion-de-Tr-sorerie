<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-16 h-16 bg-blue-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-blue-500/30 mx-auto mb-6 transform hover:scale-110 transition-transform">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-900 italic tracking-tight">Connexion</h2>
        <p class="text-[11px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Connectez-vous à votre espace Trésorerie</p>
    </div>

    <form class="space-y-6" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Identifiant Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border-slate-100 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm">
                @error('email') <p class="text-red-500 text-[9px] font-bold p-2 uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Clé d'Accès</label>
                <input name="password" type="password" required class="w-full bg-slate-50 border-slate-100 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm" placeholder="••••••••">
            </div>
        </div>

        <div class="flex items-center justify-between px-1">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input name="remember" type="checkbox" class="w-5 h-5 text-blue-600 border-slate-200 rounded-lg focus:ring-blue-500 transition-all">
                <span class="text-[11px] font-bold text-slate-500 group-hover:text-blue-600 transition-colors">Se souvenir de moi</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-slate-900 text-white p-5 rounded-3xl font-black shadow-xl shadow-blue-100 transition-all active:scale-[0.98] uppercase text-xs tracking-[0.2em]">
            Valider l'Accès
        </button>

        <p class="text-center text-[10px] font-bold text-slate-400">
            Nouveau sur la plateforme ? <a href="{{ route('register') }}" class="text-blue-600 font-black underline decoration-blue-200">Créer un compte</a>
        </p>
    </form>
</x-guest-layout>
