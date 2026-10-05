<x-app-layout>
    <div class="px-2 lg:px-4 py-6 lg:py-10 opacity-0 animate-fade-in-up">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 font-headline italic tracking-tighter">{{ __('Institutional Entities') }}</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">{{ __('Directory of core liquidity partners') }}</p>
            </div>
            @if(auth()->user()->hasPermission('contacts', 'create'))
            <button onclick="document.getElementById('contact-modal').classList.remove('hidden')" class="bg-[#006C4A] hover:bg-[#005a3e] text-white px-8 py-4 rounded-[2rem] shadow-xl shadow-[#006C4A]/20 font-black transition-all active:scale-95 flex items-center gap-3 uppercase text-[10px] tracking-widest leading-none">
                <span class="material-symbols-outlined text-[1.2rem]">add_circle</span>
                {{ __('New Contact') }}
            </button>
            @endif
        </div>

        <div class="bg-white rounded-3xl lg:rounded-[3rem] shadow-2xl shadow-slate-200/40 border border-slate-50 overflow-hidden font-sans" x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false; setTimeout(() => { if(typeof AOS !== 'undefined') AOS.refresh() }, 50); }, 500)">
            
            <template x-if="isLoading">
                <div class="p-8 space-y-4">
                    <!-- Table header skeleton -->
                    <div class="flex gap-4 mb-6 pb-4 border-b border-slate-100">
                        @for($j=0; $j<5; $j++)
                        <div class="h-3 w-24 bg-slate-200 rounded-full animate-shimmer {{ $j == 4 ? 'ml-auto' : '' }}"></div>
                        @endfor
                    </div>
                    <!-- Table rows skeleton -->
                    @for($i=0; $i<5; $i++)
                    <div class="flex items-center gap-6 py-4">
                        <div class="space-y-2 flex-1">
                            <div class="h-4 w-32 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-3 w-16 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="space-y-2 flex-1">
                            <div class="h-4 w-28 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-2 w-32 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="space-y-2 flex-1">
                            <div class="h-4 w-24 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-2 w-20 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="space-y-2 flex-1">
                            <div class="h-4 w-28 bg-slate-100 rounded-full animate-shimmer"></div>
                            <div class="h-2 w-32 bg-slate-100 rounded-full animate-shimmer"></div>
                        </div>
                        <div class="h-6 w-6 bg-slate-100 rounded-lg animate-shimmer ml-auto"></div>
                    </div>
                    @endfor
                </div>
            </template>

            <div x-show="!isLoading" x-cloak class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Name / Type') }}</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Identifier (ICE)') }}</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Fiscal (IF) / RC') }}</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Contact / City') }}</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-[#006C4A]" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 50) }}">
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-900 text-lg font-headline tracking-tighter italic">{{ $contact->name }}</div>
                                    <span class="inline-block mt-2 px-3 py-1 {{ $contact->type === 'client' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[8px] font-black rounded-full uppercase tracking-widest border {{ $contact->type === 'client' ? 'border-emerald-100' : 'border-amber-100' }}">
                                        {{ $contact->type }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-mono text-xs font-black text-slate-700 tracking-tighter">{{ $contact->ice }}</div>
                                    <div class="text-[8px] text-slate-400 font-bold uppercase tracking-widest mt-1.5">{{ __('Digital ICE Signal') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-black text-slate-900">IF: {{ $contact->if ?? '---' }}</div>
                                    <div class="text-[9px] text-slate-400 font-mono tracking-tighter mt-1">RC: {{ $contact->rc }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-bold text-slate-600 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[1rem]">call</span>
                                        {{ $contact->phone ?? __('No phone') }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 truncate max-w-[150px] mt-1.5">{{ $contact->address ?? __('Address not specified') }}</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if(auth()->user()->hasPermission('contacts', 'edit'))
                                    <a href="{{ route('contacts.edit', $contact->id) }}" class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 hover:text-[#006C4A] hover:bg-[#006C4A]/5 rounded-xl transition-all border border-slate-100">
                                        <span class="material-symbols-outlined text-[1.2rem]">edit_square</span>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-8 border border-slate-100 shadow-inner group-hover:scale-110 transition-transform duration-700">
                                            <span class="material-symbols-outlined text-slate-300 text-4xl">group_off</span>
                                        </div>
                                        <h3 class="text-xl font-black text-slate-800 tracking-tight font-headline italic">{{ __('No contacts registered') }}</h3>
                                        <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mt-4 text-center leading-relaxed">{{ __('Clients and suppliers will appear here. Add your first contact.') }}</p>
                                        @if(auth()->user()->hasPermission('contacts', 'create'))
                                        <button onclick="document.getElementById('contact-modal').classList.remove('hidden')" class="mt-10 bg-[#0b1120] hover:bg-black text-white px-10 py-4 rounded-full font-black transition-all active:scale-95 text-[10px] uppercase tracking-widest shadow-2xl shadow-slate-900/20">
                                            + {{ __('New Contact') }}
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Contact Create Modal -->
    <div id="contact-modal" class="hidden fixed inset-0 bg-[#0b1120]/60 backdrop-blur-xl z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100 opacity-0 animate-fade-in-up" style="animation-duration: 0.3s;">
            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="p-10 bg-[#0b1120] relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full"></div>
                    <h3 class="text-2xl font-black text-white italic tracking-tight font-headline">{{ __('New Contact') }}</h3>
                    <p class="text-slate-400 text-[9px] font-black uppercase mt-2 tracking-[0.3em]">{{ __('Vault entity registration') }}</p>
                </div>
                <div class="p-10 pt-4 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Classification') }}</label>
                            <select name="type" required class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                                <option value="client">{{ __('Client') }}</option>
                                <option value="supplier">{{ __('Supplier') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Company / Name') }}</label>
                            <input type="text" name="name" required class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Institutional Identifier (ICE) - 15 digits') }}</label>
                        <input type="text" name="ice" required minlength="15" maxlength="15" pattern="[0-9]{15}" placeholder="000000000000000" class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 font-mono text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all tracking-tighter">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Fiscal ID (IF)') }}</label>
                            <input type="text" name="if" maxlength="9" class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Commercial Registry (RC)') }}</label>
                            <input type="text" name="rc" required class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Phone Signal') }}</label>
                            <input type="text" name="phone" class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Headquarters City') }}</label>
                            <input type="text" name="address" class="w-full border-slate-100 bg-slate-50/50 rounded-[1.5rem] p-4 text-sm font-black focus:ring-[#006C4A] focus:border-[#006C4A] transition-all">
                        </div>
                    </div>
                </div>
                <div class="p-10 bg-slate-50/50 flex gap-4">
                    <button type="button" onclick="document.getElementById('contact-modal').classList.add('hidden')" class="flex-1 px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">{{ __('Cancel') }}</button>
                    <button type="submit" class="flex-2 bg-[#CDA833] text-[#0b1120] px-12 py-4 rounded-full text-[10px] font-black uppercase tracking-widest shadow-2xl shadow-[#CDA833]/20 hover:scale-105 transition-all">{{ __('Verify & Register') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
