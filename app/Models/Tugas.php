<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar data bisa disimpan:
    protected $fillable = [
        'deskripsi',
        'tanggal_target',
        'is_selesai',
        'tanggal_selesai'
    ];
}
