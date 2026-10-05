@props([
    'title' => 'Ready to Sovereignize Your <br/> Payments?',
    'subtitle' => 'Join the elite club of Moroccan enterprises optimizing their treasury for the next decade of growth.'
])

<section class="py-24 px-6 w-full max-w-5xl mx-auto relative z-10" data-aos="fade-up" data-aos-duration="1000">
    <div class="relative w-full rounded-[2rem] overflow-hidden bg-white shadow-[0_8px_30px_rgb(0,0,0,0.08)] p-16 md:p-24 text-center border border-slate-100">
        
        <!-- Decorative Left Ring -->
        <div class="absolute top-1/2 -left-32 -translate-y-1/2 w-80 h-80 rounded-full border-[50px] border-[#006c4a]/80 opacity-70 blur-[12px] pointer-events-none" data-aos="fade-right" data-aos-delay="200"></div>
        <!-- Decorative Right Ring -->
        <div class="absolute -top-16 -right-24 w-80 h-80 rounded-full border-[50px] border-secondary-fixed opacity-70 blur-[12px] pointer-events-none" data-aos="fade-left" data-aos-delay="300"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-2xl mx-auto flex flex-col items-center">
            
            <!-- Floating Badge -->
            <div data-aos="fade-down" data-aos-delay="100" class="inline-flex items-center justify-center gap-2 px-4 py-1.5 bg-secondary-fixed/20 text-[#006c4a] border border-[#006c4a]/10 text-[10px] font-bold tracking-wide rounded-full mb-6 shadow-sm">
                <span class="material-symbols-outlined text-[14px]">local_police</span>
                Sovereign Pay | Enterprise Standard
            </div>
            
            <h2 data-aos="zoom-in" data-aos-delay="200" class="text-4xl md:text-6xl font-headline font-bold text-slate-900 tracking-tighter mb-6 leading-[1.05]">
                {!! $title !!}
            </h2>
            <p data-aos="fade-up" data-aos-delay="300" class="text-base text-slate-500 leading-relaxed mx-auto mb-10 max-w-lg font-medium">
                {!! $subtitle !!}
            </p>
            
            <div data-aos="fade-up" data-aos-delay="400" class="flex flex-col sm:flex-row justify-center gap-4 relative z-10 mb-8 w-full sm:w-auto">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-[#006c4a] text-white text-sm font-semibold rounded-2xl hover:bg-[#005137] hover:shadow-[0_8px_20px_rgba(0,108,74,0.3)] hover:-translate-y-1 transition-all w-full sm:w-auto text-center flex items-center justify-center gap-2">
                    Schedule a demo
                </a>
            </div>

            <p data-aos="fade-in" data-aos-delay="500" class="text-xs font-semibold text-slate-400">
                Unlock the full potential of your treasury with Law 69-21 compliance.
            </p>
        </div>
    </div>
</section>
