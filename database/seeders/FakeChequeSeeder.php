<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomingCheque;
use App\Models\OutgoingCheque;
use App\Models\Invoice;
use App\Models\Contact;
use App\Models\Company;
use App\Models\ChequeBook;
use App\Models\BankAccount;
use Carbon\Carbon;

class FakeChequeSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();
        if (!$company) return;

        // Ensure we have a bank account
        $bank = BankAccount::firstOrCreate(
            ['company_id' => $company->id],
            ['bank_name' => 'BMCI', 'account_number' => '00123456789', 'balance' => 100000]
        );

        // Ensure we have a cheque book for outgoing cheques
        $chequeBook = ChequeBook::firstOrCreate(
            ['company_id' => $company->id, 'bank_account_id' => $bank->id],
            ['series_name' => 'Serie A', 'start_number' => '1000', 'end_number' => '1100', 'is_active' => true]
        );

        $clients = Contact::where('type', 'client')->pluck('id');
        $suppliers = Contact::where('type', 'supplier')->pluck('id');

        if ($clients->isEmpty()) {
            $c = Contact::create(['company_id' => $company->id, 'name' => 'Client TEST', 'type' => 'client', 'email' => 'client@test.com']);
            $clients = collect([$c->id]);
        }
        if ($suppliers->isEmpty()) {
            $s = Contact::create(['company_id' => $company->id, 'name' => 'Fournisseur TEST', 'type' => 'supplier', 'email' => 'sup@test.com']);
            $suppliers = collect([$s->id]);
        }

        // Generate 10 Incoming Cheques
        for ($i = 0; $i < 10; $i++) {
            $date = Carbon::now()->subMonths(rand(0, 5))->subDays(rand(1, 28));
            IncomingCheque::create([
                'company_id'       => $company->id,
                'contact_id'       => $clients->random(),
                'amount'           => rand(5000, 50000),
                'cheque_number'    => 'CHK-IN-' . rand(10000, 99999),
                'due_date'         => $date,
                'status'           => collect(['paid', 'deposited', 'pending'])->random(),
                'is_effect'        => rand(0, 1),
                'remaining_amount' => 0,
            ]);
        }

        // Generate 10 Outgoing Cheques
        for ($i = 0; $i < 10; $i++) {
            $date = Carbon::now()->subMonths(rand(0, 5))->subDays(rand(1, 28));
            $amount = rand(3000, 30000);

            $invoice = Invoice::create([
                'company_id'   => $company->id,
                'supplier_id'  => $suppliers->random(),
                'reference'    => 'INV-' . rand(100, 999),
                'amount'       => $amount,
                'paid_amount'  => $amount,
                'invoice_date' => $date,
                'due_date'     => $date,
                'status'       => 'paid',
            ]);

            OutgoingCheque::create([
                'company_id'     => $company->id,
                'contact_id'     => $suppliers->random(),
                'cheque_book_id' => $chequeBook->id,
                'invoice_id'     => $invoice->id,
                'cheque_number'  => 'CHK-OUT-' . rand(10000, 99999),
                'amount'         => $amount,
                'due_date'       => $date,
                'status'         => 'paid',
            ]);
        }
    }
}
