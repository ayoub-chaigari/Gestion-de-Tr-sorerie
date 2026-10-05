<x-public-layout>
    <x-slot name="title">Solutions | Sovereign Pay</x-slot>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-24 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Left Content -->
            <div class="max-w-xl" data-aos="fade-right" data-aos-duration="1000">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-secondary-fixed/50 text-secondary-fixed-variant text-[9px] font-black tracking-widest uppercase rounded-full mb-8 shadow-sm">
                    <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">security</span>
                    Institutional Solutions
                </div>

                <h1 class="text-5xl md:text-[5.5rem] font-extrabold tracking-tighter text-on-background leading-[1.05] mb-6 font-headline">
                    Enterprise-Grade <br/>
                    <span class="text-secondary tracking-tighter">Financial</span> <br/>
                    Solutions.
                </h1>

                <p class="text-sm md:text-base text-on-surface-variant leading-relaxed font-medium mb-10 max-w-sm">
                    Secure your treasury with architectural precision. Our suite automates complex regulatory compliance while providing unfettered visibility into your capital ecosystem.
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 mb-12">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary-container text-white text-xs font-bold rounded-full hover:shadow-xl hover:bg-slate-900 transition-all flex items-center justify-center gap-2">
                        Initialize Protocol 
                    </a>
                    <a href="{{ route('contact') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-on-surface shadow-sm border border-outline-variant/10 text-xs font-bold rounded-full hover:bg-surface-variant transition-all text-center">
                        View Whitepaper
                    </a>
                </div>
            </div>

            <!-- Right Graphic -->
            <div class="relative lg:-mr-20" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="bg-primary-container p-2 rounded-[2rem] shadow-2xl relative">
                    <div class="w-full aspect-[4/5] bg-[#0b1120] rounded-[1.5rem] overflow-hidden relative border border-[#006c4a]/20 flex flex-col justify-end p-6">
                        
                        <!-- Header & Metric -->
                        <div class="absolute top-6 left-6 z-10">
                            <h3 class="text-[9px] font-black tracking-widest text-[#85f8c4] uppercase mb-1 drop-shadow-md">Clearing Volume</h3>
                            <div class="text-3xl font-extrabold text-white tracking-tighter shadow-sm flex items-end gap-1">
                                48.2 <span class="text-xs font-bold text-slate-400 mb-1 tracking-widest">MAD <span class="opacity-60">(M)</span></span>
                            </div>
                        </div>

                        <!-- Abstract Dashboard Grid -->
                        <div class="absolute inset-0 opacity-[0.1]" style="background-image: linear-gradient(0deg, transparent 24%, rgba(255, 255, 255, .3) 25%, rgba(255, 255, 255, .3) 26%, transparent 27%, transparent 74%, rgba(255, 255, 255, .3) 75%, rgba(255, 255, 255, .3) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(255, 255, 255, .3) 25%, rgba(255, 255, 255, .3) 26%, transparent 27%, transparent 74%, rgba(255, 255, 255, .3) 75%, rgba(255, 255, 255, .3) 76%, transparent 77%, transparent); background-size: 40px 40px; border-radius: 1.5rem;"></div>
                        
                        <!-- Y-Axis Labels -->
                        <div class="absolute left-4 bottom-[4.5rem] flex flex-col justify-between h-52 text-[8px] font-bold text-slate-500 z-10">
                            <div>50M</div>
                            <div>25M</div>
                        </div>

                        <!-- Data Bars with Floating Labels -->
                        <div class="flex gap-4 items-end opacity-90 z-10 ml-8 relative border-b border-white/10 pb-2 mb-2" x-data="{ up: false }" x-intersect="up = true">
                            
                            <!-- Bar 1 -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[300ms]" :class="up ? 'opacity-100' : ''">22M</span>
                                <div class="w-5 bg-blue-600/30 rounded-t transition-all duration-[1200ms] delay-[100ms] ease-out border border-blue-500/20" :class="up ? 'h-24' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-slate-400">JUL</span>
                            </div>

                            <!-- Bar 2 -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[400ms]" :class="up ? 'opacity-100' : ''">34M</span>
                                <div class="w-5 bg-blue-600/30 rounded-t transition-all duration-[1200ms] delay-[200ms] ease-out border border-blue-500/20" :class="up ? 'h-36' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-slate-400">AUG</span>
                            </div>

                            <!-- Bar 3 (Peak 1) -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <div class="absolute bottom-full mb-6 opacity-0 transition-opacity duration-500 delay-[500ms] w-max whitespace-nowrap -ml-2 z-20" :class="up ? 'opacity-100' : ''">
                                    <div class="px-1.5 py-1 bg-[#85f8c4]/10 border border-[#85f8c4]/30 rounded text-[#85f8c4] text-[8px] font-black backdrop-blur-md shadow-[0_0_15px_rgba(0,108,74,0.3)]">+18% Surge</div>
                                </div>
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[500ms]" :class="up ? 'opacity-100' : ''">48M</span>
                                <div class="w-5 bg-gradient-to-t from-[#006c4a] to-[#85f8c4] rounded-t shadow-[0_0_20px_rgba(0,108,74,0.6)] transition-all duration-[1200ms] delay-[300ms] ease-out border border-[#85f8c4]/50" :class="up ? 'h-52' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-[#85f8c4]">SEP</span>
                            </div>

                            <!-- Bar 4 -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[600ms]" :class="up ? 'opacity-100' : ''">28M</span>
                                <div class="w-5 bg-blue-600/30 rounded-t transition-all duration-[1200ms] delay-[400ms] ease-out border border-blue-500/20" :class="up ? 'h-32' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-slate-400">OCT</span>
                            </div>

                            <!-- Bar 5 -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[700ms]" :class="up ? 'opacity-100' : ''">14M</span>
                                <div class="w-5 bg-blue-600/30 rounded-t transition-all duration-[1200ms] delay-[500ms] ease-out border border-blue-500/20" :class="up ? 'h-16' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-slate-400">NOV</span>
                            </div>

                            <!-- Bar 6 (Peak 2) -->
                            <div class="flex flex-col items-center gap-2 relative">
                                <span class="absolute -top-4 text-[8px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[800ms]" :class="up ? 'opacity-100' : ''">42M</span>
                                <div class="w-5 bg-[#006c4a] rounded-t shadow-[0_0_15px_rgba(0,108,74,0.5)] transition-all duration-[1200ms] delay-[600ms] ease-out border border-[#006c4a]/50" :class="up ? 'h-44' : 'h-0'"></div>
                                <span class="absolute -bottom-6 text-[7px] font-bold text-[#85f8c4]">DEC</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Floating overlay card -->
                <div class="absolute -bottom-8 -left-12 bg-white rounded-full p-3 pr-8 shadow-2xl border border-outline-variant/10 flex items-center gap-4 animate-bounce" style="animation-duration: 4s;">
                    <div class="w-10 h-10 bg-secondary-fixed/50 text-secondary-fixed-variant rounded-full flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">show_chart</span>
                    </div>
                    <div>
                        <div class="text-[8px] font-black uppercase text-slate-400 tracking-widest leading-tight">Liquid Assets</div>
                        <div class="text-[13px] font-black text-slate-900 tracking-tighter">MAD 42.8M</div>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- Ambient Decor -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-surface-container-high/50 transform -skew-x-[20deg] origin-bottom-right -z-10"></div>
    </section>

    <!-- The Digital Vault Ecosystem Set -->
    <section class="py-24 bg-surface-container-low/50 border-t border-outline-variant/10 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold font-headline text-on-background mb-4 tracking-tight">The Digital Vault Ecosystem</h2>
                <p class="text-sm text-on-surface-variant max-w-md mx-auto leading-relaxed">
                    Engineered specifically for the Moroccan financial landscape, bridging local banking traditions with global fintech standards.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Treasury Management -->
                <div class="bg-white rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-12 h-12 bg-primary-container text-secondary flex items-center justify-center rounded-2xl mb-8 shadow-md">
                        <span class="material-symbols-outlined text-lg">stacked_line_chart</span>
                    </div>
                    <h3 class="text-lg font-bold font-headline text-slate-900 mb-4 tracking-tight">Treasury Management</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-8 h-20">
                        Unify disparate bank accounts into a single architectural pane. Real-time visibility and predictive forecasting for Moroccan Dirham volatility.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Multi-Bank Aggregation</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Cash Flow AI Projection</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Liquidity Optimization</span>
                        </div>
                    </div>
                </div>

                <!-- Cheque Tracking -->
                <div class="bg-white rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-12 h-12 bg-primary-container text-tertiary-container flex items-center justify-center rounded-2xl mb-8 shadow-md">
                        <span class="material-symbols-outlined text-lg">shield_person</span>
                    </div>
                    <h3 class="text-lg font-bold font-headline text-slate-900 mb-4 tracking-tight">Cheque Tracking</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-8 h-20">
                        Digitalize the paper trail. Our automated pipeline monitors maturity dates and alerts treasury teams before cron-job executions.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Maturity Pipeline Alerts</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Digital Document Vault</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Fraud Pattern Detection</span>
                        </div>
                    </div>
                </div>

                <!-- Law 69-21 Compliance -->
                <div class="bg-white rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-outline-variant/10 hover:shadow-xl hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-primary-container text-secondary flex items-center justify-center rounded-2xl mb-8 shadow-md">
                        <span class="material-symbols-outlined text-lg">gavel</span>
                    </div>
                    <h3 class="text-lg font-bold font-headline text-slate-900 mb-4 tracking-tight">Law 69-21 Compliance</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-8 h-20">
                        A built-in regulatory engine that automates reporting for Bank Al-Maghrib. Eliminate the risk of late payment penalties.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Automated BAM Reporting</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Late Payment Mitigation</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full bg-secondary-fixed/50 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[10px] text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
                            </div>
                            <span class="text-[11px] font-medium text-slate-700">Audit-Ready Infrastructure</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tailored for Moroccan Economy -->
    <section class="py-24 bg-surface relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Details -->
                <div class="pr-0 md:pr-10" data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-extrabold font-headline leading-tight tracking-tighter text-on-background mb-16">
                        Tailored for the <br/>
                        <span class="text-tertiary-container">Moroccan Economy.</span>
                    </h2>

                    <div class="space-y-12">
                        <div class="flex gap-6">
                            <div class="text-4xl font-black text-slate-200 tracking-tighter">01</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 mt-2">Moroccan Holdings</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Consolidated financial governance for diverse portfolios across Casablanca and Rabat.</p>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <div class="text-4xl font-black text-slate-200 tracking-tighter">02</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 mt-2">Industrial Entities</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Streamlined supply chain payments and heavy asset financing management.</p>
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <div class="text-4xl font-black text-slate-200 tracking-tighter">03</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2 mt-2">Retail Groups</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">High-volume transaction tracking and automated reconciliation for regional branches.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Context Grid -->
                <div class="grid grid-cols-2 gap-4" data-aos="fade-left" data-aos-delay="200">
                    <!-- Images represent structural architectural concepts using styling rather than external 404 links -->
                    <div class="w-full aspect-square rounded-[2.5rem] bg-gradient-to-br from-tertiary-fixed to-tertiary-container shadow-inner overflow-hidden relative group">
                        <div class="absolute inset-0 bg-black/10 mix-blend-multiply transition-all group-hover:bg-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="text-white font-headline font-bold text-sm tracking-widest">HOLDINGS</div>
                        </div>
                    </div>
                    <div class="w-full aspect-square rounded-[2.5rem] bg-gradient-to-br from-primary-container to-slate-800 shadow-inner overflow-hidden relative group transform translate-y-6">
                        <div class="absolute inset-0 bg-black/10 mix-blend-multiply transition-all group-hover:bg-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="text-white font-headline font-bold text-sm tracking-widest">GOVERNANCE</div>
                        </div>
                    </div>
                    <div class="w-full aspect-square rounded-[2.5rem] bg-gradient-to-br from-blue-500 to-[#131b2e] shadow-inner overflow-hidden relative group transform -translate-y-6">
                        <div class="absolute inset-0 bg-black/10 mix-blend-multiply transition-all group-hover:bg-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="text-white font-headline font-bold text-sm tracking-widest">INDUSTRIES</div>
                        </div>
                    </div>
                    <div class="w-full aspect-square rounded-[2.5rem] bg-gradient-to-br from-slate-200 to-slate-400 shadow-inner overflow-hidden relative group">
                        <div class="absolute inset-0 bg-black/10 mix-blend-multiply transition-all group-hover:bg-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="text-slate-800 font-headline font-bold text-sm tracking-widest">RETAIL SCALE</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <x-cta-section 
        title="Secure Your Treasury Today." 
        subtitle="Join the elite circle of Moroccan institutions redefining financial excellence with Sovereign Pay." 
    />

</x-public-layout>
