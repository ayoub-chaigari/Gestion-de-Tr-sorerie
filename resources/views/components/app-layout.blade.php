<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sovereign Pay - Enterprise Command</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-15px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
        .animate-fade-in-left { animation: fadeInLeft 0.5s ease-out forwards; }

        /* ── Dark Mode System ─────────────────────────────────── */
        .dark body,
        html.dark body { background-color: #0f172a !important; color: #e2e8f0; }
        html.dark .bg-gray-50,
        html.dark .bg-\[\#F8FAFC\] { background-color: #0f172a !important; }
        html.dark .bg-\[\#F8FAFC\]\/80 { background-color: rgba(15, 23, 42, 0.8) !important; }
        html.dark .bg-white { background-color: #1e293b !important; }
        html.dark .border-slate-50,
        html.dark .border-slate-100,
        html.dark .border-gray-50 { border-color: rgba(255,255,255,0.06) !important; }
        html.dark .text-slate-900,
        html.dark .text-gray-900 { color: #f1f5f9 !important; }
        html.dark .text-slate-800 { color: #e2e8f0 !important; }
        html.dark .text-slate-700 { color: #cbd5e1 !important; }
        html.dark .text-slate-500 { color: #94a3b8 !important; }
        html.dark .text-slate-400 { color: #64748b !important; }
        html.dark .bg-slate-50 { background-color: rgba(255,255,255,0.05) !important; }
        html.dark .shadow-xl,
        html.dark .shadow-2xl,
        html.dark .shadow-sm { --tw-shadow-color: rgba(0,0,0,0.3) !important; }
        html.dark .shadow-slate-200\/40,
        html.dark .shadow-slate-200\/50,
        html.dark .shadow-slate-200\/30 { --tw-shadow-color: rgba(0,0,0,0.4) !important; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3) !important; }
        /* Sidebar Non-SuperAdmin dark */
        html.dark aside:not(.bg-\[\#0b1120\]) { background-color: #1e293b !important; border-color: rgba(255,255,255,0.06) !important; }
        html.dark aside:not(.bg-\[\#0b1120\]) .text-slate-500 { color: #94a3b8 !important; }
        html.dark aside:not(.bg-\[\#0b1120\]) .text-\[\#0b1120\] { color: #f1f5f9 !important; }
        /* Inputs */
        html.dark input, html.dark select, html.dark textarea {
            background-color: rgba(255,255,255,0.05) !important;
            border-color: rgba(255,255,255,0.1) !important;
            color: #e2e8f0 !important;
        }
        html.dark input::placeholder, html.dark textarea::placeholder { color: #64748b !important; }
        /* Header pill */
        html.dark .bg-white.rounded-full { background-color: #1e293b !important; border-color: rgba(255,255,255,0.08) !important; }
        /* Cards hover */
        html.dark .hover\:bg-slate-50:hover { background-color: rgba(255,255,255,0.08) !important; }
        /* Emerald/Rose subtle bg */
        html.dark .bg-emerald-50 { background-color: rgba(0, 108, 74, 0.15) !important; }
        html.dark .bg-rose-50 { background-color: rgba(190, 30, 30, 0.15) !important; }
        html.dark .bg-blue-50 { background-color: rgba(59, 130, 246, 0.15) !important; }
        html.dark .bg-amber-50 { background-color: rgba(205, 168, 51, 0.15) !important; }
        html.dark .bg-purple-50 { background-color: rgba(124, 58, 237, 0.15) !important; }
        html.dark .bg-orange-50 { background-color: rgba(249, 115, 22, 0.15) !important; }
        /* Tables */
        html.dark table th { background-color: #0f172a !important; }
        html.dark table td { border-color: rgba(255,255,255,0.06) !important; }
        /* Dark mode toggle transition */
        .dark-toggle { transition: all 0.3s ease; }

        @keyframes shrink {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
    @stack('styles')
    <script>
        // Apply dark mode BEFORE page renders to prevent flash
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body x-data="{ sidebarOpen: false, ...globalNotifications() }" @auth x-init="initNotifications()" @endauth class="bg-gray-50 min-h-screen text-slate-900 font-sans selection:bg-blue-100 selection:text-blue-700">
    
    @auth
    @php
        $isSuperAdmin = auth()->check() && auth()->user()->role === 'SUPER_ADMIN';
    @endphp

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
         @click="sidebarOpen = false"
         x-cloak>
    </div>

    <!-- Sidebar (High-End Institutional Styling) -->
    <aside class="fixed inset-y-0 left-0 w-72 {{ $isSuperAdmin ? 'bg-[#0b1120] text-slate-400 border-r border-white/5' : 'bg-white text-slate-800 border-r border-slate-100 shadow-xl' }} z-50 transition-all duration-300 transform" 
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           x-data="{ oversightOpen: {{ request()->routeIs('superadmin.oversight.*') ? 'true' : 'false' }} }">
        <div class="h-full flex flex-col p-8 relative">
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="absolute top-4 right-4 text-slate-400 hover:text-white lg:hidden">
                <span class="material-symbols-outlined">close</span>
            </button>
            <!-- Logo Section -->
            @if($isSuperAdmin)
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-4 mb-16 group">
                    <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-blue-500/20 group-hover:scale-105 transition-transform duration-500">
                        <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tighter leading-none font-headline text-white italic">Treasury<span class="text-blue-500">Saas</span></h2>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-blue-400/60 font-black mt-2 font-headline">PLATFORM OWNER</p>
                    </div>
                </a>
            @else
                <a href="{{ route(auth()->user()->getHomeRoute()) }}" class="flex items-start gap-4 mb-16 group">
                    <div class="w-12 h-12 bg-[#0b1120] rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-105 transition-transform duration-500">
                        <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tighter leading-none font-headline text-[#0b1120]">Sovereign<span class="text-[#006C4A]">Pay</span></h2>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-[#0b1120]/40 font-black mt-2 font-headline">THE DIGITAL VAULT</p>
                    </div>
                </a>
            @endif

            <!-- Navigation -->
            <nav class="flex-1 space-y-1 overflow-y-auto custom-scrollbar -mx-2 px-2">
                @if($isSuperAdmin)
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 mt-4 px-4">{{ __('MAIN CONTROLS') }}</p>
                    
                    <a href="{{ route('superadmin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-white/10 text-white shadow-sm' : 'hover:bg-white/5 active:scale-95' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">space_dashboard</span>
                        {{ __('Command Dashboard') }}
                    </a>

                    <div class="space-y-1">
                        <button @click="oversightOpen = !oversightOpen" class="w-full group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all hover:bg-white/5">
                            <span class="material-symbols-outlined mr-4 text-[1.4rem] text-slate-500 group-hover:text-white">visibility</span>
                            <span class="flex-1 text-left">{{ __('Global Oversight') }}</span>
                            <span class="material-symbols-outlined text-[1rem] transition-transform duration-300" :class="oversightOpen ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="oversightOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pl-12 space-y-1">
                            <a href="{{ route('superadmin.oversight.cheques') }}" class="block py-2 text-xs font-bold transition-all {{ request()->routeIs('superadmin.oversight.cheques') ? 'text-blue-400' : 'text-slate-500 hover:text-white' }}">{{ __('Live Cheques') }}</a>
                            <a href="{{ route('superadmin.oversight.invoices') }}" class="block py-2 text-xs font-bold transition-all {{ request()->routeIs('superadmin.oversight.invoices') ? 'text-blue-400' : 'text-slate-500 hover:text-white' }}">{{ __('Direct Invoices') }}</a>
                            <a href="{{ route('superadmin.oversight.contacts') }}" class="block py-2 text-xs font-bold transition-all {{ request()->routeIs('superadmin.oversight.contacts') ? 'text-blue-400' : 'text-slate-500 hover:text-white' }}">{{ __('Registry') }}</a>
                        </div>
                    </div>

                    <a href="{{ route('superadmin.support.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('superadmin.support.*') ? 'bg-white/10 text-white shadow-sm' : 'hover:bg-white/5' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('superadmin.support.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">forum</span>
                        {{ __('Support Hub') }}
                        <span x-show="unreadSupportCount > 0" x-text="unreadSupportCount" class="ml-auto bg-rose-500 text-white text-[8px] px-2 py-0.5 rounded-full" x-cloak></span>
                    </a>

                    <a href="{{ route('companies.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('companies.*') ? 'bg-white/10 text-white shadow-sm' : 'hover:bg-white/5' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('companies.*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">corporate_fare</span>
                        {{ __('Tenant Management') }}
                    </a>

                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 mt-8 px-4">{{ __('ENGINEERING') }}</p>
                    <a href="{{ route('activity-logs.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('activity-logs.index') ? 'bg-white/10 text-white' : 'hover:bg-white/5 active:scale-95' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('activity-logs.index') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}">settings_input_component</span>
                        {{ __('System Logs') }}
                    </a>
                @endif

                @if(auth()->user()->role === 'ADMIN')
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 mt-8 px-4">{{ __('Treasury & Governance') }}</p>
                    
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('dashboard') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">dashboard</span>
                        {{ __('Tenant Dashboard') }}
                    </a>

                    <a href="{{ route('bank-accounts.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('bank-accounts.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('bank-accounts.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">account_balance</span>
                        {{ __('Bank Treasury') }}
                    </a>

                    <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('users.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">group</span>
                        {{ __('Team Control') }}
                    </a>
                @endif

                @if(auth()->user()->role !== 'SUPER_ADMIN')
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 mt-8 px-4">{{ __('Operational Ledger') }}</p>
                
                <a href="{{ route('contacts.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('contacts.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('contacts.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">badge</span>
                    {{ __('Partner Entities') }}
                </a>

                <a href="{{ route('invoices.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('invoices.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('invoices.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">description</span>
                    {{ __('Liquidity Liabilities') }}
                </a>

                <div class="space-y-1">
                    <a href="{{ route('cheques.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('cheques.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('cheques.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">payments</span>
                        {{ __('Inbound Assets') }}
                    </a>
                    
                    <a href="{{ route('outgoing-cheques.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('outgoing-cheques.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                        <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('outgoing-cheques.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">outbound</span>
                        {{ __('Outbound Assets') }}
                    </a>
                </div>

                <a href="{{ route('remittances.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('remittances.*') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('remittances.*') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">account_balance_wallet</span>
                    {{ __('Remittance Slips') }}
                </a>

                <a href="{{ route('rejections.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('rejections.index') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('rejections.index') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">priority_high</span>
                    {{ __('Breaches & Litigation') }}
                </a>

                @if(auth()->user()->role === 'ADMIN')
                <a href="{{ route('activity-logs.index') }}" class="group flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all {{ request()->routeIs('activity-logs.index') ? 'bg-[#006C4A] text-white shadow-lg shadow-[#006C4A]/30' : 'text-slate-500 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined mr-4 text-[1.4rem] {{ request()->routeIs('activity-logs.index') ? 'text-white' : 'text-slate-400 group-hover:text-[#006C4A]' }}">settings</span>
                    {{ __('System Audit') }}
                </a>
                @endif
                @endif {{-- end non-superadmin --}}
            </nav>

            <!-- Transaction Action - Admin only -->
            @if(auth()->user()->role !== 'SUPER_ADMIN')
            <div class="mt-12 px-2">
                <a href="{{ route('cheques.create') }}" class="flex items-center justify-center w-full py-5 bg-[#CDA833] text-[#111827] rounded-[2rem] font-black text-xs uppercase tracking-widest shadow-2xl shadow-[#CDA833]/40 hover:scale-[1.02] hover:shadow-[#CDA833]/60 transition-all duration-300">
                    {{ __('New Transaction') }}
                </a>
            </div>
            @endif

            <!-- Bottom Tools -->
            <div class="mt-auto pt-10 space-y-2">
                @if(auth()->user()->role !== 'SUPER_ADMIN')
                <a href="{{ route('support.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-[#0b1120] transition-colors text-xs font-bold">
                    <span class="material-symbols-outlined text-[1.2rem]">help</span>
                    {{ __('Help Center') }}
                </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-rose-600 transition-colors text-xs font-bold w-full text-left">
                        <span class="material-symbols-outlined text-[1.2rem]">logout</span>
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Wrapper -->
    <main class="flex-1 flex flex-col min-h-screen {{ auth()->check() ? 'lg:pl-72' : '' }} bg-[#F8FAFC]">
        @auth
        <header class="sticky top-0 bg-[#F8FAFC]/80 backdrop-blur-2xl z-20 px-4 lg:px-10 py-6 flex justify-between items-center lg:mr-4">
            <div class="flex items-center gap-4">
                <!-- Hamburger Menu for mobile -->
                <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm border border-slate-100 text-[#0b1120]">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="text-lg lg:text-2xl font-black text-slate-900 font-headline tracking-tight">{{ __('Corporate Liquidity Pulse') }}</h1>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2 lg:gap-8">
                <!-- Language Switcher - Hide text labels on mobile if needed, or just keep icons -->
                <div class="flex items-center bg-white rounded-xl p-1 gap-1 border border-slate-100 shadow-sm mr-2 scale-90 lg:scale-100">
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 text-[10px] font-black rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'bg-[#006C4A] text-white shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">EN</a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="px-2 py-1 text-[10px] font-black rounded-lg transition-all {{ app()->getLocale() == 'fr' ? 'bg-[#006C4A] text-white shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">FR</a>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" id="darkModeToggle" class="dark-toggle w-10 h-10 flex items-center justify-center bg-white rounded-full shadow-sm hover:shadow-md border border-slate-100 transition-all group" title="Toggle Dark Mode">
                    <span class="material-symbols-outlined text-[1.2rem] text-slate-400 group-hover:text-[#006C4A] transition-colors" id="darkModeIcon">dark_mode</span>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="w-12 h-12 flex items-center justify-center bg-white rounded-full shadow-sm hover:shadow-md transition-all group relative">
                        <span class="material-symbols-outlined text-[#0b1120]/40 group-hover:text-[#006C4A]">notifications</span>
                        <template x-if="unreadCount > 0">
                            <span class="absolute top-2 right-2 w-4 h-4 bg-rose-500 border-2 border-[#F8FAFC] rounded-full flex items-center justify-center text-white text-[7px] font-black" x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                        </template>
                        <template x-if="unreadCount === 0">
                            <span class="absolute top-3 right-3 w-2 h-2 bg-[#006C4A] border-2 border-[#F8FAFC] rounded-full"></span>
                        </template>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-14 w-80 bg-white rounded-3xl shadow-2xl shadow-slate-900/10 border border-slate-100 overflow-hidden z-50" x-cloak>

                        <div class="px-6 py-4 border-b border-slate-50 flex justify-between items-center">
                            <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-widest">{{ __('Notifications') }}</h3>
                            <button @click="; open = false" x-show="unreadCount > 0" class="text-[9px] font-black text-[#006C4A] uppercase tracking-widest hover:underline">{{ __('Mark all read') }}</button>
                        </div>

                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                            <template x-if="notifications.length === 0">
                                <div class="py-10 text-center">
                                    <span class="material-symbols-outlined text-slate-200 text-4xl">notifications_off</span>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-3">{{ __('No new notifications') }}</p>
                                </div>
                            </template>
                            <template x-for="notif in notifications" :key="notif.id">
                                <div @click="markAsRead(notif.id); open = false" class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 cursor-pointer transition-all">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                                        :class="notif.read_at ? 'bg-slate-100 text-slate-400' : 'bg-[#006C4A]/10 text-[#006C4A]'">
                                        <span class="material-symbols-outlined text-[1rem]">circle_notifications</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-black text-slate-900 leading-snug" x-text="notif.message ?? notif.title ?? 'Notification'"></p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1" x-text="notif.created_at_human"></p>
                                    </div>
                                    <span x-show="!notif.read_at" class="w-2 h-2 bg-[#006C4A] rounded-full shrink-0 mt-2"></span>
                                </div>
                            </template>
                        </div>

                        @if(auth()->user()->role !== 'SUPER_ADMIN')
                        <div class="px-6 py-3 border-t border-slate-50">
                            <a href="{{ route('support.index') }}" class="text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-[#006C4A] transition-colors">{{ __('Support Center') }} →</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Pill -->
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 bg-white pl-2 pr-2 lg:pr-6 py-2 rounded-full shadow-sm border border-slate-100 hover:shadow-md hover:scale-[1.02] transition-all duration-300 cursor-pointer">
                    <div class="w-10 h-10 bg-[#0b1120] rounded-full flex items-center justify-center text-white overflow-hidden shadow-inner shrink-0">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ Storage::url(auth()->user()->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <span class="font-black text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-[11px] font-black text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
                    </div>
                </a>
            </div>
        </header>
        @endauth

        <div class="flex-1 p-4 lg:p-10">
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 10000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="mb-10 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl flex items-center shadow-sm relative overflow-hidden group">
                    <div class="absolute bottom-0 left-0 h-0.5 bg-emerald-200/50 group-hover:bg-emerald-300 transition-all" 
                         style="width: 100%; animation: shrink 10s linear forwards;"></div>
                    <div class="bg-emerald-500 text-white rounded-xl p-1.5 mr-4 ring-4 ring-emerald-50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm font-black">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600 transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 10000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="mb-10 p-5 bg-amber-50 border border-amber-100 text-amber-700 rounded-3xl flex items-center shadow-sm relative overflow-hidden group">
                    <div class="absolute bottom-0 left-0 h-0.5 bg-amber-200/50 group-hover:bg-amber-300 transition-all" 
                         style="width: 100%; animation: shrink 10s linear forwards;"></div>
                    <div class="bg-amber-500 text-white rounded-xl p-1.5 mr-4 ring-4 ring-amber-50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span class="text-sm font-black">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-amber-400 hover:text-amber-600 transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            {{ $slot }}
        </div>


    </main>

    @stack('scripts')
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 600,
                easing: 'ease-out-cubic',
                offset: 50,
            });
        });

        function globalNotifications() {
            return {
                unreadSupportCount: 0,
                unreadCount: 0,
                notifications: [],
                initNotifications() {
                    this.fetchCounts();
                    setInterval(() => this.fetchCounts(), 30000);
                },
                async fetchCounts() {
                    try {
                        let supportResp = await fetch("{{ route('support.unread') }}");
                        let supportData = await supportResp.json();
                        this.unreadSupportCount = supportData.count;

                        let notifResp = await fetch("{{ route('notifications.latest') }}");
                        let notifData = await notifResp.json();
                        this.notifications = notifData.notifications;
                        this.unreadCount = notifData.unread_count;
                    } catch (e) {
                        console.log("Global Notification fetch failed");
                    }
                },
                async markAsRead(id) {
                    try {
                        await fetch(`/notifications/${id}/read`, {
                            method: 'PATCH',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        this.fetchCounts();
                    } catch (e) {
                        console.log("Mark as read failed");
                    }
                }
            }
        }

        // ── Dark Mode Toggle ──────────────────────────────────────────────────
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
            updateDarkModeIcon(isDark);
        }

        function updateDarkModeIcon(isDark) {
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                icon.textContent = isDark ? 'light_mode' : 'dark_mode';
            }
        }

        // Initialize icon on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = localStorage.getItem('darkMode') === 'true';
            updateDarkModeIcon(isDark);
        });
    </script>
</body>
</html>
