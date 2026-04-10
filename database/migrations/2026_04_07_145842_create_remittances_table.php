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
        Schema::create('remittances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('bank_account_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['cheque', 'effect']);
            $table->date('remittance_date');
            $table->decimal('total_amount', 15, 2);
            $table->string('reference')->unique();
            $table->enum('status', ['pending', 'sent', 'cleared'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remittances');
    }
};
