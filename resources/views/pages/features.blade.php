<x-public-layout>
    <x-slot name="title">Features | Sovereign Pay</x-slot>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 md:pt-40 md:pb-24 overflow-hidden relative text-center">
        <div class="max-w-4xl mx-auto px-6 relative z-10 flex flex-col items-center" data-aos="zoom-in" data-aos-duration="1000">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-secondary-fixed/30 text-secondary-fixed-variant text-[9px] font-black tracking-[0.2em] uppercase rounded-full mb-8 shadow-sm">
                Enterprise Capabilities
            </div>

            <!-- Heading -->
            <h1 class="text-5xl md:text-[5rem] font-extrabold tracking-tighter text-on-background leading-[1.05] mb-6 font-headline">
                Command Your Financial <br/>
                <span class="text-secondary tracking-tighter">Empire.</span>
            </h1>

            <!-- Subheading -->
            <p class="text-base text-on-surface-variant leading-relaxed font-medium mb-16 max-w-2xl">
                A sophisticated treasury management platform designed for the complex needs of Moroccan holdings and institutional legal entities.
            </p>
        </div>

        <!-- Hero Dark UI Graphic -->
        <div class="max-w-6xl mx-auto px-6" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
            <div class="w-full h-72 md:h-[28rem] bg-[#0b1120] rounded-[2rem] md:rounded-[3rem] shadow-2xl overflow-hidden relative border border-[#006c4a]/20">
                
                <!-- Dashboard Header Metric -->
                <div class="absolute top-6 md:top-8 left-6 md:left-10 z-10">
                    <div class="text-[9px] font-black text-[#85f8c4] uppercase tracking-widest drop-shadow-md mb-1">Corporate Yield</div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white tracking-tighter drop-shadow-sm flex items-end gap-2">
                        1.42 <span class="text-xs md:text-sm font-medium text-slate-400 mb-1.5 tracking-widest uppercase">MAD <span class="opacity-60">(Billions)</span></span>
                    </div>
                </div>

                <!-- Mock Graph Grid -->
                <div class="absolute inset-0 opacity-[0.1]" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 50px 50px;"></div>
                
                <!-- Y-Axis labels -->
                <div class="absolute right-6 top-8 bottom-[4rem] flex flex-col justify-between text-[10px] text-slate-500 font-bold z-10">
                    <span>1.5B</span><span>1.0B</span><span>500M</span>
                </div>
                
                <!-- Glowing Graph Bars -->
                <div class="absolute bottom-0 left-4 md:left-16 flex items-end justify-center md:justify-start gap-4 md:gap-10 w-full md:w-auto h-full pt-32 pb-8 z-10" x-data="{ render: false }" x-intersect="render = true">
                    
                    <div class="flex flex-col items-center gap-2 relative">
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[300ms]" :class="render ? 'opacity-100' : ''">450M</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(0,108,74,0.6)] to-[#006c4a] rounded-t-sm shadow-[0_0_20px_rgba(0,108,74,0.4)] transition-all duration-[1000ms] delay-[100ms] ease-out-expo border-t border-[#85f8c4]/30" :class="render ? 'h-[30%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-slate-400 tracking-wider">2020</span>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[400ms]" :class="render ? 'opacity-100' : ''">900M</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(0,108,74,0.6)] to-[#006c4a] rounded-t-sm shadow-[0_0_20px_rgba(0,108,74,0.6)] transition-all duration-[1000ms] delay-[200ms] ease-out-expo border-t border-[#85f8c4]/30" :class="render ? 'h-[60%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-slate-400 tracking-wider">2021</span>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[500ms]" :class="render ? 'opacity-100' : ''">600M</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(59,130,246,0.5)] to-blue-500/80 rounded-t-sm shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all duration-[1000ms] delay-[300ms] ease-out-expo border-t border-blue-400/30" :class="render ? 'h-[40%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-slate-400 tracking-wider">2022</span>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[600ms]" :class="render ? 'opacity-100' : ''">1.2B</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(0,108,74,0.8)] to-[#85f8c4] rounded-t-sm shadow-[0_0_30px_rgba(0,108,74,0.8)] transition-all duration-[1000ms] delay-[400ms] ease-out-expo border border-[#85f8c4]/50" :class="render ? 'h-[85%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-slate-400 tracking-wider">2023</span>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[700ms]" :class="render ? 'opacity-100' : ''">1.0B</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(59,130,246,0.5)] to-blue-500/80 rounded-t-sm shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all duration-[1000ms] delay-[500ms] ease-out-expo border-t border-blue-400/30" :class="render ? 'h-[70%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-slate-400 tracking-wider">2024</span>
                    </div>

                    <div class="flex flex-col items-center gap-2 relative">
                        <div class="absolute bottom-full mb-6 opacity-0 transition-opacity duration-500 delay-[800ms] whitespace-nowrap z-20" :class="render ? 'opacity-100' : ''">
                            <div class="px-2 py-1 bg-[#85f8c4]/10 border border-[#85f8c4]/30 rounded text-[#85f8c4] text-[9px] font-black backdrop-blur-md shadow-[0_0_15px_rgba(0,108,74,0.3)]">Q3 Yield Target</div>
                        </div>
                        <span class="absolute -top-5 text-[9px] font-bold text-white opacity-0 transition-opacity duration-500 delay-[800ms]" :class="render ? 'opacity-100' : ''">1.4B</span>
                        <div class="w-8 md:w-16 bg-gradient-to-t from-[rgb(0,108,74,0.8)] to-[#85f8c4] rounded-t-sm shadow-[0_0_40px_rgba(0,108,74,1)] transition-all duration-[1000ms] delay-[600ms] ease-out-expo border-t border-[#85f8c4]/80" :class="render ? 'h-[95%]' : 'h-0'"></div>
                        <span class="absolute -bottom-6 text-[8px] font-bold text-[#85f8c4] tracking-wider">2025</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Multi-Entity Governance Section -->
    <section class="py-16 pb-32 bg-surface">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-12">
                <h2 class="text-3xl font-extrabold font-headline tracking-tighter text-on-background mb-4">Multi-Entity Governance</h2>
                <p class="text-sm text-on-surface-variant max-w-md">Centralize control across your entire holding without sacrificing entity independence.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <!-- Left Hierarchical Architecture -->
                <div class="md:col-span-3 bg-surface-container-low rounded-[2.5rem] p-10 md:p-14 shadow-sm border border-outline-variant/5" data-aos="fade-right">
                    <div class="w-12 h-12 bg-primary-container rounded-xl flex items-center justify-center mb-8 shadow-md">
                        <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">account_tree</span>
                    </div>
                    <h3 class="text-2xl font-bold font-headline tracking-tight text-on-background mb-4">Hierarchical Architecture</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed max-w-sm mb-10">
                        Toggle between distinct legal entities with a single secure login. Managed permissions allow for granular control over who sees what.
                    </p>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="px-4 py-2 bg-white rounded-full shadow-sm text-[10px] font-bold text-on-surface flex items-center gap-2 border border-outline-variant/10">
                            <span class="material-symbols-outlined text-secondary text-sm">business</span> Holding SA
                        </div>
                        <div class="px-4 py-2 bg-white rounded-full shadow-sm text-[10px] font-bold text-on-surface flex items-center gap-2 border border-outline-variant/10">
                            <span class="material-symbols-outlined text-tertiary-container text-sm">factory</span> Industrial SARL
                        </div>
                        <div class="px-4 py-2 bg-white rounded-full shadow-sm text-[10px] font-bold text-on-surface flex items-center gap-2 border border-outline-variant/10">
                            <span class="material-symbols-outlined text-blue-500 text-sm">shopping_cart</span> Retail Group
                        </div>
                    </div>
                </div>

                <!-- Right Audit Trails -->
                <div class="md:col-span-2 bg-primary-container text-white rounded-[2.5rem] p-10 md:p-14 relative overflow-hidden shadow-xl shadow-primary-container/20" data-aos="fade-left" data-aos-delay="200">
                    <h3 class="text-2xl font-bold font-headline tracking-tight mb-4 relative z-10">Audit Trails</h3>
                    <p class="text-sm text-primary-fixed-dim leading-relaxed relative z-10">
                        Every action across every entity is logged in a tamper-proof digital vault for compliance.
                    </p>
                    
                    <span class="material-symbols-outlined absolute -bottom-10 -right-10 text-[12rem] text-white/5 pointer-events-none" style="font-variation-settings: 'FILL' 1;">shield</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Never miss a financial pulse Section -->
    <section class="py-12 md:py-[120px]">
        <div class="max-w-6xl mx-auto bg-surface-container-low/50 rounded-[3rem] p-10 md:p-20 relative px-6 mx-6 border border-outline-variant/5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Floating Notifications Component -->
                <div class="space-y-4 pr-0 lg:pr-10">
                    <div class="bg-white p-5 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border border-red-500/20 flex gap-4 transform transition-all hover:scale-105 ml-0 lg:ml-8">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined font-black text-sm">priority_high</span>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-900">Critical Maturity</p>
                            <p class="text-[10px] text-slate-500 mt-1">Cheque #7724 maturity in 24 hours. Relais account liquidity falling.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-5 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border border-yellow-500/20 flex gap-4 transform transition-all hover:scale-105">
                        <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined font-black text-sm">warning</span>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-900">Loi 69-21 Warning</p>
                            <p class="text-[10px] text-slate-500 mt-1">4 Supplier Invoices approaching 60-day legal deadline.</p>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.05)] border border-green-500/20 flex gap-4 transform transition-all hover:scale-105 ml-0 lg:-ml-4">
                        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined font-black text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-900">Scheduled Payment</p>
                            <p class="text-[10px] text-slate-500 mt-1">Salary disbursement scheduled for tomorrow morning.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Text Component -->
                <div data-aos="fade-left">
                    <div class="text-[9px] font-black tracking-widest uppercase text-secondary mb-4">Intelligent Monitoring</div>
                    <h2 class="text-4xl md:text-5xl font-extrabold font-headline text-on-background mb-6 leading-[1.1]">
                        Never miss a financial <br/> <u class="decoration-secondary decoration-4 underline-offset-4 italic">pulse</u>.
                    </h2>
                    <p class="text-sm text-on-surface-variant leading-relaxed max-w-md mb-8">
                        Our smart engine monitors cheque maturity and payment deadlines in real-time. Receive instant notifications via SMS, WhatsApp, or Email when liquidity risks are detected.
                    </p>
                    
                    <div class="flex items-center gap-6 text-[10px] font-black tracking-wide text-on-surface">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-sm">bolt</span> Real-time Execution
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-sm">done_all</span> Zero-Miss Guarantee
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Compliance is Built In -->
    <section class="py-24 bg-surface">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold font-headline italic text-on-background mb-4 tracking-tight">Compliance is built-in.</h2>
                <p class="text-sm text-on-surface-variant max-w-md mx-auto leading-relaxed">
                    Automate your quarterly reporting for Law 69-21. No more manual excel sheets or missed reporting windows.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Loi 69-21 Card -->
                <div class="bg-[#DFE5FA] rounded-[2.5rem] p-10 flex flex-col items-start shadow-sm hover:shadow-md transition-shadow relative overflow-hidden" data-aos="zoom-in-right">
                    <h3 class="text-xl font-bold font-headline text-slate-900 mb-4">Loi 69-21 Compliance</h3>
                    <p class="text-xs text-slate-700 leading-relaxed mb-auto">
                        Auto-generate the required quarterly reports for the tax authorities in the mandated format.
                    </p>
                    
                    <div class="w-full bg-white p-4 rounded-2xl shadow-sm mt-12 border border-blue-100">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">Payment Delays</span>
                            <span class="text-[10px] font-black bg-red-50 text-red-600 px-2 py-0.5 rounded-full">+2.5%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden" x-data="{ load: false }" x-intersect="load = true">
                            <div class="bg-red-500 h-full transition-all duration-[2000ms] ease-out-expo" :class="load ? 'w-[85%]' : 'w-0'"></div>
                        </div>
                        <div class="text-[8px] text-slate-400 mt-3 font-medium">95% annual distribution of Payment Deadlines</div>
                    </div>
                </div>

                <!-- Cash Flow Analytics Component -->
                <div class="md:col-span-2 bg-white rounded-[2.5rem] p-10 shadow-sm border border-outline-variant/10" data-aos="zoom-in-left" data-aos-delay="200">
                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <h3 class="text-xl font-bold font-headline text-slate-900 mb-1">Cash Flow Analytics</h3>
                            <p class="text-xs text-slate-500">Consolidated view across all subsidiaries.</p>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex justify-center items-center text-[10px] font-bold text-slate-600 border border-slate-200">1W</div>
                            <div class="w-6 h-6 rounded-full bg-slate-900 flex justify-center items-center text-[10px] font-bold text-white border border-slate-900">1M</div>
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex justify-center items-center text-[10px] font-bold text-slate-600 border border-slate-200">Y</div>
                        </div>
                    </div>

                    <!-- Chart Visual Mock -->
                    <div class="h-32 mb-8 flex items-end justify-between px-2 gap-2" x-data="{ reveal: false }" x-intersect="reveal = true">
                        <div class="w-full bg-surface-container-high rounded-t-xl transition-all duration-[1000ms] delay-[100ms] ease-out-expo" :class="reveal ? 'h-[30%]' : 'h-0'"></div>
                        <div class="w-full bg-secondary-fixed/50 rounded-t-xl transition-all duration-[1000ms] delay-[200ms] ease-out-expo" :class="reveal ? 'h-[45%]' : 'h-0'"></div>
                        <div class="w-full bg-surface-container rounded-t-xl transition-all duration-[1000ms] delay-[300ms] ease-out-expo" :class="reveal ? 'h-[35%]' : 'h-0'"></div>
                        <div class="w-full bg-secondary-fixed/50 rounded-t-xl transition-all duration-[1000ms] delay-[400ms] ease-out-expo" :class="reveal ? 'h-[60%]' : 'h-0'"></div>
                        <div class="w-full bg-[#cba72f] rounded-t-xl transition-all duration-[1000ms] delay-[500ms] ease-out-expo" :class="reveal ? 'h-[50%]' : 'h-0'"></div>
                        <div class="w-full bg-secondary-fixed/70 rounded-t-xl transition-all duration-[1000ms] delay-[600ms] ease-out-expo" :class="reveal ? 'h-[75%]' : 'h-0'"></div>
                        <div class="w-full bg-primary-container rounded-t-xl transition-all duration-[1000ms] delay-[700ms] ease-out-expo" :class="reveal ? 'h-[90%]' : 'h-0'"></div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-slate-100 pt-6">
                        <div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Inflow</div>
                            <div class="text-xl font-bold font-headline text-slate-900 tracking-tighter">4.2M <span class="text-[10px] font-black uppercase text-slate-400 ml-0.5 tracking-widest">MAD</span></div>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Liquidity</div>
                            <div class="text-xl font-bold font-headline text-slate-900 tracking-tighter">840K <span class="text-[10px] font-black uppercase text-slate-400 ml-0.5 tracking-widest">MAD</span></div>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Net Revenue</div>
                            <div class="text-xl font-bold font-headline text-secondary tracking-tighter">3.36M <span class="text-[10px] font-black uppercase text-slate-400 ml-0.5 tracking-widest">MAD</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-cta-section 
        title="Ready to secure your treasury?" 
        subtitle="Join Morocco's most innovative legal entities using Sovereign Pay for their high-value financial operations." 
    />

</x-public-layout>
