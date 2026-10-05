<x-public-layout>
    <x-slot name="title">Sovereign Pay | The Digital Gold Standard</x-slot>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-24 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Left -->
            <div class="max-w-xl" data-aos="fade-right" data-aos-duration="1000">
                <!-- Badge -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-secondary-fixed/50 text-secondary-fixed-variant text-[9px] font-black tracking-widest uppercase rounded-full mb-8 shadow-sm">
                    <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">shield</span>
                    Secure Financial Governance
                </div>

                <!-- Heading -->
                <h1 class="text-5xl md:text-[5rem] font-extrabold tracking-tighter text-on-background leading-[1.05] mb-6 font-headline">
                    Master Your <br/> Treasury. <br/>
                    <span class="text-secondary tracking-tighter">Tahakoum Kamel.</span>
                </h1>

                <!-- Subheading -->
                <p class="text-base text-on-surface-variant leading-relaxed font-medium mb-10 max-w-md">
                    Automate Law 69-21 compliance and eliminate payment delays. The ultimate "Digital Vault" for Moroccan enterprises managing complex cash flows and supplier relations.
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mb-12">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-on-primary text-xs font-bold rounded-full hover:shadow-xl hover:scale-[1.02] transition-all flex items-center justify-center gap-2 pr-6">
                        Book Demo 
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                    <a href="{{ route('contact') }}" class="w-full sm:w-auto px-8 py-4 border border-outline-variant/60 text-on-surface text-xs font-bold rounded-full hover:bg-surface-variant transition-all text-center">
                        View Compliance Guide
                    </a>
                </div>

                <!-- Trust Avatars -->
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <div class="w-8 h-8 rounded-full bg-surface-container-high border-2 border-surface shadow-sm"></div>
                        <div class="w-8 h-8 rounded-full bg-secondary-container border-2 border-surface shadow-sm"></div>
                        <div class="w-8 h-8 rounded-full bg-primary-container border-2 border-surface shadow-sm"></div>
                    </div>
                    <p class="text-[10px] text-on-surface-variant font-medium">Trusted by 500+ Moroccan CFOs</p>
                </div>
            </div>

            <!-- Hero Right (Mock Dashboard Graphic) -->
            <div class="relative lg:-mr-32 perspective-1000" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="bg-primary-container p-6 rounded-[2rem] shadow-2xl shadow-primary/20 border border-outline-variant/10 transform rotate-y-[-5deg] rotate-x-[2deg] transition-transform hover:rotate-0 duration-700">
                    <!-- Fake browser chrome -->
                    <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/10 pb-4">
                        <div class="text-xs font-black tracking-widest text-on-primary font-headline uppercase opacity-80">Sovereign Pay</div>
                        <div class="ml-auto flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-outline-variant/20"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-outline-variant/20"></div>
                        </div>
                    </div>
                    <!-- Fake Dashboard Internals -->
                    <div class="space-y-4">
                        <!-- Stat Row -->
                        <div class="grid grid-cols-4 gap-3">
                            <div class="h-16 bg-white/5 rounded-xl border border-white/5 p-3 flex flex-col justify-center">
                                <div class="text-[8px] font-black tracking-widest text-[#85f8c4] uppercase opacity-80 mb-1">Total Processed</div>
                                <div class="text-xs font-bold text-white tracking-tighter">4.2M <span class="text-[8px] font-medium text-slate-400">MAD</span></div>
                            </div>
                            <div class="col-span-3 h-16 bg-white/5 rounded-xl border border-white/5 p-3 flex flex-col justify-center" x-data="{ fill: false }" x-intersect="fill = true">
                                <div class="flex justify-between items-end mb-1.5">
                                    <div class="text-[8px] font-black tracking-widest text-white uppercase opacity-80">Law 69-21 Adherence</div>
                                    <div class="text-[10px] font-bold text-[#85f8c4]">98%</div>
                                </div>
                                <div class="h-1.5 w-full bg-white/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-[#006c4a] to-[#85f8c4] transition-all duration-[1500ms] ease-out-expo" :class="fill ? 'w-[98%]' : 'w-0'"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Large Graph Area -->
                        <div class="h-48 bg-white/5 rounded-xl border border-white/5 p-4 relative overflow-hidden flex flex-col">
                            
                            <!-- Graph Header -->
                            <div class="flex justify-between items-center mb-auto relative z-10">
                                <div>
                                    <div class="text-[9px] font-black tracking-widest text-slate-400 uppercase">Liquidity Forecast</div>
                                    <div class="text-lg font-bold text-white tracking-tighter mt-1">+1.8M <span class="text-[9px] font-medium text-[#85f8c4]">Expected</span></div>
                                </div>
                                <div class="px-2 py-1 bg-white/10 rounded-md text-[8px] text-white font-bold border border-white/10">30 DAYS</div>
                            </div>

                            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-secondary/50 to-transparent z-0"></div>
                            
                            <!-- SVG decorative wave -->
                            <svg class="absolute bottom-0 w-full h-full text-secondary opacity-60 z-0" preserveAspectRatio="none" viewBox="0 0 100 100">
                                <path d="M0,100 C20,80 40,90 60,60 C80,30 100,50 100,50 L100,100 Z" fill="currentColor"/>
                            </svg>
                            
                            <!-- Floating Data Points on Graph -->
                            <div class="absolute bottom-12 left-[30%] -translate-x-1/2 flex flex-col items-center z-10" data-aos="zoom-in" data-aos-delay="600">
                                <div class="text-[8px] font-bold text-white bg-black/50 px-1.5 py-0.5 rounded backdrop-blur-md mb-1 border border-white/10">+400K</div>
                                <div class="w-1.5 h-1.5 bg-[#85f8c4] rounded-full shadow-[0_0_8px_#85f8c4]"></div>
                            </div>
                            <div class="absolute bottom-16 left-[65%] -translate-x-1/2 flex flex-col items-center z-10" data-aos="zoom-in" data-aos-delay="800">
                                <div class="text-[8px] font-bold text-white bg-black/50 px-1.5 py-0.5 rounded backdrop-blur-md mb-1 border border-white/10">+1.2M</div>
                                <div class="w-1.5 h-1.5 bg-[#85f8c4] rounded-full shadow-[0_0_8px_#85f8c4]"></div>
                            </div>
                        </div>
                        <!-- Bottom row -->
                        <div class="bg-white rounded-xl p-4 flex items-center justify-between">
                            <div class="text-[10px] font-bold text-primary-container tracking-widest uppercase">Compliance Status</div>
                            <div class="px-3 py-1 bg-secondary-container/30 text-secondary-fixed-variant text-[9px] font-bold rounded-full uppercase">Law 69-21 Ready</div>
                        </div>
                    </div>
                </div>
                <!-- Decorative Blur -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-secondary/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
            </div>

        </div>
        <!-- Very light gradient for total body -->
        <div class="absolute inset-0 bg-gradient-to-b from-surface-container-high/30 to-surface pointer-events-none -z-20"></div>
    </section>

    <!-- Logo Cloud Section -->
    <section class="py-12 border-y border-outline-variant/10 bg-surface-container-low/50">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-[10px] font-black tracking-[0.2em] uppercase text-on-surface-variant mb-8">Empowering National Leaders</p>
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60 grayscale contrast-200">
                <div class="text-xl font-black font-headline tracking-tighter">CDG<span class="text-[8px] align-top">HOLDING</span></div>
                <div class="text-xl font-bold font-headline tracking-tight">AttijariWafa</div>
                <div class="text-2xl font-black font-headline tracking-widest italic">OCP</div>
                <div class="text-xl font-black font-headline tracking-tighter">BCP</div>
                <div class="text-xl font-bold font-headline tracking-tight">Royal Air Maroc</div>
            </div>
        </div>
    </section>

    <!-- Stop Chasing Paper Section -->
    <section class="py-24 bg-surface relative">
        <div class="max-w-4xl mx-auto px-6 text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-extrabold font-headline text-on-background mb-4">Stop Chasing Paper.</h2>
            <p class="text-sm text-on-surface-variant leading-relaxed max-w-xl mx-auto">
                The manual tracking of cheques and LCNS is a ghost in your balance sheet. Lose the spreadsheets, gain total control.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1 -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-1 transition-all" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-red-500">receipt_long</span>
                    </div>
                    <h3 class="text-sm font-bold text-on-surface mb-3">Manual Cheque Tracking</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        End the "where is this cheque?" mystery. Eliminate errors in physical ledger entries and lost payment vouchers.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-1 transition-all" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-secondary-fixed/50 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-secondary">gavel</span>
                    </div>
                    <h3 class="text-sm font-bold text-on-surface mb-3">Regulatory Penalties</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Law 69-21 mandates strict payment terms. Sovereign Pay automates the tracking to ensure you never miss a deadline or face heavy BAM fines.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-[2rem] p-10 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-1 transition-all" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-tertiary-fixed/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary">autorenew</span>
                    </div>
                    <h3 class="text-sm font-bold text-on-surface mb-3">Bank Discrepancies</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Stop spending hours matching bank statements to internal records. Let our AI do the reconciliation in real-time.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Dark Digital Vault Section -->
    <section class="py-12 md:py-24 px-6 relative">
        <div class="max-w-7xl mx-auto bg-primary-container rounded-[3rem] p-10 md:p-20 overflow-hidden relative shadow-2xl">
            <!-- Decorative Background waves -->
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <svg width="100%" height="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 150 C 300 0, 700 300, 1500 150 L1500 300 L0 300 Z" fill="url(#grad1)"/>
                    <defs>
                        <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#006c4a" stop-opacity="0.5"/>
                            <stop offset="100%" stop-color="#006c4a" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10 items-center">
                <div class="pr-0 md:pr-12" data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-headline font-extrabold text-on-primary mb-12 leading-tight">
                        Your Digital Vault for Sovereign Wealth.
                    </h2>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-secondary/50">
                                <span class="material-symbols-outlined text-white text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Instant Bank Integration</h4>
                                <p class="text-xs text-primary-fixed-dim leading-relaxed">Connect directly with CIH, BMCE, and Attijariwafa for instant transaction relaying.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-secondary/50">
                                <span class="material-symbols-outlined text-white text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Automated Supplier Portal</h4>
                                <p class="text-xs text-primary-fixed-dim leading-relaxed">Give your suppliers visibility without them calling your finance team every hour.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-secondary/50">
                                <span class="material-symbols-outlined text-white text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">AI Cashflow Forecasting</h4>
                                <p class="text-xs text-primary-fixed-dim leading-relaxed">Predict liquidity gaps before they happen with Morocco market-specific models.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dark Dashboard Mockup -->
                <div class="relative w-full aspect-square md:aspect-[4/3] bg-black/40 border border-white/5 rounded-3xl p-6 backdrop-blur-md shadow-2xl flex flex-col pointer-events-none">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                        <div class="text-[9px] font-black text-white uppercase tracking-widest opacity-60 font-headline">AI Yield Forecast</div>
                        <div class="flex items-center gap-1.5 px-2 py-0.5 bg-secondary/20 rounded border border-secondary/30">
                            <div class="w-1.5 h-1.5 bg-secondary rounded-full animate-pulse"></div>
                            <span class="text-[7px] text-secondary font-bold tracking-widest uppercase">Live Model</span>
                        </div>
                    </div>
                    
                    <!-- Mock chart area -->
                    <div class="flex-grow bg-gradient-to-t from-secondary/20 to-transparent rounded-xl border border-secondary/20 relative overflow-hidden flex flex-col justify-end pt-4">
                        <!-- Chart Header Overlay -->
                        <div class="absolute top-4 left-4 z-10">
                            <div class="text-[8px] font-black tracking-widest text-slate-400 uppercase">Projected Portfolio Value</div>
                            <div class="text-xl font-bold text-white tracking-tighter shadow-sm">14.6M <span class="text-[10px] text-slate-400 font-medium">MAD</span></div>
                        </div>

                        <!-- Graph path -->
                        <svg class="w-full text-secondary drop-shadow-[0_0_15px_rgba(0,108,74,0.5)] z-0 absolute bottom-0" viewBox="0 0 100 40" preserveAspectRatio="none">
                            <path d="M0,40 L0,20 Q10,15 20,25 T40,15 T60,25 T80,10 L100,5 L100,40 Z" fill="currentColor" fill-opacity="0.3" stroke="currentColor" stroke-width="0.5"/>
                        </svg>

                        <!-- Floating Data Points -->
                        <div class="absolute top-[40%] left-[30%] -translate-x-1/2 flex flex-col items-center z-10 opacity-0 animate-[fade-in_0.5s_ease-out_1s_forwards]">
                            <div class="text-[8px] font-bold text-white bg-black/50 px-1 py-0.5 rounded border border-white/10 mb-1">+2.4M</div>
                            <div class="w-2 h-2 bg-[#85f8c4] rounded-full shadow-[0_0_12px_#85f8c4]"></div>
                        </div>
                        <div class="absolute top-[20%] left-[80%] -translate-x-1/2 flex flex-col items-center z-10 opacity-0 animate-[fade-in_0.5s_ease-out_1.5s_forwards]">
                            <div class="text-[8px] font-bold text-white bg-black/50 px-1 py-0.5 rounded border border-white/10 mb-1">+5.1M</div>
                            <div class="w-2 h-2 bg-[#85f8c4] rounded-full shadow-[0_0_12px_#85f8c4]"></div>
                        </div>
                    </div>
                    
                    <!-- Mock Data Bars (Quarterly) -->
                    <div class="grid grid-cols-4 gap-2 mt-4" x-data="{ showData: false }" x-intersect="showData = true">
                        <!-- Q1 -->
                        <div class="h-12 bg-white/5 rounded flex flex-col items-center justify-end pb-1 relative overflow-hidden">
                            <div class="absolute top-1 text-[7px] font-bold text-[#85f8c4] opacity-0 transition-opacity duration-500 delay-300" :class="showData ? 'opacity-100' : ''">Q1</div>
                            <div class="w-6 bg-secondary/50 rounded-t-sm transition-all duration-[1000ms] delay-[100ms] ease-out-expo" :class="showData ? 'h-[40%]' : 'h-0'"></div>
                        </div>
                        <!-- Q2 -->
                        <div class="h-12 bg-white/5 rounded flex flex-col items-center justify-end pb-1 relative overflow-hidden">
                            <div class="absolute top-1 text-[7px] font-bold text-[#85f8c4] opacity-0 transition-opacity duration-500 delay-400" :class="showData ? 'opacity-100' : ''">Q2</div>
                            <div class="w-6 bg-secondary/50 rounded-t-sm transition-all duration-[1000ms] delay-[200ms] ease-out-expo" :class="showData ? 'h-[60%]' : 'h-0'"></div>
                        </div>
                        <!-- Q3 -->
                        <div class="h-12 bg-white/5 rounded flex flex-col items-center justify-end pb-1 relative overflow-hidden">
                            <div class="absolute top-1 text-[7px] font-bold text-[#85f8c4] opacity-0 transition-opacity duration-500 delay-500" :class="showData ? 'opacity-100' : ''">Q3</div>
                            <div class="w-6 bg-secondary/60 rounded-t-sm transition-all duration-[1000ms] delay-[300ms] ease-out-expo" :class="showData ? 'h-[85%]' : 'h-0'"></div>
                        </div>
                        <!-- Q4 -->
                        <div class="h-12 bg-secondary/10 rounded flex flex-col items-center justify-end pb-1 relative overflow-hidden border border-secondary/30 shadow-[inset_0_0_15px_rgba(0,108,74,0.2)]">
                            <div class="absolute top-1 text-[7px] font-bold text-white opacity-0 transition-opacity duration-500 delay-600" :class="showData ? 'opacity-100' : ''">Q4</div>
                            <div class="w-6 bg-secondary rounded-t-sm transition-all duration-[1000ms] delay-[400ms] ease-out-expo shadow-[0_0_10px_#006c4a]" :class="showData ? 'h-[100%]' : 'h-0'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-cta-section />

</x-public-layout>
