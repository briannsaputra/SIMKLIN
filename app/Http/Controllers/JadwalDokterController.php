<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwalDokters = JadwalDokter::with('dokter')->get();

        return Inertia::render('Jadwal/jadwal-home', [
            'jadwalDokters' => $jadwalDokters
        ]);
    }
}
