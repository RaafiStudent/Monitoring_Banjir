<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensor_data', function (Blueprint $table) {
            // Menambahkan 2 kolom baru setelah kolom status
            $table->float('rain_value')->default(0)->after('status'); 
            $table->string('rain_status')->default('CERAH')->after('rain_value');
        });
    }

    public function down(): void
    {
        Schema::table('sensor_data', function (Blueprint $table) {
            $table->dropColumn(['rain_value', 'rain_status']);
        });
    }
};