<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Threshold extends Model
{
    use HasFactory;
    // Tambahkan batas_waspada
    protected $fillable = ['batas_waspada', 'batas_siaga', 'batas_bahaya'];
}