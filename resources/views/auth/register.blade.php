<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-blue-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-blue-500/30 mx-auto mb-6 transform hover:scale-110 transition-transform">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-900 italic tracking-tight">Inscription</h2>
        <p class="text-[11px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Créez votre espace Trésorerie SaaS</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
            @foreach($errors->all() as $error)
                <p class="text-xs text-red-600 font-bold">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form class="space-y-6" action="{{ route('register') }}" method="POST">
        @csrf

        {{-- ─── SECTION : Informations Personnelles ─────────────────── --}}
        <div>
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4 border-b border-slate-100 pb-2">01 · Votre Compte</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nom Complet</label>
                    <input name="name" type="text" value="{{ old('name') }}" required
                        class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                        placeholder="Votre nom et prénom">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Email Professionnel</label>
                    <input name="email" type="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                        placeholder="email@societe.ma">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Mot de Passe</label>
                        <input name="password" type="password" required
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Confirmation</label>
                        <input name="password_confirmation" type="password" required
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm" placeholder="••••••••">
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── SECTION : Informations Société ──────────────────────── --}}
        <div>
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4 border-b border-slate-100 pb-2">02 · Votre Société</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Raison Sociale <span class="text-red-500">*</span></label>
                    <input name="company_name" type="text" value="{{ old('company_name') }}" required
                        class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                        placeholder="ACME MAROC SARL">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">ICE (15 chiffres)</label>
                        <input name="company_ice" type="text" value="{{ old('company_ice') }}" maxlength="15" pattern="\d{15}"
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                            placeholder="000000000000000">
                        <p class="text-[9px] text-slate-400 mt-1 px-1">Laissez vide → valeur temporaire automatique</p>
                    </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Registre Commerce (RC)</label>
                        <input name="company_rc" type="text" value="{{ old('company_rc') }}"
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                            placeholder="EX. 12345">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Identifiant Fiscal (IF)</label>
                        <input name="company_if" type="text" value="{{ old('company_if') }}" maxlength="9"
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                            placeholder="Identifiant Fiscal">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Ville</label>
                        <input name="company_city" type="text" value="{{ old('company_city') }}"
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                            placeholder="Casablanca">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Téléphone Société</label>
                        <input name="company_phone" type="text" value="{{ old('company_phone') }}"
                            class="w-full bg-slate-50 border-slate-200 placeholder-slate-300 rounded-2xl p-4 text-sm font-black focus:ring-blue-500 focus:border-blue-500 transition-all border shadow-sm"
                            placeholder="+212 6XX XXX XXX">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-slate-900 text-white p-5 rounded-3xl font-black shadow-xl shadow-blue-100 transition-all active:scale-[0.98] uppercase text-xs tracking-[0.2em]">
            Créer mon Espace Trésorerie →
        </button>

        <p class="text-center text-[10px] font-bold text-slate-400">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-blue-600 font-black underline decoration-blue-200">Se connecter</a>
        </p>
    </form>
</x-guest-layout>
