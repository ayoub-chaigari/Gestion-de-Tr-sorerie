<x-guest-layout>
    <div class="mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 100ms; animation-fill-mode: forwards;">
        <h1 class="text-[2.2rem] font-black text-slate-900 tracking-tight font-headline mb-3 leading-tight">{{ __('Create Account') }}</h1>
        <p class="text-[14px] font-medium text-slate-500">
            {{ __('Join the elite circle of institutional treasury management.') }}
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 rounded-xl p-4 animate-fade-in-up">
            @foreach($errors->all() as $error)
                <p class="text-[11px] text-red-600 font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    {{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    <form class="space-y-8 opacity-0 animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: forwards;" action="{{ route('register') }}" method="POST">
        @csrf

        {{-- Section 1: Identity --}}
        <div class="space-y-4">
            <h3 class="text-[10px] font-black text-[#006C4A] uppercase tracking-[0.2em] border-b border-slate-100 pb-3 mb-6">01 · {{ __('Personal Identity') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Full Name') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                            <span class="material-symbols-outlined text-[1.2rem]">person</span>
                        </div>
                        <input name="name" type="text" value="{{ old('name') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="John Doe">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Work Email') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                            <span class="material-symbols-outlined text-[1.2rem]">mail</span>
                        </div>
                        <input name="email" type="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="doe@company.ma">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Password') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                            <span class="material-symbols-outlined text-[1.2rem]">lock</span>
                        </div>
                        <input name="password" type="password" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="••••••••">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Confirm') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                            <span class="material-symbols-outlined text-[1.2rem]">lock_reset</span>
                        </div>
                        <input name="password_confirmation" type="password" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="••••••••">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Company --}}
        <div class="space-y-4">
            <h3 class="text-[10px] font-black text-[#006C4A] uppercase tracking-[0.2em] border-b border-slate-100 pb-3 mb-6">02 · {{ __('Company Details') }}</h3>
            
            <div class="space-y-2 text-left">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Entity Legal Name') }}</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">domain</span>
                    </div>
                    <input name="company_name" type="text" value="{{ old('company_name') }}" required class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="ACME MAROC SARL">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('ICE (15 digits)') }}</label>
                    <input name="company_ice" type="text" value="{{ old('company_ice') }}" maxlength="15" pattern="\d{15}" class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 px-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="000... (Optional)">
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Registre Commerce (RC)') }}</label>
                    <input name="company_rc" type="text" value="{{ old('company_rc') }}" class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 px-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="RC Number">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Identifiant Fiscal (IF)') }}</label>
                    <input name="company_if" type="text" value="{{ old('company_if') }}" maxlength="9" class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 px-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="IF Number">
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('City') }}</label>
                    <input name="company_city" type="text" value="{{ old('company_city') }}" class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 px-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="Casablanca">
                </div>
            </div>

            <div class="space-y-2 text-left">
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">{{ __('Work Phone Number') }}</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#006C4A] transition-colors">
                        <span class="material-symbols-outlined text-[1.2rem]">call</span>
                    </div>
                    <input name="company_phone" type="text" value="{{ old('company_phone') }}" class="w-full bg-slate-50 border border-slate-200 placeholder-slate-300 rounded-xl py-3 pl-12 pr-4 text-sm font-semibold text-slate-800 focus:ring-4 focus:ring-[#006C4A]/5 focus:border-[#006C4A] focus:bg-white transition-all duration-300" placeholder="+212 6XX XXX XXX">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#111827] hover:bg-[#006C4A] text-white py-4 rounded-xl font-bold transition-all duration-300 transform active:scale-[0.98] hover:shadow-xl hover:shadow-[#006C4A]/20 mt-4 text-[14px] flex items-center justify-center gap-2">
            <span>{{ __('Initialize My Ecosystem') }}</span>
            <span class="material-symbols-outlined text-[1.1rem]">rocket_launch</span>
        </button>

        <div class="text-center mt-10 pb-10">
            <p class="text-[13px] text-slate-500 font-medium">
                {{ __('Already registered?') }} <a href="{{ route('login') }}" class="text-[#006C4A] font-bold hover:underline ml-1">{{ __('Login here') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>
