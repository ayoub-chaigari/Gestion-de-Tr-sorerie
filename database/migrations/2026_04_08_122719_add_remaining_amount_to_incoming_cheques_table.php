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
        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->decimal('remaining_amount', 15, 2)->nullable()->after('amount');
        });

        // Initialize remaining_amount for existing cheques
        DB::table('incoming_cheques')->update([
            'remaining_amount' => DB::raw('amount')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->dropColumn('remaining_amount');
        });
    }
};
