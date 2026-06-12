<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tugas; // Modelnya

class TugasSeeder extends Seeder
{
    public function run(): void
    {
        Tugas::create([
            'deskripsi' => 'Belajar TDD Laravel',
            'tanggal_target' => '2026-06-20',
            'is_selesai' => false,
        ]);

        Tugas::create([
            'deskripsi' => 'Mengerjakan UTS Pemrograman Web',
            'tanggal_target' => '2026-06-21',
            'is_selesai' => true,
        ]);
    }
}