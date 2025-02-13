<?php

use App\Livewire\Beranda;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', Beranda::class)->name('beranda.index');
Route::get('/pendaftaran', Register::class)->name('pendaftaran.index');