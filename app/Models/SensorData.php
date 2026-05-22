<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Ini adalah kunci agar tidak error MassAssignmentException
    protected $fillable = [
        'water_level',
        'rain_value',  // DITAMBAHKAN: Untuk menyimpan angka curah hujan
        'rain_status', // DITAMBAHKAN: Untuk menyimpan teks status hujan
        'water_flow',
        'status'
    ];
}