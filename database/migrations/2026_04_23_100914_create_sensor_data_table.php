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
        $table->float('water_level'); // Data sensor JSN-SR04T [cite: 221]
        $table->string('rain_status'); // Data sensor hujan [cite: 222]
        $table->float('water_flow');  // Data sensor waterflow [cite: 223]
        $table->string('status');      // Aman, Siaga, Bahaya [cite: 449]
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
