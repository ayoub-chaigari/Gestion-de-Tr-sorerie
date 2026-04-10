<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Platform SuperAdmin (Global control, NO company)
        User::create([
            'name' => 'Platform Super Admin',
            'email' => 'superadmin@treasury.local',
            'password' => Hash::make('password'),
            'role' => 'SUPER_ADMIN',
            'company_id' => null,
            'permissions' => []
        ]);

        // 2. Test Company
        $company = Company::create([
            'name' => 'ENTREPRISE DE TEST SARL',
            'status' => 'active',
        ]);

        // 3. Company Admin
        User::create([
            'company_id' => $company->id,
            'name' => 'Ayoub Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'permissions' => []
        ]);

        // 4. Test Contacts
        $client = \App\Models\Contact::create([
            'company_id' => $company->id,
            'type' => 'client',
            'name' => 'Client Marocain SARL',
            'ice' => '123456789012345',
            'rc' => '12345',
            'phone' => '0600000000',
        ]);

        $supplier = \App\Models\Contact::create([
            'company_id' => $company->id,
            'type' => 'supplier',
            'name' => 'Fournisseur Global SA',
            'ice' => '987654321098765',
            'rc' => '54321',
            'phone' => '0500000000',
        ]);

        // 5. Test Bank & ChequeBook
        $bank = \App\Models\BankAccount::create([
            'company_id' => $company->id,
            'bank_name' => 'Attijariwafa Bank',
            'rib' => '007123456789012345678901',
            'agency' => 'Agence Casablanca Anfa'
        ]);

        \App\Models\ChequeBook::create([
            'company_id' => $company->id,
            'bank_account_id' => $bank->id,
            'start_number' => 1001,
            'end_number' => 1050,
            'current_number' => 1001
        ]);

        // 6. Initial Cheques
        \App\Models\IncomingCheque::create([
            'company_id' => $company->id,
            'contact_id' => $client->id,
            'amount' => 15000.00,
            'cheque_number' => 'CHQ-2024-001',
            'status' => 'pending',
            'due_date' => now()->addDays(30),
            'is_effect' => false
        ]);
    }
}
