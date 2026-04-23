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
    Schema::create('sensor_data', function (Blueprint $table) {
        $table->id();
        $table->float('water_level'); // Data JSN-SR04T [cite: 235]
        $table->string('rain_status'); // Data Raindrop [cite: 235]
        $table->float('water_flow'); // Data Waterflow [cite: 235]
        $table->string('status'); // Aman, Siaga, Bahaya [cite: 120]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
