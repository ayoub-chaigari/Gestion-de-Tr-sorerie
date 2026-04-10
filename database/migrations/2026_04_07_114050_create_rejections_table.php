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
        Schema::create('rejections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('cheque_id'); // Can be incoming or outgoing
            $table->enum('type', ['incoming', 'outgoing']);
            $table->string('reason');
            $table->boolean('resolved')->default(false);
            $table->boolean('sent_to_litigation')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejections');
    }
};
