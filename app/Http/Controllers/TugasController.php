<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas; // Panggil modelnya ke sini

class TugasController extends Controller
{
    // Fungsi untuk memproses penyimpanan
    public function store(Request $request)
    {
        Tugas::create($request->all()); // Simpan semua data yang dikirim
        return response('Sukses', 201);
    }
}
