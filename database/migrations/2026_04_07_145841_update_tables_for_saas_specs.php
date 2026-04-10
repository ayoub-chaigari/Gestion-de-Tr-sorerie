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
        Schema::table('users', function (Blueprint $table) {
            $table->json('permissions')->nullable()->after('role');
        });

        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->boolean('is_effect')->default(false)->after('cheque_number');
            $table->foreignId('remittance_id')->nullable()->after('bank_account_id')->constrained()->onDelete('set null');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('paid_amount', 15, 2)->default(0)->after('amount');
            $table->string('reference')->nullable()->after('paid_amount');
        });
        
        Schema::table('companies', function (Blueprint $table) {
            $table->timestamp('registration_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) { $table->dropColumn('permissions'); });
        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->dropForeign(['remittance_id']);
            $table->dropColumn(['is_effect', 'remittance_id']);
        });
        Schema::table('invoices', function (Blueprint $table) { $table->dropColumn(['paid_amount', 'reference']); });
        Schema::table('companies', function (Blueprint $table) { $table->dropColumn('registration_date'); });
    }
};
