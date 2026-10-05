<x-public-layout>
    <x-slot name="title">Contact Sovereign Pay | Support Your Growth</x-slot>

    <!-- Hero Section -->
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="max-w-3xl" data-aos="zoom-in" data-aos-duration="1000">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-secondary-container/30 text-on-secondary-container rounded-full text-xs font-semibold tracking-wider uppercase mb-6">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    Support Center
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tighter text-on-background leading-[1.1] mb-8">
                    We're Here to Support <br/>
                    <span class="bg-gradient-to-r from-secondary to-on-secondary-container bg-clip-text text-transparent">Your Growth</span>.
                </h1>
                <p class="text-xl text-on-surface-variant max-w-xl leading-relaxed">
                    Dedicated concierge support for Casablanca's forward-thinking enterprises. Connect with our financial architects today.
                </p>
            </div>
        </div>
        <!-- Sovereign Texture Background -->
        <div class="absolute top-0 right-0 w-1/2 h-full opacity-10 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_40%,_var(--tw-gradient-stops))] from-secondary-container via-transparent to-transparent"></div>
        </div>
    </section>

    <!-- Contact Bento Grid -->
    <section class="pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Contact Form Card -->
                <div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-sm border border-outline-variant/10" data-aos="fade-right">
                    <h2 class="text-3xl font-bold tracking-tight text-on-surface mb-8">Send a Message</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-[#006C4A] rounded-xl font-bold text-sm flex items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form class="space-y-6" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-on-surface ml-1">Full Name</label>
                                <input name="name" class="w-full bg-surface-container-low border-none rounded-md px-4 py-4 focus:ring-2 focus:ring-secondary/20 transition-all placeholder:text-outline" placeholder="Jamal Alami" type="text" required value="{{ old('name') }}"/>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-on-surface ml-1">Company</label>
                                <input name="company" class="w-full bg-surface-container-low border-none rounded-md px-4 py-4 focus:ring-2 focus:ring-secondary/20 transition-all placeholder:text-outline" placeholder="Enterprise SARL" type="text" value="{{ old('company') }}"/>
                                @error('company') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-on-surface ml-1">Email Address</label>
                            <input name="email" class="w-full bg-surface-container-low border-none rounded-md px-4 py-4 focus:ring-2 focus:ring-secondary/20 transition-all placeholder:text-outline" placeholder="jamal@enterprise.ma" type="email" required value="{{ old('email') }}"/>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-on-surface ml-1">Message</label>
                            <textarea name="message" class="w-full bg-surface-container-low border-none rounded-md px-4 py-4 focus:ring-2 focus:ring-secondary/20 transition-all placeholder:text-outline resize-none" placeholder="How can Sovereign Pay accelerate your business?" rows="5" required>{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full md:w-auto px-10 py-4 bg-primary text-on-primary font-bold rounded-full hover:shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-3">
                            <span>Dispatch Message</span>
                            <span class="material-symbols-outlined text-lg">send</span>
                        </button>
                    </form>
                </div>

                <!-- Sidebar Info -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Local Contact Info -->
                    <div class="bg-primary-container text-on-primary rounded-xl p-8 shadow-2xl relative overflow-hidden group" data-aos="fade-left" data-aos-delay="200">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold mb-8">Headquarters</h3>
                            <div class="space-y-8">
                                <div class="flex gap-5">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-secondary-fixed">location_on</span>
                                    </div>
                                    <div>
                                        <p class="text-on-primary-container text-sm font-medium mb-1">Office Location</p>
                                        <p class="text-lg leading-relaxed">CFC First Tower, 14th Floor<br/>Casablanca Finance City, Morocco</p>
                                    </div>
                                </div>
                                <div class="flex gap-5">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-secondary-fixed">call</span>
                                    </div>
                                    <div>
                                        <p class="text-on-primary-container text-sm font-medium mb-1">Direct Line</p>
                                        <p class="text-lg font-semibold">+212 522 900 800</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-12 pt-8 border-t border-white/10">
                                <button class="w-full bg-secondary text-on-secondary py-5 rounded-xl font-bold flex items-center justify-center gap-3 hover:bg-secondary/90 transition-all shadow-lg active:scale-95 group/wa">
                                    <span class="material-symbols-outlined group-hover/wa:rotate-12 transition-transform">chat</span>
                                    <span>Chat on WhatsApp</span>
                                </button>
                            </div>
                        </div>
                        <!-- Subtle decorative texture -->
                        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-secondary/10 rounded-full blur-3xl"></div>
                    </div>

                    <!-- Map Section -->
                    <div class="bg-surface-container rounded-xl overflow-hidden shadow-sm h-72 relative" data-aos="fade-up" data-aos-delay="400">
                        <div class="absolute inset-0 grayscale opacity-40 hover:opacity-70 transition-opacity cursor-crosshair">
                            <img class="w-full h-full object-cover" data-alt="stylized architectural map of Casablanca Finance City showing modern buildings and urban planning in a minimalist monochrome style" data-location="Casablanca" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBMd20iQaW5Mig7CNuSfE7tQQRjheVyfRrLNKmTJGqEmiTgWhUVgeKmVcUuilBXKg5oI92rp3ZvYqExlVsl_zoMtxC8wVsgClgNghGQbtJLfzh4sOjghiMFOyt57uuuGi12kxGec31sTutKaH3ek1zfJweRsueWz_YKqGfaygYRNgJhFGLZBQU1KC81P3grALzQe_GYS3jcxCgua861PwJ5wo-lohCG_zYdpm13CykYKq8SRxXExKhpvar2FotzA5hNKLuDa9SOPZ69"/>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="bg-primary p-4 rounded-full shadow-2xl animate-bounce">
                                <span class="material-symbols-outlined text-on-primary">location_on</span>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 bg-surface/90 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold text-on-surface shadow-sm">
                            Casablanca Finance City
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
