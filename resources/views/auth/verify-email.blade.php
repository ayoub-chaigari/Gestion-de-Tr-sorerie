<x-guest-layout>
    <div class="mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 100ms; animation-fill-mode: forwards;">
        <h1 class="text-[2rem] font-black text-slate-900 tracking-tight font-headline mb-3 leading-tight">Verify Your Account</h1>
        <p class="text-[14px] text-slate-500 font-medium leading-relaxed">
            Before proceeding, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-100 rounded-xl">
            <p class="text-[12px] font-bold text-[#006C4A] uppercase tracking-wide">
                A new verification link has been sent to the email address you provided during registration.
            </p>
        </div>
    @endif

    <div class="space-y-4 opacity-0 animate-fade-in-up" style="animation-delay: 200ms; animation-fill-mode: forwards;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-[#111827] hover:bg-[#006C4A] text-white py-4 rounded-xl font-bold transition-all duration-300 transform active:scale-[0.98] hover:shadow-xl hover:shadow-[#006C4A]/20 text-[14px] flex items-center justify-center gap-2">
                <span>Resend Verification Email</span>
                <span class="material-symbols-outlined text-[1.1rem]">mark_email_read</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-[13px] text-slate-500 font-bold hover:text-red-600 transition-colors uppercase tracking-widest">
                Sign Out
            </button>
        </form>
    </div>
</x-guest-layout>
