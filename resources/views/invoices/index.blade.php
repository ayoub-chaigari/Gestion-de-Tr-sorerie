<x-app-layout>
    <div class="px-2 lg:px-4 py-6 lg:py-10 opacity-0 animate-fade-in-up">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-900 font-headline italic tracking-tighter">{{ __('Liquidity Liabilities') }}</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">{{ __('Institutional ledger of accounts payable') }}</p>
            </div>
            @if(auth()->user()->hasPermission('invoices', 'create'))
            <a href="{{ route('invoices.create') }}" class="bg-[#006C4A] hover:bg-[#005a3e] text-white px-8 py-4 rounded-[2rem] shadow-xl shadow-[#006C4A]/20 font-black transition-all active:scale-95 flex items-center gap-3 uppercase text-[10px] tracking-widest leading-none">
                <span class="material-symbols-outlined text-[1.2rem]">add_circle</span>
                {{ __('New Invoice') }}
            </a>
            @endif
        </div>

        <!-- Search Bar & Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-8" data-aos="fade-down" data-aos-delay="100">
            <form action="{{ route('invoices.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[1.2rem]">search</span>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by reference, supplier...') }}" class="w-full pl-14 pr-6 py-4 border border-slate-100 rounded-2xl focus:ring-[#006C4A] focus:border-[#006C4A] text-sm font-black bg-slate-50/50 placeholder-slate-400 transition-all">
                </div>
                
                <div class="md:w-72">
                    <select name="status" class="w-full px-6 py-4 border border-slate-100 rounded-2xl focus:ring-[#006C4A] focus:border-[#006C4A] text-sm font-black bg-slate-50/50 text-slate-700 transition-all">
                        <option value="">{{ __('All Compliance Statuses') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>{{ __('Cleared / Paid') }}</option>
                        <option value="at_risk" {{ request('status') === 'at_risk' ? 'selected' : '' }}>{{ __('At Risk Alert') }}</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>{{ __('Overdue Breach') }} (Loi 69-21)</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-[#0b1120] hover:bg-black text-white px-10 py-4 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl shadow-slate-900/10 active:scale-95">
                    {{ __('Filter Signals') }}
                </button>
                
                @if(request()->has('search') && request('search') != '' || request()->has('status') && request('status') != '')
                    <a href="{{ route('invoices.index') }}" class="px-6 py-3 rounded-xl text-slate-500 font-bold text-sm bg-slate-100 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ __('Clear') }}
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-3xl lg:rounded-[3rem] shadow-2xl shadow-slate-200/40 border border-slate-50 overflow-hidden" x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false; setTimeout(() => { if(typeof AOS !== 'undefined') AOS.refresh() }, 50); }, 100)">
            
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
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Reference / Supplier') }}</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Date / Maturity') }}</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Net Amount') }}</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Settlement Delta') }}</th>
                            <th class="px-8 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Vault Signal') }}</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $invoice)
                            @php
                                $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($invoice->due_date)) && $invoice->status !== 'paid';
                                $isAtRisk = \Carbon\Carbon::now()->addDays(7)->gt(\Carbon\Carbon::parse($invoice->due_date)) && !$isOverdue && $invoice->status !== 'paid';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-all border-l-4 border-transparent hover:border-[#006C4A]" data-aos="fade-up" data-aos-delay="{{ min(150 + ($loop->index * 30), 300) }}">
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-900 font-headline italic tracking-tighter">{{ $invoice->reference }}</div>
                                    <div class="text-[9px] text-slate-400 font-black uppercase tracking-widest mt-1">{{ $invoice->supplier->name }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-xs font-black text-slate-900">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</div>
                                    <div class="text-[8px] font-black {{ $isOverdue ? 'text-rose-600' : 'text-slate-400' }} uppercase tracking-widest mt-1">{{ __('Maturity') }}: {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="font-black text-slate-900 italic tracking-tighter text-lg">{{ number_format($invoice->amount, 2) }} <span class="text-[10px] text-slate-400 not-italic">MAD</span></div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="text-[10px] font-black text-emerald-600">{{ number_format($invoice->paid_amount, 2) }}</div>
                                    <div class="text-sm font-black text-slate-400 tracking-tighter">{{ number_format($invoice->remaining_amount, 2) }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($invoice->status === 'paid')
                                        <span class="px-4 py-1.5 bg-emerald-50 text-emerald-700 text-[8px] font-black rounded-full uppercase tracking-widest border border-emerald-100">{{ __('Cleared') }}</span>
                                    @elseif($isOverdue)
                                        <span class="px-4 py-1.5 bg-rose-50 text-rose-700 text-[8px] font-black rounded-full uppercase tracking-widest border border-rose-100 animate-pulse">{{ __('Breach') }}</span>
                                    @elseif($isAtRisk)
                                        <span class="px-4 py-1.5 bg-amber-50 text-amber-700 text-[8px] font-black rounded-full uppercase tracking-widest border border-amber-100">{{ __('At Risk') }}</span>
                                    @else
                                        <span class="px-4 py-1.5 bg-blue-50 text-blue-700 text-[8px] font-black rounded-full uppercase tracking-widest border border-blue-100">{{ __('Awaiting') }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 hover:text-[#006C4A] hover:border-[#006C4A]/20 rounded-xl transition-all border border-slate-100">
                                            <span class="material-symbols-outlined text-[1.2rem]">visibility</span>
                                        </a>
                                        
                                        @if($invoice->remaining_amount > 0 && auth()->user()->hasPermission('invoices', 'create'))
                                            <button onclick="openCashModal({{ $invoice->id }}, '{{ $invoice->reference }}', {{ $invoice->remaining_amount }})" class="bg-[#006C4A] hover:bg-[#005a3e] text-white px-6 py-2.5 rounded-full shadow-lg shadow-[#006C4A]/10 transition-all active:scale-95 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                                                <span class="material-symbols-outlined text-[1.2rem]">payments</span>
                                                {{ __('Settle') }}
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
                                        <h3 class="text-base font-black text-slate-800 tracking-tight">{{ __('No invoices registered') }}</h3>
                                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mt-2 text-center leading-relaxed">{{ __('Your supplier invoices will appear here. Start by adding a new invoice.') }}</p>
                                        @if(auth()->user()->hasPermission('invoices', 'create'))
                                        <a href="{{ route('invoices.create') }}" class="mt-8 bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-xl font-bold transition-all active:scale-95 text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/10">
                                            + {{ __('New Invoice') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Cash Modal -->
    <div id="quick-cash-modal" class="hidden fixed inset-0 bg-[#0b1120]/60 backdrop-blur-xl z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-sm overflow-hidden border border-slate-100 opacity-0 animate-fade-in-up" style="animation-duration: 0.3s;">
            <form id="quick-cash-form" action="" method="POST">
                @csrf
                <input type="hidden" name="method" value="cash">
                <div class="p-10 bg-[#0b1120] relative">
                    <div class="absolute -right-10 -bottom-10 w-24 h-24 bg-white/5 rounded-full"></div>
                    <h3 class="text-xl font-black italic text-white font-headline">{{ __('Institutional Settlement') }}</h3>
                    <p class="text-slate-400 text-[10px] font-black uppercase mt-1 tracking-widest" id="modal-invoice-ref">{{ __('Liability Clearance') }}</p>
                </div>
                <div class="p-10 space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Transfer Amount (MAD)') }}</label>
                        <input type="number" name="amount" id="modal-cash-amount" step="0.01" min="0.01" required 
                               class="w-full text-3xl font-black border-slate-100 rounded-2xl p-5 focus:ring-[#006C4A] focus:border-[#006C4A] bg-slate-50/50 italic tracking-tighter shadow-inner">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest px-1">{{ __('Settlement Execution Date') }}</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required 
                               class="w-full text-sm font-black border-slate-100 rounded-2xl p-5 focus:ring-[#006C4A] focus:border-[#006C4A] bg-slate-50/50">
                    </div>
                </div>
                <div class="p-10 bg-slate-50/50 flex gap-4">
                    <button type="button" onclick="document.getElementById('quick-cash-modal').classList.add('hidden')" class="flex-1 px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors uppercase">{{ __('Cancel') }}</button>
                    <button type="submit" class="flex-2 bg-[#CDA833] text-[#0b1120] px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest shadow-2xl shadow-[#CDA833]/20 active:scale-95 transition-all">{{ __('Verify & Clear') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCashModal(invoiceId, reference, remaining) {
            const modal = document.getElementById('quick-cash-modal');
            const form = document.getElementById('quick-cash-form');
            const refText = document.getElementById('modal-invoice-ref');
            const amountInput = document.getElementById('modal-cash-amount');

            form.action = `/invoices/${invoiceId}/payments`;
            refText.innerText = `Facture #${reference}`;
            amountInput.value = remaining;
            amountInput.max = remaining;
            
            // Show modal instantly
            modal.classList.remove('hidden');
            
            // Replay entrance animation
            const inner = modal.querySelector('.animate-fade-in-up');
            if (inner) {
                inner.style.animation = 'none';
                inner.offsetHeight; // trigger reflow
                inner.style.animation = '';
            }
            
            // Auto-focus the amount field
            setTimeout(() => amountInput.focus(), 50);
        }
    </script>
</x-app-layout>
