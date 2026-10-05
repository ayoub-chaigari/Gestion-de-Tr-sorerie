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
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('gender')->nullable()->after('last_name');
            $table->string('phone_number')->nullable()->after('gender');
            $table->date('date_of_birth')->nullable()->after('phone_number');
            $table->text('address')->nullable()->after('date_of_birth');
            $table->string('location')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('location');
            $table->string('profile_picture')->nullable()->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'gender',
                'phone_number',
                'date_of_birth',
                'address',
                'location',
                'postal_code',
                'profile_picture',
            ]);
        });
    }
};
