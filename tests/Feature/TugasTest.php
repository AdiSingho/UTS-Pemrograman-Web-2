<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TugasTest extends TestCase
{
    // Membersihkan database setiap kali ditest 
    use RefreshDatabase; 

    public function test_user_bisa_membuat_tugas_baru(): void
    {
        // 1. Persiapan data tugas
        $data = [
            'deskripsi' => 'Belajar TDD Laravel',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ];

        // 2. Aksi: Kirim data POST ke route '/tugas'
        $response = $this->post('/tugas', $data);

        // 3. Cek: Pastikan data masuk ke tabel 'tugas'
        $this->assertDatabaseHas('tugas', [
            'deskripsi' => 'Belajar TDD Laravel',
        ]);
    }
    // --- Fitur Melihat Daftar Tugas ---
    public function test_user_bisa_melihat_daftar_tugas(): void
    {
        // 1. Persiapan: Buat satu data tugas langsung ke database
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Mengerjakan fitur lihat tugas',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        // 2. Aksi: User membuka rute GET '/tugas'
        $response = $this->get('/tugas');

        // 3. Cek: Pastikan status halaman 200 (sukses) dan deskripsi tugas terlihat di halaman
        $response->assertStatus(200);
        $response->assertSee('Mengerjakan fitur lihat tugas');
    }

    // --- Fitur Menghapus Tugas yang Belum Selesai ---
    public function test_user_bisa_menghapus_tugas_belum_selesai(): void
    {
        // 1. Persiapan: Buat satu data tugas yang statusnya BELUM selesai (false)
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Tugas yang akan dihapus',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        // 2. Aksi: Kirim perintah DELETE ke URL spesifik tugas tersebut
        $response = $this->delete('/tugas/' . $tugas->id);

        // 3. Cek: Pastikan data tersebut sudah hilang (missing) dari database
        $this->assertDatabaseMissing('tugas', [
            'id' => $tugas->id,
        ]);
    }

    // --- Fitur Menandai Tugas Selesai ---
    public function test_user_bisa_menandai_tugas_selesai(): void
    {
        // 1. Persiapan: Buat tugas yang BELUM selesai
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Belajar Selesai',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        // 2. Aksi: Kirim perintah PUT ke rute 'selesai'
        $this->put('/tugas/' . $tugas->id . '/selesai');

        // 3. Cek: Pastikan di database statusnya jadi 1 (true)
        $this->assertDatabaseHas('tugas', [
            'id' => $tugas->id,
            'is_selesai' => true,
        ]);
    }

    // --- Edit Tugas yang Belum Selesai ---
    public function test_user_bisa_mengedit_tugas_yang_belum_selesai(): void
    {
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Tugas awal',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        $this->put('/tugas/' . $tugas->id, [
            'deskripsi' => 'Tugas sudah diubah',
            'tanggal_target' => '2026-06-21',
        ]);

        $this->assertDatabaseHas('tugas', [
            'id' => $tugas->id,
            'deskripsi' => 'Tugas sudah diubah',
        ]);
    }

    // --- Laporan Tugas Harian ---
    public function test_user_bisa_melihat_laporan_tugas_harian(): void
    {
        // 1. Persiapan: Buat data tugas
        \App\Models\Tugas::create(['deskripsi' => 'Tugas 1', 'tanggal_target' => '2026-06-20', 'is_selesai' => true]);
        \App\Models\Tugas::create(['deskripsi' => 'Tugas 2', 'tanggal_target' => '2026-06-20', 'is_selesai' => false]);

        // 2. Aksi: Buka rute laporan
        $response = $this->get('/tugas/laporan/2026-06-20');

        // 3. Cek: Pastikan tampil angka 1 untuk selesai dan 1 untuk belum
        $response->assertStatus(200);
        $response->assertSee('Selesai: 1');
        $response->assertSee('Belum Selesai: 1');
    }
}