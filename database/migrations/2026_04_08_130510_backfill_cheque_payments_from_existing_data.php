<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all endorsed cheques that have a linked invoice
        $endorsedCheques = DB::table('incoming_cheques')
            ->where('status', 'endorsed')
            ->whereNotNull('invoice_id')
            ->get();

        foreach ($endorsedCheques as $cheque) {
            // Check if a payment record already exists to avoid duplicates
            $exists = DB::table('cheque_payments')
                ->where('incoming_cheque_id', $cheque->id)
                ->where('invoice_id', $cheque->invoice_id)
                ->exists();

            if (!$exists) {
                // We assume the whole amount was used for this invoice if it's an old record
                // (or at least calculate based on invoice amount if possible, but amount is safer)
                DB::table('cheque_payments')->insert([
                    'incoming_cheque_id' => $cheque->id,
                    'invoice_id'         => $cheque->invoice_id,
                    'amount'             => $cheque->amount, // Use total amount for legacy data
                    'created_at'         => $cheque->updated_at,
                    'updated_at'         => $cheque->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed for data backfill
    }
};
