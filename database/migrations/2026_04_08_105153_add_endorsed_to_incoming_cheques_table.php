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
        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->unsignedBigInteger('endorsed_to_contact_id')->nullable()->after('remittance_id');
            $table->foreign('endorsed_to_contact_id')->references('id')->on('contacts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_cheques', function (Blueprint $table) {
            $table->dropForeign(['endorsed_to_contact_id']);
            $table->dropColumn('endorsed_to_contact_id');
        });
    }
};
