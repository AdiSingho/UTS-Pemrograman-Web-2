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
        $data = [
            'deskripsi' => 'Belajar TDD Laravel',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ];

        $response = $this->post('/tugas', $data);

        // Mengecek apakah diredirect kembali ke halaman utama
        $response->assertRedirect('/tugas');

        $this->assertDatabaseHas('tugas', [
            'deskripsi' => 'Belajar TDD Laravel',
        ]);
    }

    // --- Fitur Melihat Daftar Tugas ---
    public function test_user_bisa_melihat_daftar_tugas(): void
    {
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Mengerjakan fitur lihat tugas',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        $response = $this->get('/tugas');

        
        $response->assertStatus(200);
        $response->assertSee('Mengerjakan fitur lihat tugas');
    }

    // --- Fitur Menghapus Tugas yang Belum Selesai ---
    public function test_user_bisa_menghapus_tugas_belum_selesai(): void
    {
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Tugas yang akan dihapus',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        $response = $this->delete('/tugas/' . $tugas->id);

        // Mengecek apakah diredirect setelah menghapus
        $response->assertRedirect('/tugas');

        $this->assertDatabaseMissing('tugas', [
            'id' => $tugas->id,
        ]);
    }

    // --- Fitur Menandai Tugas Selesai ---
    public function test_user_bisa_menandai_tugas_selesai(): void
    {
        $tugas = \App\Models\Tugas::create([
            'deskripsi' => 'Belajar Selesai',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        // Tangkap response-nya ke dalam variabel
        $response = $this->put('/tugas/' . $tugas->id . '/selesai');

        // Mengecek apakah diredirect setelah selesai
        $response->assertRedirect('/tugas');

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

        // Tangkap response-nya ke dalam variabel
        $response = $this->put('/tugas/' . $tugas->id, [
            'deskripsi' => 'Tugas sudah diubah',
            'tanggal_target' => '2026-06-21',
        ]);

        // Mengecek apakah diredirect setelah mengedit
        $response->assertRedirect('/tugas');

        $this->assertDatabaseHas('tugas', [
            'id' => $tugas->id,
            'deskripsi' => 'Tugas sudah diubah',
        ]);
    }

    // --- Laporan Tugas Harian ---
    public function test_user_bisa_melihat_laporan_tugas_harian(): void
    {
        \App\Models\Tugas::create(['deskripsi' => 'Tugas 1', 'tanggal_target' => '2026-06-20', 'is_selesai' => true]);
        \App\Models\Tugas::create(['deskripsi' => 'Tugas 2', 'tanggal_target' => '2026-06-20', 'is_selesai' => false]);

        $response = $this->get('/tugas/laporan/2026-06-20');

        
        $response->assertStatus(200);
        $response->assertSee('Selesai: 1');
        $response->assertSee('Belum Selesai: 1');
    }
}