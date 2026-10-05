<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $blueprint->foreignId('user_id')->constrained()->onDelete('cascade');
            $blueprint->string('type'); // e.g., 'support', 'system', 'security'
            $blueprint->string('title');
            $blueprint->text('message');
            $blueprint->string('link')->nullable();
            $blueprint->boolean('is_read')->default(false);
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
