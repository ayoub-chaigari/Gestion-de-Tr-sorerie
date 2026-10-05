<x-guest-layout>
    <div class="mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 100ms; animation-fill-mode: forwards;">
        <h1 class="text-[2rem] font-black text-slate-900 tracking-tight font-headline mb-3 leading-tight">Reset Passkey</h1>
        <p class="text-[14px] text-slate-500 font-medium leading-relaxed">
            Securely update your authorization credentials below.
        </p>
    </div>

    <form class="space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: forwards;" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-5">
            <!-- Email -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Identifier</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">mail</span>
                    </div>
                    <input name="email" type="email" value="{{ $email ?? old('email') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300">
                </div>
                @error('email') <p class="text-red-500 text-[10px] font-bold py-1 uppercase tracking-wide">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">New Secret Passkey</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">lock</span>
                    </div>
                    <input name="password" type="password" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="••••••••">
                </div>
                @error('password') <p class="text-red-500 text-[10px] font-bold py-1 uppercase tracking-wide">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm Secret Passkey</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">lock_reset</span>
                    </div>
                    <input name="password_confirmation" type="password" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-4 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="••••••••">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#111827] hover:bg-[#006C4A] text-white py-4 rounded-xl font-bold transition-all duration-300 transform active:scale-[0.98] hover:shadow-xl hover:shadow-[#006C4A]/20 mt-8 text-[14px] flex items-center justify-center gap-2">
            <span>Update Credentials</span>
            <span class="material-symbols-outlined text-[1.1rem]">published_with_changes</span>
        </button>
    </form>
</x-guest-layout>
