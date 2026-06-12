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
}