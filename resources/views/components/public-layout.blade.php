<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'Sovereign Pay | Support Your Growth' }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Alpine.js with Intersect plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
              "on-secondary-fixed": "#002114",
              "primary-fixed-dim": "#bec6e0",
              "secondary-container": "#82f5c1",
              "tertiary-container": "#cba72f",
              "outline-variant": "#c6c6cd",
              "on-surface": "#131b2e",
              "on-background": "#131b2e",
              "surface-container-high": "#e2e7ff",
              "primary": "#000000",
              "tertiary-fixed-dim": "#e9c349",
              "surface-dim": "#d2d9f4",
              "on-tertiary": "#ffffff",
              "surface-container-low": "#f2f3ff",
              "primary-fixed": "#dae2fd",
              "on-surface-variant": "#45464d",
              "on-secondary-container": "#00714e",
              "surface-bright": "#faf8ff",
              "error-container": "#ffdad6",
              "inverse-primary": "#bec6e0",
              "surface-container": "#eaedff",
              "on-secondary": "#ffffff",
              "on-tertiary-fixed-variant": "#574500",
              "on-tertiary-fixed": "#241a00",
              "on-primary-fixed": "#131b2e",
              "on-secondary-fixed-variant": "#005137",
              "surface-tint": "#565e74",
              "tertiary": "#735c00",
              "on-primary-container": "#7c839b",
              "surface-container-highest": "#dae2fd",
              "secondary-fixed-dim": "#68dba9",
              "tertiary-fixed": "#ffe088",
              "background": "#faf8ff",
              "primary-container": "#131b2e",
              "outline": "#76777d",
              "surface": "#faf8ff",
              "secondary": "#006c4a",
              "secondary-fixed": "#85f8c4",
              "on-error-container": "#93000a",
              "surface-variant": "#dae2fd",
              "on-primary": "#ffffff",
              "inverse-surface": "#283044",
              "error": "#ba1a1a",
              "on-primary-fixed-variant": "#3f465c",
              "on-tertiary-container": "#4e3d00",
              "surface-container-lowest": "#ffffff",
              "on-error": "#ffffff",
              "inverse-on-surface": "#eef0ff"
            },
            "borderRadius": {
              "DEFAULT": "1rem",
              "lg": "2rem",
              "xl": "3rem",
              "full": "9999px"
            },
            "fontFamily": {
              "headline": ["Plus Jakarta Sans"],
              "body": ["Inter"],
              "label": ["Inter"]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-secondary-container">
    
    <!-- TopNavBar -->
    <nav x-data="{ scrolled: false, mobileMenuOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)" 
         :class="scrolled ? 'bg-white/80 backdrop-blur-lg shadow-sm border-b border-outline-variant/10' : 'bg-transparent'"
         class="fixed top-0 w-full z-[100] h-24 transition-all duration-300">
        <div class="flex justify-between items-center max-w-7xl mx-auto px-6 md:px-10 h-full">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tighter text-slate-900 font-headline">Sovereign Pay</a>
            <div class="hidden md:flex items-center gap-10 font-body text-xs font-semibold tracking-wide text-on-surface-variant">
                <a class="{{ request()->routeIs('features') ? 'text-secondary border-b-2 border-secondary pb-1' : 'hover:text-slate-900' }} transition-all duration-300" href="{{ route('features') }}">{{ __('Features') }}</a>
                <a class="{{ request()->routeIs('solutions') ? 'text-secondary border-b-2 border-secondary pb-1' : 'hover:text-slate-900' }} transition-all duration-300" href="{{ route('solutions') }}">{{ __('Solutions') }}</a>
                <a class="{{ request()->routeIs('pricing') ? 'text-secondary border-b-2 border-secondary pb-1' : 'hover:text-slate-900' }} transition-all duration-300" href="{{ route('pricing') }}">{{ __('Pricing') }}</a>
                <a class="{{ request()->routeIs('contact') ? 'text-secondary border-b-2 border-secondary pb-1' : 'hover:text-slate-900' }} transition-all duration-300" href="{{ route('contact') }}">{{ __('Contact') }}</a>
            </div>
            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Language Switcher -->
                <div class="flex items-center bg-slate-100 rounded-full p-1 gap-1 border border-slate-200/50">
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 text-[9px] font-black rounded-full transition-all {{ app()->getLocale() == 'en' ? 'bg-white text-secondary shadow-sm' : 'text-slate-400' }}">EN</a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="px-2 py-1 text-[9px] font-black rounded-full transition-all {{ app()->getLocale() == 'fr' ? 'bg-white text-secondary shadow-sm' : 'text-slate-400' }}">FR</a>
                </div>

                <!-- Desktop/Tablet Actions -->
                <div class="hidden sm:flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-900 hover:text-slate-600 transition-all duration-300">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-xs font-bold bg-primary text-on-primary rounded-full hover:shadow-lg transition-all duration-300 active:scale-95">{{ __('Get Started') }}</a>
                </div>

                <!-- Mobile Hamburger Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 flex items-center justify-center text-on-surface bg-slate-100 rounded-full transition-all">
                    <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 -translate-y-10" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 -translate-y-10" 
             class="md:hidden fixed top-24 left-0 w-full bg-white border-b border-outline-variant/10 shadow-2xl z-[90] p-8 space-y-8"
             x-cloak>
            <div class="flex flex-col gap-6 text-sm font-black text-on-surface-variant uppercase tracking-[0.2em]">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="hover:text-secondary transition-colors">{{ __('Home') }}</a>
                <a href="{{ route('features') }}" @click="mobileMenuOpen = false" class="hover:text-secondary transition-colors">{{ __('Features') }}</a>
                <a href="{{ route('solutions') }}" @click="mobileMenuOpen = false" class="hover:text-secondary transition-colors">{{ __('Solutions') }}</a>
                <a href="{{ route('pricing') }}" @click="mobileMenuOpen = false" class="hover:text-secondary transition-colors">{{ __('Pricing') }}</a>
                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="hover:text-secondary transition-colors">{{ __('Contact') }}</a>
            </div>
            <div class="pt-6 border-t border-outline-variant/10 flex flex-col gap-4">
                <a href="{{ route('login') }}" class="w-full text-center py-4 text-sm font-black text-on-surface uppercase tracking-widest">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="w-full text-center py-4 bg-primary text-on-primary rounded-full text-sm font-bold shadow-lg shadow-primary/20">{{ __('Register Account') }}</a>
            </div>
        </div>
    </nav>

    <main class="w-full overflow-hidden">
        {{ $slot }}
    </main>

    <!-- Premium Fat Footer -->
    <footer class="bg-[#0b1120] w-full pt-20 pb-10 border-t border-white/5 font-body relative overflow-hidden text-slate-300">
        <!-- Subtle Top Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-px bg-gradient-to-r from-transparent via-[#006c4a]/50 to-transparent"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/2 h-24 bg-[#006c4a]/10 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-16 relative z-10">
                
                <!-- Brand Column -->
                <div class="lg:col-span-4">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter text-white font-headline mb-6 block">Sovereign Pay</a>
                    <p class="text-sm leading-relaxed mb-8 max-w-sm">
                        The architectural gold standard for digital payments in the Maghreb region. Built for stability, scale, and sovereign compliance under Law 69-21.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#006c4a] hover:border-transparent transition-all group">
                            <span class="text-white text-sm font-bold group-hover:scale-110 transition-transform">in</span>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#006c4a] hover:border-transparent transition-all group">
                            <span class="text-white text-sm font-bold group-hover:scale-110 transition-transform">X</span>
                        </a>
                    </div>
                </div>

                <!-- Product Column -->
                <div class="lg:col-span-2 lg:col-start-6">
                    <h4 class="text-white font-bold mb-6 tracking-wide text-sm uppercase">Product</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="{{ route('features') }}" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Platform Features</a></li>
                        <li><a href="{{ route('solutions') }}" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Enterprise Solutions</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Pricing & Tiers</a></li>
                        <li><a href="#" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Digital Vault API</a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-bold mb-6 tracking-wide text-sm uppercase">Company</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">About Us</a></li>
                        <li><a href="#" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Careers</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">Contact Sales</a></li>
                        <li><a href="#" class="hover:text-[#85f8c4] hover:translate-x-1 inline-block transition-all">System Status</a></li>
                    </ul>
                </div>

                <!-- Newsletter Column -->
                <div class="lg:col-span-3">
                    <h4 class="text-white font-bold mb-6 tracking-wide text-sm uppercase">Compliance Updates</h4>
                    <p class="text-sm mb-4">Stay informed on BAM regulations and Law 69-21 mandates.</p>
                    <form class="relative group">
                        <input type="email" placeholder="Email address" class="w-full bg-white/5 border border-white/10 rounded-full px-5 py-3 text-sm text-white placeholder:text-slate-500 focus:outline-none focus:border-[#006c4a] focus:ring-1 focus:ring-[#006c4a] transition-all">
                        <button type="button" class="absolute right-1 top-1 bottom-1 px-4 bg-[#006c4a] text-white rounded-full text-xs font-bold hover:bg-[#005137] transition-all">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Legal Bar -->
            <div class="border-t border-white/10 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
                <p class="text-xs font-medium tracking-wide">
                    © {{ date('Y') }} Sovereign Pay. Built with trust in Casablanca. Regulated by Bank Al-Maghrib.
                </p>
                <div class="flex gap-6 text-xs font-medium">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
        
        <!-- Decorative Glow Bottom -->
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#006c4a]/10 rounded-full blur-[100px] pointer-events-none"></div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        });
    </script>
</body>
</html>
