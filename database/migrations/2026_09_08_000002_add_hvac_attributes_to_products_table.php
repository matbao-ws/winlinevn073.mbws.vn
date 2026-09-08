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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('airflow')->nullable()->index(); // m3/h
            $table->string('power')->nullable(); // W or kW
            $table->string('voltage')->nullable(); // 220V, 380V, 220V/380V
            $table->string('size_display')->nullable(); // 1380x1380x400 mm
            $table->string('hole_size')->nullable(); // 1380x1380 mm or 250x250 mm
            $table->string('fan_type')->nullable(); // Quạt thông gió vuông, ly tâm, gắn tường, âm trần...
            $table->boolean('use_ventilation')->default(true);
            $table->boolean('use_cooling_pad')->default(false);
            $table->boolean('is_cooling_pad')->default(false);
            $table->decimal('pad_area', 6, 2)->nullable(); // m2
            $table->unsignedInteger('pad_thickness')->nullable()->default(150); // mm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'airflow',
                'power',
                'voltage',
                'size_display',
                'hole_size',
                'fan_type',
                'use_ventilation',
                'use_cooling_pad',
                'is_cooling_pad',
                'pad_area',
                'pad_thickness',
            ]);
        });
    }
};
