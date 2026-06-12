<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas; // Panggil modelnya ke sini

class TugasController extends Controller
{
    public function index()
    {
        $daftarTugas = Tugas::all(); // Mengambil semua data tugas
        return view('tugas.index', compact('daftarTugas')); // Mengirim data ke halaman HTML
    }
    
    // Fungsi untuk memproses penyimpanan
    public function store(Request $request)
    {
        Tugas::create($request->all()); // Simpan semua data yang dikirim
        return response('Sukses', 201);
    }
}
