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
        Schema::create('incoming_cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('cheque_number');
            $table->enum('status', ['pending', 'deposited', 'paid', 'unpaid', 'endorsed'])->default('pending');
            $table->date('due_date');
            $table->foreignId('bank_account_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_cheques');
    }
};
