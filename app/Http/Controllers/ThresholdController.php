<?php

namespace App\Http\Controllers;

use App\Models\Threshold;
use Illuminate\Http\Request;

class ThresholdController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika belum ada, buat otomatis
        $threshold = Threshold::first() ?? Threshold::create([
            'batas_siaga' => 100, 
            'batas_bahaya' => 150
        ]);

        return view('admin.threshold', compact('threshold'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'batas_siaga' => 'required|numeric|min:1',
            'batas_bahaya' => 'required|numeric|gt:batas_siaga', // Harus lebih besar dari siaga
        ]);

        $threshold = Threshold::first();
        $threshold->update([
            'batas_siaga' => $request->batas_siaga,
            'batas_bahaya' => $request->batas_bahaya,
        ]);

        return redirect()->back()->with('success', 'Ambang batas peringatan berhasil diperbarui!');
    }
}