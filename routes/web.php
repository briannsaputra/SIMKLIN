<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliController;
use App\Models\JadwalDokter;
use App\Models\Kunjungan;
use App\Models\Pasien;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/dokter/home', [DokterController::class, 'index'])->name('dokter.home');
Route::post('/dokter/store', [DokterController::class, 'store'])->name('dokter.store');
Route::put('/dokter/update/{dokter}', [DokterController::class, 'update'])->name('dokter.update');
Route::delete('/dokter/{dokter}', [DokterController::class, 'destroy'])->name('dokter.destroy');

Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
Route::post('/antrian/take', [AntrianController::class, 'takeTicket'])->name('antrian.take');
Route::post('/antrian/call-next', [AntrianController::class, 'callNext'])->name('antrian.call-next');
Route::post('/antrian/{ticket}/finish', [AntrianController::class,'finishTicket'])->name('antrian.finish');
Route::get('/antrian/admin', [AntrianController::class, 'adminPage'])
    ->name('admin.antrian');

Route::get('/pendaftaran/pasien', [PasienController::class, 'index'])->name('pasien.home');
Route::post('/pendaftaran/pasien/store', [PasienController::class, 'store'])->name('pasien.store');
Route::put('/pendaftaran/pasien/update/{pasien}', [PasienController::class, 'update'])->name('pasien.update');
Route::delete('/pendaftaran/pasien/destroy/{pasien}', [PasienController::class, 'destroy'])->name('pasien.destroy');
Route::get('/pendaftaran/pasien/show/{pasien}', [PasienController::class, 'show'])->name('pasien.show');

Route::get('/pendaftaran/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.home');
Route::post('/pendaftaran/kunjungan/store', [KunjunganController::class, 'store'])->name('kunjungan.store');
Route::put('/pendaftaran/kunjungan/update/{kunjungan}', [KunjunganController::class, 'update'])->name('kunjungan.update');
Route::delete('/pendaftaran/kunjungan/destroy/{kunjungan}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');
Route::get('/pendaftaran/kunjungan/show/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');

Route::get('/dokter/poli', [PoliController::class, 'index'])->name('poli.home');
Route::post('/dokter/poli/store', [PoliController::class, 'store'])->name('poli.store');
Route::put('/dokter/poli/update/{poli}', [PoliController::class, 'update'])->name('poli.update');
Route::delete('/dokter/poli/delete/{poli}', [PoliController::class, 'destroy'])->name('poli.destroy');

Route::get('/dokter/jadwal', [JadwalDokterController::class, 'index'])->name('jadwal.home');
Route::post('/dokter/jadwal/store', [JadwalDokterController::class, 'store'])->name('jadwal.store');
Route::put('/dokter/jadwal/update/{jadwaldokter}', [JadwalDokterController::class, 'update'])->name('jadwal.update');
Route::delete('/dokter/jadwal/destroy/{jadwalDokter}', [JadwalDokterController::class, 'destroy'])->name('jadwaldokter.destroy');
Route::get('/dokter/jadwal/show/{jadwalDokter}', [JadwalDokterController::class, 'show'])->name('jadwal.show');

Route::get('/boking', [BookingController::class, 'index'])->name('boking.home');