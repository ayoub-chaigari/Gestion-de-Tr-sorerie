<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Remittance;
use App\Models\IncomingCheque;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemittanceController extends Controller
{
    public function index()
    {
        $remittances = Remittance::with('bankAccount')->orderBy('remittance_date', 'desc')->paginate(15);
        return view('remittances.index', compact('remittances'));
    }

    public function create()
    {
        $bankAccounts = BankAccount::all();
        // Pending cheques that are not yet in a remittance
        $pendingCheques = IncomingCheque::with('contact')
                            ->where('status', 'pending')
                            ->whereNull('remittance_id')
                            ->orderBy('due_date', 'asc')
                            ->get();
        // Unique drawer banks for filtering
        $drawerBanks = $pendingCheques->pluck('bank_name')->unique()->filter()->values();
        return view('remittances.create', compact('bankAccounts', 'pendingCheques', 'drawerBanks'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'cheque_ids' => 'required|array',
            'cheque_ids.*' => 'exists:incoming_cheques,id',
            'type' => 'required|in:cheque,effect',
            'remittance_date' => 'required|date',
        ]);

        return DB::transaction(function () use ($request) {
            $isEffectType = ($request->type === 'effect');
            
            // Validate that all selected items match the type
            $cheques = IncomingCheque::whereIn('id', $request->cheque_ids)->get();
            foreach ($cheques as $cheque) {
                if ($cheque->is_effect != $isEffectType) {
                    return redirect()->back()
                        ->withErrors(['cheque_ids' => "Certains titres sélectionnés ne correspondent pas au type de bordereau choisi ({$request->type})."])
                        ->withInput();
                }
            }

            $totalAmount = $cheques->sum('amount');

            $remittance = Remittance::create([
                'company_id' => auth()->user()->company_id,
                'bank_account_id' => $request->bank_account_id,
                'type' => $request->type,
                'remittance_date' => $request->remittance_date,
                'total_amount' => $totalAmount,
                'reference' => 'BDR-' . ($isEffectType ? 'EFF-' : 'CHQ-') . now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2))),
                'status' => 'sent'
            ]);

            // Update cheques
            IncomingCheque::whereIn('id', $request->cheque_ids)->update([
                'remittance_id' => $remittance->id,
                'status' => 'deposited', // "Remis en banque"
                'bank_account_id' => $request->bank_account_id
            ]);

            return redirect()->route('remittances.index')->with('success', "Bordereau de remise ({$request->type}) généré avec succès.");
        });
    }

    public function show(Remittance $remittance)
    {
        $remittance->load(['bankAccount', 'cheques.contact', 'cheques.payments.invoice']);
        return view('remittances.show', compact('remittance'));
    }

    public function bankExport(Remittance $remittance)
    {
        $remittance->load(['bankAccount', 'cheques.contact', 'cheques.payments.invoice']);
        return view('remittances.bank_bordereau', compact('remittance'));
    }
}
