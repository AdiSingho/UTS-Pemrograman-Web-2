<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\TugasController;

Route::post('/tugas', [TugasController::class, 'store']);