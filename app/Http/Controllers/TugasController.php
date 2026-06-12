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
        return redirect('/tugas');
    }

    // Fungsi untuk menghapus tugas
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id); // Cari tugas berdasarkan ID-nya
        
        // Cek syarat soal: hanya hapus jika belum selesai (false)
        if ($tugas->is_selesai == false) {
            $tugas->delete();
        }
        
        return redirect('/tugas'); // Kembalikan user ke halaman daftar tugas
    }

    // Fungsi untuk menandai selesai
    public function selesai($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->update(['is_selesai' => true]);
        return redirect('/tugas');
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        
        // Cek syarat: hanya bisa edit jika belum selesai
        if ($tugas->is_selesai == false) {
            $tugas->update([
                'deskripsi' => $request->deskripsi,
                'tanggal_target' => $request->tanggal_target,
            ]);
        }
        
        return redirect('/tugas');
    }

    public function laporan($tanggal)
    {
        $selesai = Tugas::where('tanggal_target', $tanggal)->where('is_selesai', true)->count();
        $belum = Tugas::where('tanggal_target', $tanggal)->where('is_selesai', false)->count();
        
        return "Selesai: $selesai, Belum Selesai: $belum";
    }
}
