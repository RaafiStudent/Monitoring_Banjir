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
        'rain_status',
        'water_flow',
        'status'
    ];
}