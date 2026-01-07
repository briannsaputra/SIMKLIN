<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $jadwalDokters = JadwalDokter::with('dokter')->get();
        $dokterList = Dokter::select('id', 'nama_dokter', 'no_hp')->orderBy('nama_dokter')->get();

        return Inertia::render('Jadwal/jadwal-home', [
            'jadwalDokters' => $jadwalDokters,
            'dokterList' => $dokterList
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'hari'        => 'required|string',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'kuota'       => 'required|integer|min:1',
            'aktif'       => 'required|boolean',
        ]);

        // Cek apakah dokter sudah punya jadwal di hari tersebut
        $exists = JadwalDokter::where('dokter_id', $validated['dokter_id'])
            ->where('hari', $validated['hari'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'hari' => 'Dokter sudah memiliki jadwal pada hari ini.'
            ]);
        }

        JadwalDokter::create($validated);

        return back()->with('success', 'Jadwal dokter berhasil ditambahkan.');
    }

    public function update(Request $request, JadwalDokter $jadwaldokter)
    {
        $validated = $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'hari'        => 'required|string',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'kuota'       => 'required|integer|min:1',
            'aktif'       => 'required|boolean',
        ]);

        // Cek duplikasi hari (KECUALI data yang sedang diedit)
        $exists = JadwalDokter::where('dokter_id', $validated['dokter_id'])
            ->where('hari', $validated['hari'])
            ->where('id', '!=', $jadwaldokter->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'hari' => 'Dokter sudah memiliki jadwal pada hari ini.'
            ]);
        }

        $jadwaldokter->update($validated);

        return back()->with('success', 'Jadwal dokter berhasil diperbarui.');
    }
}
