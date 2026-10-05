<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8" x-data="{ activeTab: 'personal' }">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Profile Sidebar -->
            <div class="lg:w-1/3 space-y-8 animate-fade-in-left">
                <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-10 flex flex-col items-center text-center">
                    <div class="relative group">
                        <div class="w-40 h-40 rounded-full border-8 border-slate-50 overflow-hidden shadow-xl ring-1 ring-slate-100 transition-transform group-hover:scale-[1.02] duration-500">
                            @if($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-300 text-[5rem]">account_circle</span>
                                </div>
                            @endif
                        </div>
                        <label for="profile_picture_input" class="absolute bottom-2 right-2 w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-slate-900 transition-all border-4 border-white">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </label>
                    </div>

                    <h2 class="mt-8 text-2xl font-black text-slate-900 italic font-headline">{{ $user->name }}</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">{{ $user->role === 'SUPER_ADMIN' ? 'Commander' : 'Administrator' }}</p>

                    <div class="w-full mt-10 space-y-2">
                        <button 
                            @click="activeTab = 'personal'" 
                            :class="activeTab === 'personal' ? 'bg-orange-50 text-orange-600 border-orange-100' : 'text-slate-500 hover:bg-slate-50 border-transparent'"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all border group">
                            <span class="material-symbols-outlined text-[1.2rem]" :class="activeTab === 'personal' ? 'text-orange-600' : 'text-slate-400 group-hover:text-slate-600'">person</span>
                            Personal Information
                        </button>
                        <button 
                            @click="activeTab = 'security'" 
                            :class="activeTab === 'security' ? 'bg-orange-50 text-orange-600 border-orange-100' : 'text-slate-500 hover:bg-slate-50 border-transparent'"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all border group">
                            <span class="material-symbols-outlined text-[1.2rem]" :class="activeTab === 'security' ? 'text-orange-600' : 'text-slate-400 group-hover:text-slate-600'">lock</span>
                            Login & Password
                        </button>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all border border-transparent group">
                                <span class="material-symbols-outlined text-[1.2rem] text-slate-400 group-hover:text-rose-600">logout</span>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:w-2/3 animate-fade-in-up" x-show="activeTab === 'personal'">
                <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-12">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="profile_picture" id="profile_picture_input" class="hidden" @change="this.form.submit()">

                        <h1 class="text-3xl font-black text-slate-900 italic font-headline mb-10">Personal Information</h1>

                        <div class="space-y-10">
                            <!-- Gender selection -->
                            <div class="flex items-center gap-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="male" {{ $user->gender === 'male' || !$user->gender ? 'checked' : '' }} class="w-5 h-5 border-2 border-slate-200 text-orange-500 focus:ring-orange-500 transition-all cursor-pointer">
                                    <span class="text-sm font-black text-slate-700 group-hover:text-slate-900">Male</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="female" {{ $user->gender === 'female' ? 'checked' : '' }} class="w-5 h-5 border-2 border-slate-200 text-orange-500 focus:ring-orange-500 transition-all cursor-pointer">
                                    <span class="text-sm font-black text-slate-700 group-hover:text-slate-900">Female</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- First Name -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Roland" required
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>

                                <!-- Last Name -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Donald" required
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                                    <div class="relative">
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="rolandDonald@mail.com" required
                                               class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none pr-32">
                                        <div class="absolute inset-y-0 right-5 flex items-center">
                                            <div class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full flex items-center gap-2 border border-emerald-100">
                                                <span class="material-symbols-outlined text-[1rem] fill-1">check_circle</span>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Verified</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="3605 Parker Rd."
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>

                                <!-- Phone Number -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="(405) 555-0128"
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>

                                <!-- Date of Birth -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date of Birth</label>
                                    <div class="relative">
                                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                               class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none appearance-none">
                                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                            <span class="material-symbols-outlined text-slate-400 text-xl">calendar_month</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Location</label>
                                    <div class="relative">
                                        <select name="location" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none appearance-none cursor-pointer">
                                            <option value="">Select Location</option>
                                            <option value="Atlanta, USA" {{ (old('location', $user->location) == 'Atlanta, USA') ? 'selected' : '' }}>Atlanta, USA</option>
                                            <option value="Casablanca, MA" {{ (old('location', $user->location) == 'Casablanca, MA') ? 'selected' : '' }}>Casablanca, MA</option>
                                            <option value="Paris, FR" {{ (old('location', $user->location) == 'Paris, FR') ? 'selected' : '' }}>Paris, FR</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                            <span class="material-symbols-outlined text-slate-400 text-xl">expand_more</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="30301"
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-50">
                                <a href="{{ route('dashboard') }}" class="flex-1 px-8 py-5 border-2 border-orange-500 text-orange-600 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-orange-50 transition-all text-center">
                                    Discard Changes
                                </a>
                                <button type="submit" class="flex-1 px-8 py-5 bg-orange-500 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 shadow-xl shadow-orange-500/20 transition-all">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tab -->
            <div class="lg:w-2/3 animate-fade-in-up" x-show="activeTab === 'security'" x-cloak>
                <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-12">
                     <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h1 class="text-3xl font-black text-slate-900 italic font-headline mb-10">Login & Password</h1>
                        
                        <!-- Re-include necessary fields as hidden to pass validation if required, 
                             or keep current first/last if controller handles partial updates -->
                        <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                        <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="space-y-10">
                            <div class="grid grid-cols-1 gap-8">
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                                    <input type="password" name="password" placeholder="••••••••"
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                           class="w-full bg-slate-50 border-slate-100 rounded-2xl p-5 text-sm font-bold focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/5 transition-all outline-none">
                                </div>
                            </div>

                            <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl flex gap-5">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-orange-500">verified_user</span>
                                </div>
                                <div class="">
                                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-tight">Security Advice</h3>
                                    <p class="text-[10px] font-bold text-slate-500 leading-relaxed mt-1">
                                        Use a complex password with at least 8 characters including symbols and numbers to ensure maximum account protection.
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-slate-50">
                                <button type="submit" class="w-full px-8 py-5 bg-orange-500 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 shadow-xl shadow-orange-500/20 transition-all">
                                    Update Security Credentials
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
