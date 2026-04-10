<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\ChequeBook;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    public static $banks = [
        ['name' => 'Attijariwafa Bank', 'color' => '#d41315', 'code' => 'BCMAMAMC', 'id_code' => '007', 'logo' => 'banks/attijari_official.png'],
        ['name' => 'Banque Populaire', 'color' => '#f29200', 'code' => 'BCPOMAMC', 'id_code' => '021', 'logo' => 'banks/bp_official.png'],
        ['name' => 'Bank of Africa', 'color' => '#1b2c5b', 'code' => 'BMCEMAMC', 'id_code' => '011', 'logo' => 'banks/bmce_official.png'],
        ['name' => 'CIH Bank', 'color' => '#0054a6', 'code' => 'CIHMMAMC', 'id_code' => '230', 'logo' => 'banks/cih_official.png'],
        ['name' => 'Société Générale', 'color' => '#da291c', 'code' => 'SGMBMAMC', 'id_code' => '022', 'logo' => 'banks/sg_official.png'],
        ['name' => 'Crédit Agricole du Maroc', 'color' => '#00843d', 'code' => 'CNCAMAMR', 'id_code' => '050', 'logo' => 'banks/cam_official.png'],
        ['name' => 'Al Barid Bank', 'color' => '#7d6153', 'code' => 'ALBAMAMC', 'id_code' => '011', 'logo' => 'banks/albarid_official.png'],
        ['name' => 'Wafacash', 'color' => '#ffcc00', 'code' => 'WAFAMAMC', 'id_code' => '000', 'logo' => 'banks/wafacash_official.png'],
        ['name' => 'Crédit du Maroc', 'color' => '#005a3c', 'code' => 'CDMAMAMC', 'id_code' => '013', 'logo' => 'banks/cdm_official.png'],
        ['name' => 'BMCI', 'color' => '#00a651', 'code' => 'BMCIMAMC', 'id_code' => '013', 'logo' => 'banks/bmci_official.png'],
        ['name' => 'CFG Bank', 'color' => '#1e1b4b', 'code' => 'CAFGMAMC', 'id_code' => '130', 'logo' => 'banks/cfg_official.png'],
    ];

    public function index()
    {
        $bankAccounts = BankAccount::withCount('chequeBooks')->get();
        $chequeBooks = ChequeBook::with('bankAccount')->get();
        $banks = self::$banks;
        return view('treasury.index', compact('bankAccounts', 'chequeBooks', 'banks'));
    }

    public function destroyAccount(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->back()->with('success', 'Compte supprimé.');
    }

    public function destroyChequeBook(ChequeBook $chequeBook)
    {
        $chequeBook->delete();
        return redirect()->back()->with('success', 'Carnet supprimé.');
    }

    public function storeAccount(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency' => 'nullable|string',
            'rib' => 'required|string|size:24',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('bank_logos', 'public');
            $data['logo_path'] = $path;
        }

        BankAccount::create($data);
        return redirect()->back()->with('success', 'Compte bancaire ajouté.');
    }

    public function storeChequeBook(Request $request)
    {
        $data = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer|gt:start_number',
        ]);

        $data['current_number'] = $data['start_number'];
        ChequeBook::create($data);
        return redirect()->back()->with('success', 'Carnet de chèques ajouté.');
    }
}
