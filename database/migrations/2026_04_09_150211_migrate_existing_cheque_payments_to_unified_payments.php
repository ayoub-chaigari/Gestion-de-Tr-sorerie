<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $existingPayments = DB::table('cheque_payments')->get();

        foreach ($existingPayments as $p) {
            DB::table('invoice_payments')->insert([
                'invoice_id' => $p->invoice_id,
                'method' => 'cheque',
                'amount' => $p->amount,
                'payment_date' => $p->created_at ?? now(),
                'payable_id' => $p->incoming_cheque_id,
                'payable_type' => 'App\Models\IncomingCheque',
                'created_at' => $p->created_at ?? now(),
                'updated_at' => $p->updated_at ?? now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('invoice_payments')->where('method', 'cheque')->delete();
    }
};
