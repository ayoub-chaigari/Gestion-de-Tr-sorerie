<x-app-layout>
    <div class="p-4 lg:p-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-800 italic">{{ __('Cheque Tracking') }}</h1>
            @if(auth()->user()->hasPermission('cheques', 'create'))
            <a href="{{ route('cheques.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-blue-100 font-bold transition-all active:scale-95 flex items-center gap-2 uppercase text-xs tracking-widest">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('New Cheque') }}
            </a>
            @endif
        </div>

        <!-- Search Bar & Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-8" data-aos="fade-down" data-aos-delay="100">
            <form action="{{ route('cheques.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by cheque number, bank or client...') }}" class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-medium bg-slate-50 placeholder-slate-400">
                </div>
                
                <div class="md:w-64">
                    <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-medium bg-slate-50 text-slate-700">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="deposited" {{ request('status') === 'deposited' ? 'selected' : '' }}>{{ __('Deposited') }}</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                        <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                        <option value="endorsed" {{ request('status') === 'endorsed' ? 'selected' : '' }}>{{ __('Endorsed') }}</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all shadow-md active:scale-95">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->has('search') && request('search') != '' || request()->has('status') && request('status') != '')
                    <a href="{{ route('cheques.index') }}" class="px-6 py-3 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Clear') }}
                    </a>
                @endif
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl shadow-sm flex items-center">
                <div class="bg-emerald-500 text-white rounded-full p-1 mr-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white rounded-3xl lg:rounded-[3rem] shadow-2xl shadow-slate-200/40 border border-slate-50 overflow-hidden" x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false; setTimeout(() => { if(typeof AOS !== 'undefined') AOS.refresh() }, 50); }, 100)" data-aos="fade-up" data-aos-delay="200">
            
            <template x-if="isLoading">
                <div class="p-8 space-y-4">
                    <!-- Table header skeleton -->
                    <div class="flex gap-4 mb-6 pb-4 border-b border-slate-100">
                        @for($j=0; $j<6; $j++)
                        <div class="h-3 w-24 bg-slate-200 rounded-full animate-shimmer {{ $j == 5 ? 'ml-auto' : '' }}"></div>
                        @endfor
                    </div>
                    <!-- Table rows skeleton -->
                    @for($i=0; $i<6; $i++)
                    <div class="flex items-center gap-6 py-4">
                        <div class="h-4 w-28 bg-slate-100 rounded-full animate-shimmer"></div>
                        <div class="flex gap-3 flex-1 items-center">
                            <div class="h-10 w-10 bg-slate-100 rounded-[10px] flex-shrink-0 animate-shimmer"></div>
                            <div class="space-y-2">
                                <div class="h-3 w-32 bg-slate-100 rounded-full animate-shimmer"></div>
                                <div class="h-2 w-20 bg-slate-100 rounded-full animate-shimmer"></div>
                            </div>
                        </div>
                        <div class="h-4 w-24 bg-slate-100 rounded-full animate-shimmer"></div>
                        <div class="h-4 w-20 bg-slate-100 rounded-full animate-shimmer"></div>
                        <div class="h-6 w-16 bg-slate-100 rounded-lg animate-shimmer"></div>
                        <div class="h-8 w-24 bg-slate-100 rounded-xl animate-shimmer ml-auto"></div>
                    </div>
                    @endfor
                </div>
            </template>

            <div x-show="!isLoading" x-cloak class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Number') }}</th>
                            <th scope="col" class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Client (Source)') }}</th>
                            <th scope="col" class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-36">{{ __('Amount / Balance') }}</th>
                            <th scope="col" class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-36">{{ __('Due Date') }}</th>
                            <th scope="col" class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Status') }}</th>
                            <th scope="col" class="px-6 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($cheques as $cheque)
                            <tr class="hover:bg-slate-50 transition-colors" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 50) }}">
                                <td class="px-6 py-4">
                                    <div class="font-mono text-slate-800 font-black tracking-tighter">{{ $cheque->cheque_number }}</div>
                                    
                                    @if($cheque->payments->count() > 0)
                                        <div class="mt-2 space-y-1">
                                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ __('Payments made') }} :</p>
                                            @foreach($cheque->payments as $p)
                                                <div class="flex items-center gap-2 text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100 w-fit">
                                                    <svg class="w-2 h-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                                                   <div>• {{ optional($p->invoice)->reference ?? 'Fct #'.$p->invoice_id }} ({{ number_format($p->amount, 2, ',', ' ') }} DH)</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $drawerBank = collect(\App\Http\Controllers\Web\TreasuryController::$banks)->firstWhere('name', $cheque->bank_name);
                                        @endphp
                                        @if($drawerBank && $drawerBank['logo'])
                                            <img src="{{ asset('storage/' . $drawerBank['logo']) }}" class="w-8 h-8 rounded-lg object-contain bg-slate-50 border border-slate-100 p-1">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-400 border border-slate-200 uppercase">
                                                {{ substr($cheque->bank_name ?? '?', 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">{{ optional($cheque->contact)->name ?? __('Unknown Client') }}</div>
                                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $cheque->bank_name ?? __('Bank Not Specified') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-black text-slate-900">{{ number_format($cheque->amount, 2, ',', ' ') }} <span class="text-[10px] text-slate-400 font-bold">DH</span></div>
                                    @if($cheque->remaining_amount < $cheque->amount && $cheque->remaining_amount > 0)
                                        <div class="text-[10px] text-emerald-600 font-black mt-1 uppercase tracking-tight italic">
                                            {{ __('Balance') }}: {{ number_format($cheque->remaining_amount, 2, ',', ' ') }} DH
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600 font-medium">
                                    {{ \Carbon\Carbon::parse($cheque->due_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colorMap = [
                                            'pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'deposited'=> 'bg-blue-100 text-blue-800 border-blue-200',
                                            'paid'     => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'unpaid'   => 'bg-red-100 text-red-800 border-red-200',
                                            'endorsed' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        ];
                                        $labelMap = [
                                            'pending'  => __('Pending'),
                                            'deposited'=> __('Deposited'),
                                            'paid'     => __('Paid'),
                                            'unpaid'   => __('Unpaid'),
                                            'endorsed' => ($cheque->remaining_amount > 0) ? __('Endorsed (Partial)') : __('Endorsed (Total)'),
                                        ];
                                        $badgeClass = $colorMap[$cheque->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex text-[10px] font-black rounded-lg border uppercase tracking-widest {{ $badgeClass }}">
                                        {{ $labelMap[$cheque->status] ?? ucfirst($cheque->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-2">
                                        @if(auth()->user()->hasPermission('cheques', 'create'))
                                        {{-- Status change dropdown --}}
                                        <form action="{{ route('cheques.status', $cheque->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="text-[10px] font-black border-slate-200 rounded-xl shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-7 cursor-pointer bg-slate-50 uppercase tracking-widest">
                                                <option value="" disabled selected>{{ __('Change...') }}</option>
                                                <option value="pending"   {{ $cheque->status === 'pending'   ? 'disabled' : '' }}>{{ __('Pending') }}</option>
                                                <option value="deposited" {{ $cheque->status === 'deposited' ? 'disabled' : '' }}>{{ __('Deposited') }}</option>
                                                <option value="paid"      {{ $cheque->status === 'paid'      ? 'disabled' : '' }}>{{ __('Paid') }}</option>
                                                <option value="unpaid"    {{ $cheque->status === 'unpaid'    ? 'disabled' : '' }}>{{ __('Unpaid') }}</option>
                                            </select>
                                        </form>
                                        @endif

                                        {{-- Endorse button — opens modal --}}
                                        @if($cheque->status !== 'paid' && $cheque->status !== 'deposited' && ($cheque->status !== 'endorsed' || $cheque->remaining_amount > 0) && auth()->user()->hasPermission('cheques', 'create'))
                                            <button
                                                onclick="openEndorseModal({{ $cheque->id }}, '{{ addslashes($cheque->cheque_number) }}', {{ $cheque->remaining_amount }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 text-[10px] font-black uppercase tracking-widest bg-purple-600 text-white rounded-xl shadow-md shadow-purple-200 hover:bg-purple-700 transition-all active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                                {{ __('Endorse') }}
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6 border border-slate-100 shadow-inner">
                                            <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-800 tracking-tight">{{ __('No cheques registered') }}</h3>
                                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mt-2 text-center leading-relaxed">{{ __('Incoming cash flows will appear here. Start by recording a physical reception.') }}</p>
                                        @if(auth()->user()->hasPermission('cheques', 'create'))
                                        <a href="{{ route('cheques.create') }}" class="mt-8 bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-xl font-bold transition-all active:scale-95 text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/10">
                                            + {{ __('Enter a Deposit') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cheques->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $cheques->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         ENDORSE MODAL (Upgraded with Invoice Selector)
    ═══════════════════════════════════════════════════════ --}}
    <div id="endorse-modal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
         onclick="closeEndorseModalIfBackdrop(event)">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" id="endorse-backdrop"></div>

        {{-- Panel --}}
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200 animate-in">
            {{-- Header --}}
            <div class="bg-gradient-to-br from-purple-600 to-purple-800 p-8 text-white">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black italic">{{ __('Cheque Endorsement') }}</h3>
                        <p class="text-purple-200 text-[10px] font-bold uppercase tracking-widest mt-0.5">{{ __('Direct transfer to a supplier') }}</p>
                    </div>
                </div>
                {{-- Cheque summary pill --}}
                <div class="bg-white/10 rounded-2xl px-5 py-4 mt-2 border border-white/20">
                    <div class="text-[9px] text-purple-200 font-black uppercase tracking-widest mb-1">{{ __('Available Balance') }}</div>
                    <div class="font-black text-white font-mono tracking-tighter text-lg" id="modal-cheque-number">—</div>
                    <div class="text-purple-200 font-bold text-sm mt-0.5" id="modal-cheque-amount">—</div>
                </div>
            </div>

            {{-- Form --}}
            <form id="endorse-form" action="" method="POST">
                @csrf @method('PATCH')

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Supplier Selector --}}
                        <div>
                            <label for="supplier_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">
                                Fournisseur Bénéficiaire
                            </label>

                            <select name="supplier_id" id="supplier_id" required
                                class="w-full border-slate-200 rounded-2xl p-4 text-sm font-black focus:ring-purple-500 focus:border-purple-500 transition-all shadow-sm bg-slate-50 cursor-pointer">
                                <option value="" disabled selected>Choisir un fournisseur...</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Invoice Selector --}}
                        <div>
                            <label for="invoice_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">
                                Associer à une Facture (Optionnel)
                            </label>

                            <select name="invoice_id" id="invoice_id"
                                class="w-full border-slate-200 rounded-2xl p-4 text-sm font-black focus:ring-purple-500 focus:border-purple-500 transition-all shadow-sm bg-slate-50 cursor-pointer">
                                <option value="" disabled selected>Choisir une facture...</option>
                                <option value="">Aucune (Avance)</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" data-supplier="{{ $invoice->supplier_id }}" data-remaining="{{ $invoice->amount - $invoice->paid_amount }}" class="hidden">
                                        {{ $invoice->reference ?? 'Fct #'.$invoice->id }} ({{ number_format($invoice->amount - $invoice->paid_amount, 2) }} MAD)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="invoice-info-box" class="hidden bg-blue-50 rounded-2xl p-5 border border-blue-100 flex items-start gap-4 transform transition-all">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-blue-600 font-black uppercase tracking-widest mb-1">{{ __('Impact on the invoice') }}</p>
                            <p class="text-xs text-blue-900 font-bold leading-relaxed" id="invoice-impact-text"></p>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-relaxed px-1">
                            {{ __('An endorsed cheque is transferred directly to the supplier without going through the bank. This action is irreversible.') }}
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-8 pb-8 flex gap-3">
                    <button type="button" onclick="closeEndorseModal()"
                        class="flex-1 px-4 py-3.5 text-[10px] font-black text-slate-400 uppercase tracking-widest rounded-2xl border border-slate-200 hover:bg-slate-50 transition-all font-sans">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="flex-1 bg-purple-600 text-white px-4 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-purple-200 hover:bg-purple-700 transition-all active:scale-95 flex items-center justify-center gap-2 font-sans border-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        {{ __('Confirm Endorsement') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-in {
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0)   scale(1); }
        }
    </style>

    <script>
        let selectedChequeAmount = 0;

        function openEndorseModal(chequeId, chequeNumber, amount) {
            selectedChequeAmount = amount;
            document.getElementById('endorse-form').action = `/cheques/${chequeId}/endorse`;
            document.getElementById('modal-cheque-number').textContent = 'N° ' + chequeNumber;
            document.getElementById('modal-cheque-amount').textContent = new Intl.NumberFormat('fr-MA', {
                style: 'currency', currency: 'MAD'
            }).format(amount);

            document.getElementById('supplier_id').value = '';
            document.getElementById('invoice_id').value = '';
            document.getElementById('invoice-info-box').classList.add('hidden');

            document.getElementById('endorse-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEndorseModal() {
            document.getElementById('endorse-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function closeEndorseModalIfBackdrop(event) {
            if (event.target === document.getElementById('endorse-backdrop') ||
                event.target === document.getElementById('endorse-modal')) {
                closeEndorseModal();
            }
        }

        const supplierSelect = document.getElementById('supplier_id');
        const invoiceSelect  = document.getElementById('invoice_id');
        const infoBox        = document.getElementById('invoice-info-box');
        const impactText     = document.getElementById('invoice-impact-text');

        supplierSelect.addEventListener('change', function() {
            const supplierId = this.value;
            invoiceSelect.value = '';
            infoBox.classList.add('hidden');

            Array.from(invoiceSelect.options).forEach(option => {
                if (option.value === "" || option.dataset.supplier === supplierId) {
                    option.classList.remove('hidden');
                } else {
                    option.classList.add('hidden');
                }
            });
        });

        invoiceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const remaining = parseFloat(selectedOption.dataset.remaining);

            if (!isNaN(remaining)) {
                infoBox.classList.remove('hidden');
                const surplus = Math.max(0, selectedChequeAmount - remaining);
                const applied = Math.min(selectedChequeAmount, remaining);
                
                if (surplus > 0) {
                    impactText.innerHTML = `La facture sera <span class="text-blue-600 font-extrabold underline">Entièrement Payée</span>.<br>Le chèque aura un <span class="text-emerald-600 font-black italic">Surplus de ${new Intl.NumberFormat('fr-MA').format(surplus)} MAD</span> après cette opération.`;
                } else {
                    const newRemaining = remaining - applied;
                    if (newRemaining === 0) {
                        impactText.innerHTML = `Cette facture sera entièrement <span class="text-blue-600 font-extrabold underline">Payée</span>.`;
                    } else {
                        impactText.innerHTML = `Il restera <span class="font-extrabold">${new Intl.NumberFormat('fr-MA').format(newRemaining)} MAD</span> à régler sur cette facture après cet endossement.`;
                    }
                }
            } else {
                infoBox.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeEndorseModal();
        });
    </script>
</x-app-layout>
