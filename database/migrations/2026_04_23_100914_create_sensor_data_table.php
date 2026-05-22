<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('water_level'); // Level air (cm)
            
            // --- DUA KOLOM INI ADALAH KUNCI FITUR INTENSITAS HUJAN ---
            $table->float('rain_value')->default(0); // Angka curah hujan (mm/jam)
            $table->string('rain_status')->nullable(); // Teks Hujan/Cerah
            
            $table->float('water_flow')->nullable();  // Kecepatan aliran
            $table->string('status'); // AMAN, SIAGA, BAHAYA
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};