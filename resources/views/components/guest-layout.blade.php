<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sovereign Pay - Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-fade-in-left { animation: fadeInLeft 0.6s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen flex bg-white font-inter text-slate-800 antialiased selection:bg-[#006c4a] selection:text-white">
    
    <!-- Left Pane (Color - Sovereign Brand) -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-[40%] text-white bg-[#006C4A] p-10 xl:p-16 flex-col justify-between relative shadow-[inset_-20px_0_40px_rgba(0,0,0,0.1)]">
        <!-- Subtle Geometric Lines Decoration -->
        <div class="absolute inset-0 opacity-10 pointer-events-none overflow-hidden">
            <svg viewBox="0 0 100 100" class="absolute w-[200%] h-[200%] bottom-[-50%] right-[-50%]" preserveAspectRatio="none">
                <circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="0.2"/>
                <circle cx="50" cy="50" r="30" fill="none" stroke="white" stroke-width="0.2"/>
                <circle cx="50" cy="50" r="20" fill="none" stroke="white" stroke-width="0.2"/>
                <circle cx="50" cy="50" r="10" fill="none" stroke="white" stroke-width="0.2"/>
            </svg>
        </div>
        
        <!-- Top Icon -->
        <div class="relative z-10 w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm mt-8 border border-white/20 opacity-0 animate-fade-in-left" style="animation-delay: 100ms;">
            <span class="material-symbols-outlined text-white text-2xl font-light">account_balance</span>
        </div>
        
        <!-- Big Greeting text -->
        <div class="relative z-10 -mt-20">
            <h1 class="text-5xl lg:text-6xl font-black font-headline mb-6 tracking-tight leading-[1.1] opacity-0 animate-fade-in-left" style="animation-delay: 300ms;">{{ __('Hello') }}<br>{{ __('Sovereign!') }} 👋</h1>
            <p class="text-[15px] font-medium text-white/80 leading-relaxed max-w-sm opacity-0 animate-fade-in-left" style="animation-delay: 500ms;">
                {{ __('Command your liquidity with institutional precision. Get highly productive through real-time banking automation and save tons of time!') }}
            </p>
        </div>

        <!-- Footer watermark -->
        <div class="relative z-10 text-[12px] text-white/60 font-medium tracking-wide opacity-0 animate-fade-in-left" style="animation-delay: 700ms;">
            © 2024 Sovereign Finance. All rights reserved.
        </div>
    </div>

    <!-- Right Pane (White Form Side) -->
    <div class="w-full lg:w-[55%] xl:w-[60%] flex flex-col pt-10 px-8 md:px-16 lg:px-24 xl:px-32 relative overflow-y-auto min-h-screen">
        
        <!-- Logo Top Left -->
        <div class="flex items-center gap-2 mb-10 w-full opacity-0 animate-fade-in-up" style="animation-delay: 800ms;">
            <a href="/" class="text-2xl font-extrabold tracking-tighter text-slate-900 font-headline">
                Sovereign<span class="text-[#006C4A]">Pay</span>
            </a>
        </div>

        <!-- The Content Slot -->
        <div class="flex-grow flex flex-col justify-center w-full max-w-[420px] mx-auto pb-20">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>
