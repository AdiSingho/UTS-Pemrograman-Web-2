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
}