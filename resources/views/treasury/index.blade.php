<x-app-layout>
    <div class="px-4 py-8 sm:px-0">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Gestion de Trésorerie</h1>
                <p class="text-slate-500 font-medium mt-1 uppercase text-[10px] tracking-widest">Configuration des flux et comptes bancaires</p>
            </div>
            <div class="flex gap-4">
                <button onclick="document.getElementById('bank-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-slate-900 text-white px-8 py-4 rounded-3xl font-black shadow-2xl shadow-blue-200 transition-all active:scale-95 flex items-center gap-2 text-xs uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    Ajouter un Compte
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Bank Accounts Management -->
            <div class="lg:col-span-2 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                    @forelse($bankAccounts as $account)
                        @php
                            $bankInfo = collect($banks)->firstWhere('name', $account->bank_name) ?? ['color' => '#64748b', 'id_code' => '???'];
                        @endphp
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent rounded-[2.5rem] -m-2 blur-2xl transition-all group-hover:blur-3xl opacity-0 group-hover:opacity-100"></div>
                            <div class="relative bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden hover:shadow-[0_40px_80px_rgba(0,0,0,0.1)] transition-all duration-700 hover:-translate-y-2">
                                <div class="p-8">
                                    <div class="flex justify-between items-start mb-10">
                                        <div class="flex items-center gap-5">
                                            @if($account->logo_path)
                                                <div class="w-16 h-16 rounded-[1.25rem] overflow-hidden shadow-2xl border border-white bg-white flex items-center justify-center p-2">
                                                    <img src="{{ Storage::url($account->logo_path) }}" class="w-full h-full object-contain">
                                                </div>
                                            @elseif($bankInfo && isset($bankInfo['logo']) && $bankInfo['logo'])
                                                <div class="w-16 h-16 rounded-[1.25rem] overflow-hidden shadow-2xl border border-white bg-white flex items-center justify-center p-2">
                                                    <img src="{{ asset('storage/' . $bankInfo['logo']) }}" class="w-full h-full object-contain">
                                                </div>
                                            @else
                                                <div class="w-16 h-16 rounded-[1.25rem] flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-slate-200" style="background: linear-gradient(135deg, {{ $bankInfo['color'] }}, #000)">
                                                    {{ substr($account->bank_name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-black text-slate-900 text-xl tracking-tight">{{ $account->bank_name }}</h3>
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-[8px] font-black uppercase tracking-tighter border border-slate-200">Compte Courant</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('bank-accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Attention : Cette action est irréversible. Confirmer la suppression ?')">
                                            @csrf @method('DELETE')
                                            <button class="w-10 h-10 rounded-full bg-rose-50 text-rose-300 hover:bg-rose-500 hover:text-white hover:rotate-90 transition-all duration-500 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="space-y-6">
                                        <div class="bg-slate-900 rounded-[1.5rem] p-6 text-white shadow-2xl shadow-slate-200 relative overflow-hidden group/rib">
                                            <div class="absolute inset-0 bg-blue-500/10 opacity-0 group-hover/rib:opacity-100 transition-opacity"></div>
                                            <p class="text-[8px] font-black text-white/40 uppercase tracking-[0.2em] mb-3">Relevé d'Identité Bancaire</p>
                                            <div class="flex justify-between items-center">
                                                <p class="text-sm font-black font-mono tracking-widest text-blue-100">
                                                    {{ collect(str_split($account->rib, 4))->join(' ') }}
                                                </p>
                                                <svg class="w-4 h-4 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 012-2v-8a2 2 0 01-2-2h-8a2 2 0 01-2 2v8a2 2 0 012 2z"/></svg>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between px-2">
                                            <div class="flex items-center gap-3">
                                                <div class="flex flex-col">
                                                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Carnets</span>
                                                    <span class="text-xs font-black text-slate-900">{{ $account->cheque_books_count }} actifs</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">Agence</span>
                                                <span class="text-xs font-black text-slate-700 italic">{{ $account->agency ?? 'Siège Social' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 py-32 text-center bg-white rounded-[4rem] border-4 border-dashed border-slate-100">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                                <svg class="w-12 h-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="font-black text-slate-300 uppercase text-sm tracking-[0.3em]">Aucune banque connectée</h3>
                            <p class="text-slate-400 text-xs mt-2 font-medium">Commencez par ajouter votre premier compte bancaire.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Side Actions & Cheque Books -->
            <div class="space-y-8">
                <div class="bg-indigo-950 rounded-[3rem] p-10 shadow-2xl text-white relative overflow-hidden">
                    <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] -mr-32 -mb-32"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-10">
                            <h2 class="text-2xl font-black italic tracking-tight">Carnets de Chèques</h2>
                            <button onclick="document.getElementById('chequebook-modal').classList.remove('hidden')" class="w-12 h-12 bg-white/10 hover:bg-white hover:text-indigo-950 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-xl active:scale-95">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>

                        <div class="space-y-8">
                            @forelse($chequeBooks as $book)
                                <div class="bg-white/5 rounded-[2rem] p-6 border border-white/5 backdrop-blur-sm group hover:bg-white/10 transition-all duration-500">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-900/50 flex items-center justify-center p-1.5 border border-white/10">
                                                @php
                                                    $bookBank = collect($banks)->firstWhere('name', $book->bankAccount->bank_name);
                                                @endphp
                                                @if($bookBank && $bookBank['logo'])
                                                    <img src="{{ asset('storage/' . $bookBank['logo']) }}" class="w-full h-full object-contain brightness-0 invert opacity-50">
                                                @else
                                                    <span class="text-[10px] font-black text-indigo-400">{{ substr($book->bankAccount->bank_name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-[8px] font-black text-indigo-400 uppercase tracking-widest mb-0.5">{{ $book->bankAccount->bank_name }}</p>
                                                <h4 class="font-black text-sm tracking-tight italic">Série #{{ $book->start_number }}</h4>
                                            </div>
                                        </div>
                                        <form action="{{ route('cheque-books.destroy', $book) }}" method="POST" onsubmit="return confirm('Révoquer ce carnet ?')">
                                            @csrf @method('DELETE')
                                            <button class="text-white/10 hover:text-rose-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="flex items-center gap-4 mb-3">
                                        <div class="flex-1 h-2.5 bg-white/5 rounded-full overflow-hidden p-0.5">
                                            @php
                                                $total = $book->end_number - $book->start_number + 1;
                                                $used = ($book->current_number - $book->start_number);
                                                $perc = ($used / $total) * 100;
                                            @endphp
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-400 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]" style="width: {{ $perc }}%"></div>
                                        </div>
                                        <span class="text-[9px] font-black {{ ($total - $used) < 5 ? 'text-rose-400 animate-pulse' : 'text-blue-400' }} uppercase">
                                            {{ $total - $used }} RESTANTS
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center px-1">
                                        <span class="text-[8px] font-black text-white/20 uppercase">Plage: {{ $book->start_number }} &rarr; {{ $book->end_number }}</span>
                                        <span class="text-[8px] font-black text-white/50 bg-white/5 px-2 py-0.5 rounded-full">Usage: {{ round($perc) }}%</span>
                                    </div>
                                </div>
                            @empty
                                <div class="py-20 text-center opacity-20 border-2 border-dashed border-white/10 rounded-[2rem]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em]">Aucun carnet configuré</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Bank Account Modal -->
    <div id="bank-modal" class="hidden fixed inset-0 bg-slate-900/90 backdrop-blur-xl z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[3.5rem] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100 transform transition-all">
            <form action="{{ route('bank-accounts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-12 bg-slate-50 border-b border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <h3 class="text-4xl font-black text-slate-900 italic tracking-tighter">Connecter une Banque</h3>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Choisissez votre établissement partenaire</p>
                </div>
                
                <div class="p-12 space-y-10">
                    <!-- Visual Bank Picker -->
                    <div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($banks as $bank)
                                <label class="relative group cursor-pointer">
                                    <input type="radio" name="bank_name" value="{{ $bank['name'] }}" required class="peer sr-only">
                                    <div class="h-24 bg-white border-2 border-slate-100 rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300 group-hover:border-blue-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 shadow-sm relative overflow-hidden grayscale peer-checked:grayscale-0 hover:grayscale-0">
                                        @if(isset($bank['logo']) && $bank['logo'])
                                            <div class="w-12 h-12 p-2">
                                                <img src="{{ asset('storage/' . $bank['logo']) }}" class="w-full h-full object-contain">
                                            </div>
                                        @else
                                            <div class="w-10 h-1 rounded-full mb-2" style="background-color: {{ $bank['color'] }}"></div>
                                        @endif
                                        <span class="text-[9px] font-black text-slate-900 text-center px-1 leading-tight uppercase tracking-tighter">{{ $bank['name'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>  </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Agence (Optionnel)</label>
                            <input type="text" name="agency" placeholder="Ex: Agence Hassan II" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-black focus:ring-blue-600 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">RIB (24 Chiffres)</label>
                            <input type="text" name="rib" required minlength="24" maxlength="24" placeholder="000...000" class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-black font-mono focus:ring-blue-600 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Logo de la Banque (Optionnel)</label>
                        <div class="relative group">
                            <input type="file" name="logo" accept="image/*" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-sm font-bold text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white hover:border-blue-300 transition-all cursor-pointer">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase">Formats acceptés : PNG, JPG, SVG. Max 2MB.</p>
                    </div>
                </div>

                <div class="p-10 bg-slate-50 flex justify-end gap-6">
                    <button type="button" onclick="document.getElementById('bank-modal').classList.add('hidden')" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-10 py-5 rounded-3xl text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-blue-200 hover:bg-slate-900 transition-all">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cheque Book Modal -->
    <div id="chequebook-modal" class="hidden fixed inset-0 bg-slate-900/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-md overflow-hidden border border-slate-100">
            <form action="{{ route('cheque-books.store') }}" method="POST">
                @csrf
                <div class="p-10 bg-slate-900">
                    <h3 class="text-3xl font-black text-white italic">Nouveau Carnet</h3>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mt-2">Gérez la plage de numérotation</p>
                </div>
                
                <div class="p-10 space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Compte Source</label>
                        <select name="bank_account_id" required class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-black focus:ring-blue-600 transition-all">
                            @foreach($bankAccounts as $account)
                                <option value="{{ $account->id }}">{{ $account->bank_name }} (...{{ substr($account->rib, -4) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">N° Début</label>
                            <input type="number" name="start_number" required class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-black focus:ring-blue-600 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">N° Fin</label>
                            <input type="number" name="end_number" required class="w-full bg-slate-50 border-slate-100 rounded-2xl p-4 text-sm font-black focus:ring-blue-600 transition-all">
                        </div>
                    </div>
                </div>

                <div class="p-10 bg-slate-50 flex justify-end gap-6">
                    <button type="button" onclick="document.getElementById('chequebook-modal').classList.add('hidden')" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="bg-slate-900 text-white px-10 py-5 rounded-3xl text-xs font-black uppercase tracking-[0.2em] shadow-2xl">Activer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
