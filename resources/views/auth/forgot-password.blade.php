<x-guest-layout>
    <div class="mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 100ms; animation-fill-mode: forwards;">
        <h1 class="text-[2rem] font-black text-slate-900 tracking-tight font-headline mb-3 leading-tight">Identity Recovery</h1>
        <p class="text-[14px] text-slate-500 font-medium leading-relaxed">
            Forgot your secret passkey? Tell us your identifier and we will transmit a secure reset link to your authorized email.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-100 rounded-xl">
            <p class="text-[12px] font-bold text-[#006C4A] uppercase tracking-wide">
                {{ session('status') }}
            </p>
        </div>
    @endif

    <form class="space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: forwards;" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <!-- Email -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Authorized Identifier</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">mail</span>
                    </div>
                    <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="user@holding.ma">
                </div>
                @error('email') <p class="text-red-500 text-[10px] font-bold py-1 uppercase tracking-wide">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="w-full bg-[#111827] hover:bg-[#006C4A] text-white py-4 rounded-xl font-bold transition-all duration-300 transform active:scale-[0.98] hover:shadow-xl hover:shadow-[#006C4A]/20 mt-8 text-[14px] flex items-center justify-center gap-2">
            <span>Transmit Reset Link</span>
            <span class="material-symbols-outlined text-[1.1rem]">send</span>
        </button>

        <div class="text-center mt-12 pt-8 border-t border-slate-100">
            <p class="text-[13px] text-slate-500 font-medium tracking-tight">
                Remembered? <a href="{{ route('login') }}" class="text-[#006C4A] font-bold hover:underline ml-1">Return to Login</a>
            </p>
        </div>
    </form>
</x-guest-layout>
