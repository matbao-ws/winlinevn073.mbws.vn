<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fan_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('public_id', 32)->unique();
            $table->string('tab', 50)->default('thong-gio-hut-khi');
            $table->string('title')->nullable();
            $table->json('inputs');
            $table->json('results');
            $table->json('selected_items');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 50)->nullable();
            $table->string('customer_email')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->string('project_address')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('draft');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('public_id');
            $table->index('customer_phone');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fan_calculations');
    }
};
