<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Treasury - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .auth-bg {
            background: radial-gradient(circle at top right, #3b82f6 0%, #1e1b4b 100%);
        }
    </style>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-6 font-sans">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>
        
        <p class="text-center text-blue-200/50 text-[10px] mt-8 uppercase tracking-[0.3em] font-black">
            Plateforme Monolithe • Trésorerie SaaS
        </p>
    </div>
</body>
</html>
