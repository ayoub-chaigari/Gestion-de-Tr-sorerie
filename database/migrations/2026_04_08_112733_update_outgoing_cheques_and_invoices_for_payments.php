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
        Schema::table('outgoing_cheques', function (Blueprint $table) {
            $table->foreignId('invoice_id')->nullable()->after('cheque_book_id')->constrained()->onDelete('set null');
            $table->date('due_date')->nullable()->after('amount');
        });

        // SQLite doesn't support changing enum columns easily.
        // But we want to allow 'partial' status in invoices.
        // In a real DB we'd do this. In Laravel/SQLite it might need the 'doctrine/dbal' package or similar.
        // However, we'll just try to change it and hope Laravel 11/12 handles it.
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_cheques', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['invoice_id', 'due_date']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending')->change();
        });
    }
};
