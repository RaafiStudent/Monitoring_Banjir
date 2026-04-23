<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Tambahkan baris di bawah ini:
    protected $fillable = [
        'water_level',
        'rain_status',
        'water_flow',
        'status'
    ];
}