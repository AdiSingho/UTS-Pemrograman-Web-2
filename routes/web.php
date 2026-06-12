<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\TugasController;

Route::post('/tugas', [TugasController::class, 'store']);

Route::get('/tugas', [TugasController::class, 'index']);

Route::delete('/tugas/{id}', [TugasController::class, 'destroy']);

Route::put('/tugas/{id}/selesai', [TugasController::class, 'selesai']);

Route::put('/tugas/{id}', [TugasController::class, 'update']);