<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@treasury.local'],
            [
                'name' => 'Super Admin Platform',
                'password' => Hash::make('password'),
                'role' => 'SUPER_ADMIN',
                'company_id' => null, // No specific company
                'permissions' => []
            ]
        );
    }
}
