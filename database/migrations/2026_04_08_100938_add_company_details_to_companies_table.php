<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('ice', 15)->nullable()->after('name');
            $table->string('rc')->nullable()->after('ice');
            $table->string('email')->nullable()->after('rc');
            $table->string('phone')->nullable()->after('email');
            $table->string('city')->nullable()->after('phone');
            $table->string('address')->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['ice', 'rc', 'email', 'phone', 'city', 'address']);
        });
    }
};
