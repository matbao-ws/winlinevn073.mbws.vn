<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_comparison_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->json('columns');
            $table->boolean('show_price')->default(true);
            $table->boolean('show_action_btn')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('model_comparison_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('model_comparison_tables')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('model_name');
            $table->json('specs')->nullable();
            $table->decimal('custom_price', 15, 2)->nullable();
            $table->string('custom_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['table_id', 'sort_order']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('model_comparison_table_id')->nullable()->constrained('model_comparison_tables')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['model_comparison_table_id']);
            $table->dropColumn('model_comparison_table_id');
        });

        Schema::dropIfExists('model_comparison_items');
        Schema::dropIfExists('model_comparison_tables');
    }
};
