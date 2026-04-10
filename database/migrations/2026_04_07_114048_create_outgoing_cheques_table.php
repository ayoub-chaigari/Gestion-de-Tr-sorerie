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
        Schema::create('outgoing_cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('cheque_book_id')->constrained()->onDelete('cascade');
            $table->string('cheque_number');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'paid', 'unpaid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_cheques');
    }
};
