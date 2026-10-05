<x-public-layout>
    <x-slot name="title">Pricing | Sovereign Pay Architecture</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 overflow-hidden flex flex-col items-center justify-center text-center">
        <div class="max-w-4xl mx-auto px-6 relative z-10 flex flex-col items-center" data-aos="zoom-in" data-aos-duration="1000">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-secondary-container/20 text-secondary-fixed-variant text-[10px] font-bold tracking-widest uppercase rounded-full mb-8">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">security</span>
                Institutional Grade Security
            </div>

            <!-- Heading -->
            <h1 class="text-5xl md:text-[5.5rem] font-extrabold tracking-tighter text-on-background leading-[1.05] mb-8">
                Transparent <span class="text-secondary">Value</span> for Every Scale.
            </h1>

            <!-- Subheading -->
            <p class="text-lg md:text-xl text-on-surface-variant max-w-2xl mx-auto leading-relaxed font-medium">
                From emerging SMEs to complex institutional structures, Sovereign Pay provides the regulatory automation and liquidity required for the modern Moroccan economy.
            </p>
        </div>
        
        <!-- Decorative subtle background -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-surface-container-high/40 via-surface to-surface -z-10"></div>
    </section>

    <!-- Pricing Cards Grid -->
    <section class="pb-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-stretch justify-center gap-6 lg:gap-8">
                
                <!-- Starter Tier -->
                <div class="w-full lg:w-[320px] bg-surface-container-low rounded-[2rem] p-10 shadow-sm border border-outline-variant/10 flex flex-col transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 hover:border-secondary/30 group cursor-pointer" data-aos="fade-up" data-aos-delay="0">
                    <div class="mb-10">
                        <div class="text-2xl font-bold font-headline text-on-background mb-3">Starter</div>
                        <p class="text-xs text-on-surface-variant leading-relaxed min-h-[40px]">For SMEs and high-growth startups seeking reliability.</p>
                        
                        <div class="mt-8 flex items-baseline gap-2">
                            <span class="text-5xl font-black text-on-background tracking-tighter">Free</span>
                        </div>
                        <div class="text-[10px] uppercase tracking-widest text-on-surface-variant mt-2 font-bold">/ for first 1M MAD volume</div>
                    </div>
                    
                    <div class="space-y-4 flex-grow mb-10">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Standard Payouts (T+2)</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Basic Merchant Portal</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Standard API Access</span>
                        </div>
                    </div>
                    
                    <button class="w-full py-4 text-xs font-bold border border-outline-variant/30 text-on-surface rounded-full hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-secondary mt-auto">Start for Free</button>
                </div>

                <!-- Pro Tier (Highlighted) -->
                <div class="w-full lg:w-[360px] bg-primary-container text-on-primary rounded-[2.5rem] p-10 shadow-2xl relative flex flex-col transform lg:-translate-y-4 shadow-primary/20 transition-all duration-500 hover:shadow-primary/40 hover:-translate-y-6 hover:scale-[1.02] group cursor-pointer z-10" data-aos="fade-up" data-aos-delay="150" data-aos-duration="1000">
                    <div class="absolute top-6 right-6 px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed text-[9px] font-black uppercase tracking-[0.2em] rounded-full">Most Popular</div>
                    
                    <div class="mb-10 pt-2">
                        <div class="text-2xl font-bold font-headline text-on-primary mb-3">Pro</div>
                        <p class="text-xs text-primary-fixed-dim leading-relaxed min-h-[40px]">Automated compliance for Law 69-21 standards.</p>
                        
                        <div class="mt-8 flex items-baseline gap-2">
                            <span class="text-5xl font-black text-on-primary tracking-tighter">0.9%</span>
                        </div>
                        <div class="text-[10px] uppercase tracking-widest text-primary-fixed-dim mt-2 font-bold">+ 2 MAD per tx</div>
                    </div>
                    
                    <div class="space-y-4 flex-grow mb-10">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary-fixed text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-primary font-medium">Law 69-21 Automated Reporting</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary-fixed text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-primary font-medium">Next-Day Settlements (T+1)</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary-fixed text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-primary font-medium">Advanced Fraud Protection</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary-fixed text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-primary font-medium">Dedicated Relationship Manager</span>
                        </div>
                    </div>
                    
                    <button class="w-full py-4 text-xs font-bold bg-tertiary-container text-on-tertiary-container rounded-full hover:bg-tertiary-fixed shadow-xl transition-all focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-container focus:ring-tertiary-container mt-auto">Upgrade to Pro</button>
                    
                    <!-- Decorative Glow -->
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-tertiary-container/10 rounded-full blur-[60px] pointer-events-none"></div>
                </div>

                <!-- Enterprise Tier -->
                <div class="w-full lg:w-[320px] bg-surface-container-low rounded-[2rem] p-10 shadow-sm border border-outline-variant/10 flex flex-col transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 hover:border-secondary/30 group cursor-pointer" data-aos="fade-up" data-aos-delay="300">
                    <div class="mb-10">
                        <div class="text-2xl font-bold font-headline text-on-background mb-3">Enterprise</div>
                        <p class="text-xs text-on-surface-variant leading-relaxed min-h-[40px]">Bespoke infrastructure for large-scale commerce.</p>
                        
                        <div class="mt-8 flex items-baseline gap-2">
                            <span class="text-5xl font-black text-on-background tracking-tighter">Custom</span>
                        </div>
                        <div class="text-[10px] uppercase tracking-widest transparent mt-2 font-bold select-none">&nbsp;</div>
                    </div>
                    
                    <div class="space-y-4 flex-grow mb-10">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Volume-Based Discounting</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Custom CRM/ERP Integrations</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">Multi-Currency Settlement</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-base mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs text-on-surface-variant font-medium">White-label Merchant SDKs</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('contact') }}" class="w-full flex items-center justify-center py-4 text-xs font-bold border border-outline-variant/30 text-on-surface rounded-full hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-secondary mt-auto">Contact Sales</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Compare Features Table -->
    <section class="py-24 bg-surface" data-aos="fade-up" data-aos-duration="1000">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-headline font-bold text-center text-on-surface mb-4">Compare Features</h2>
            <div class="w-12 h-1 bg-secondary mx-auto rounded-full mb-16"></div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant/20">
                            <th class="py-6 px-4 text-xs font-bold text-on-surface-variant uppercase tracking-widest w-2/5">Core Capabilities</th>
                            <th class="py-6 px-4 text-xs font-bold text-on-surface uppercase tracking-widest text-center w-1/5">Starter</th>
                            <th class="py-6 px-4 text-xs font-bold text-on-surface uppercase tracking-widest text-center w-1/5">Pro</th>
                            <th class="py-6 px-4 text-xs font-bold text-on-surface uppercase tracking-widest text-center w-1/5">Enterprise</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-6 px-4 text-on-surface font-medium">Law 69-21 Compliance Engine</td>
                            <td class="py-6 px-4 text-center text-outline">&mdash;</td>
                            <td class="py-6 px-4 text-center"><span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span></td>
                            <td class="py-6 px-4 text-center"><span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span></td>
                        </tr>
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-6 px-4 text-on-surface font-medium">Instant Settlement Access</td>
                            <td class="py-6 px-4 text-center text-outline">&mdash;</td>
                            <td class="py-6 px-4 text-center text-on-surface font-medium">Add-on</td>
                            <td class="py-6 px-4 text-center"><span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span></td>
                        </tr>
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-6 px-4 text-on-surface font-medium">Priority Support</td>
                            <td class="py-6 px-4 text-center text-on-surface-variant">Standard</td>
                            <td class="py-6 px-4 text-center text-on-surface font-medium">Priority</td>
                            <td class="py-6 px-4 text-center text-secondary font-bold">24/7 Dedicated</td>
                        </tr>
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-6 px-4 text-on-surface font-medium">API Throttling Limits</td>
                            <td class="py-6 px-4 text-center text-on-surface-variant">100 req/min</td>
                            <td class="py-6 px-4 text-center text-on-surface font-medium">1,000 req/min</td>
                            <td class="py-6 px-4 text-center text-on-surface font-bold">Unlimited</td>
                        </tr>
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-6 px-4 text-on-surface font-medium">Custom Webhooks</td>
                            <td class="py-6 px-4 text-center text-on-surface-variant">Basic</td>
                            <td class="py-6 px-4 text-center"><span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span></td>
                            <td class="py-6 px-4 text-center"><span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-surface">
        <div class="max-w-5xl mx-auto px-6 grid grid-cols-1 md:grid-cols-12 gap-12">
            <div class="md:col-span-4" data-aos="fade-right">
                <h3 class="text-3xl font-headline font-bold text-on-background mb-4">Frequently<br/>Asked<br/>Questions</h3>
                <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">Need more details? Reach out to our Casablanca support team.</p>
                <a href="{{ route('contact') }}" class="text-sm font-bold text-secondary flex items-center gap-2 hover:underline">
                    Contact Support <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
            
            <div class="md:col-span-8 space-y-12" data-aos="fade-left">
                <div>
                    <h4 class="text-base font-bold text-on-surface mb-3">How does the Law 69-21 automation work?</h4>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Our system automatically logs every transaction and generates the necessary delay reports required by BAM and the Ministry of Finance, ensuring you stay compliant with the latest Moroccan payment delay laws without manual intervention.</p>
                </div>
                <div>
                    <h4 class="text-base font-bold text-on-surface mb-3">Is the Free tier really free?</h4>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Yes. We believe in fueling the Moroccan startup ecosystem. You pay 0% processing fees for your first 1 Million MAD in lifetime transaction volume. Standard network fees still apply.</p>
                </div>
                <div>
                    <h4 class="text-base font-bold text-on-surface mb-3">What are "Institutional Settlements"?</h4>
                    <p class="text-sm text-on-surface-variant leading-relaxed">Reserved for Enterprise clients, these are direct RTGS transfers that bypass standard batch processing. Ideal for high-value B2B transactions or institutional treasury management.</p>
                </div>
            </div>
        </div>
    </section>

    <x-cta-section 
        title="Ready to fortify your <br/> financial operations?" 
        subtitle="Join 2,000+ Moroccan businesses already scaling with Sovereign Pay." 
    />

</x-public-layout>
