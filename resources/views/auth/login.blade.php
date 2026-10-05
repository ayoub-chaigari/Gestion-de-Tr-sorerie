<x-guest-layout>
    <div class="mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 100ms; animation-fill-mode: forwards;">
        <h1 class="text-[2rem] font-black text-slate-900 tracking-tight font-headline mb-3 leading-tight">{{ __('Welcome Back!') }}</h1>
    </div>

    <form class="space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: forwards;" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <!-- Email -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Identifier') }}</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">mail</span>
                    </div>
                    <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="user@holding.ma">
                </div>
                @error('email') <p class="text-red-500 text-[10px] font-bold py-1 uppercase tracking-wide">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center ml-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest">{{ __('Secret Passkey') }}</label>
                    <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-[#006C4A] hover:underline uppercase tracking-tight">{{ __('Forgot?') }}</a>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">lock</span>
                    </div>
                    <input name="password" type="password" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="••••••••">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#111827] hover:bg-[#006C4A] text-white py-4 rounded-xl font-bold transition-all duration-300 transform active:scale-[0.98] hover:shadow-xl hover:shadow-[#006C4A]/20 mt-8 text-[14px] flex items-center justify-center gap-2">
            <span>{{ __('Login to Dashboard') }}</span>
            <span class="material-symbols-outlined text-[1.1rem]">arrow_forward</span>
        </button>

        <div class="text-center mt-12 pt-8 border-t border-slate-100">
            <p class="text-[13px] text-slate-500 font-medium tracking-tight">
                {{ __('New partner?') }} <a href="{{ route('register') }}" class="text-[#006C4A] font-bold hover:underline ml-1">{{ __('Apply for an account') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>
