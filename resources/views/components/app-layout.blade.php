<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Treasury - Monolith</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-900 font-sans">
    
    @auth
    <!-- Sidebar -->
    <aside class="w-72 bg-slate-900 text-white min-h-screen flex flex-col shadow-2xl z-20">
        <div class="p-8 border-b border-slate-800 bg-slate-900/50 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black tracking-tight leading-none">Treasury <span class="text-blue-500">SaaS</span></h2>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mt-1">Plateforme Monolithe</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 mt-6 px-4 space-y-1 overflow-y-auto custom-scrollbar">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 mt-4">Principal</p>
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Tableau de Bord
            </a>
            <a href="{{ route('contacts.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('contacts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('contacts.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tiers (Contacts)
            </a>
            <a href="{{ route('invoices.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('invoices.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('invoices.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Factures Fournisseurs
            </a>

            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 mt-6">Réglement Entrant</p>
            <a href="{{ route('cheques.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('cheques.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('cheques.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Chèques Recettes
            </a>
            <a href="{{ route('remittances.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('remittances.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('remittances.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Bordereaux de Remise
            </a>
            <a href="{{ route('rejections.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('rejections.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('rejections.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                Gestion des Contentieux
            </a>

            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 mt-6">Réglement Sortant</p>
            <a href="{{ route('outgoing-cheques.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('outgoing-cheques.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('outgoing-cheques.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Paiements Emis
            </a>

            @if(auth()->user()->role === 'ADMIN' || auth()->user()->role === 'SUPER_ADMIN')
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 mt-6">Administration</p>
            <a href="{{ route('bank-accounts.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('bank-accounts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('bank-accounts.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Gestion Bancaire
            </a>
            <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Gestion Équipe
            </a>
            @endif

            @if(auth()->user()->role === 'SUPER_ADMIN')
            <a href="{{ route('companies.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl border border-blue-500/30 transition-all {{ request()->routeIs('companies.*') ? 'bg-blue-600 text-white' : 'text-blue-400 hover:bg-blue-600 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Gestion Entreprises
            </a>
            @endif
        </nav>

        <div class="p-6 border-t border-slate-800 bg-slate-900/30">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm font-medium text-slate-400 hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        @auth
        <!-- Top Nav -->
        <header class="bg-white/80 backdrop-blur-md z-10 px-8 py-4 flex justify-between items-center border-b border-slate-200">
            <div>
                <h1 class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Instance Active</h1>
                <p class="text-sm font-black text-slate-900">{{ auth()->user()->company->name ?? 'Indépendant' }}</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <h1 class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Utilisateur</h1>
                    <p class="text-sm font-black text-slate-900">{{ auth()->user()->name }}</p>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-black text-slate-400 border border-slate-200">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>
        @endauth

        <!-- Content Area -->
        <div class="flex-1 overflow-auto p-8 custom-scrollbar">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center shadow-sm">
                    <div class="bg-emerald-500 text-white rounded-full p-1 mr-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl shadow-sm">
                    <ul class="list-disc list-inside text-sm font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>
</body>
</html>
