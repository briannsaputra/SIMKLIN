<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Inertia\Inertia;
use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $kunjungans = Kunjungan::with(['pasien', 'dokter.poli'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                })
                    ->orWhereHas('dokter', function ($q) use ($search) {
                        $q->where('nama_dokter', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $pasienList = Pasien::select('id', 'nama', 'nik')->orderBy('nama')->get();
        $dokterList = Dokter::select('id', 'nama_dokter', 'no_hp')->orderBy('nama_dokter')->get();

        return Inertia::render('Kunjungan/kunjungan-home', [
            'kunjungans' => $kunjungans,
            'pasienList' => $pasienList,
            'dokterList' => $dokterList,
            'filters' => [
                'search' => $search
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli' => 'required|string|max:100',
            'keluhan' => 'required|string|max:255',
            'dokter_id' => 'required|exists:dokters,id',
            'tensi' => 'nullable|string|max:20',
            'suhu' => 'nullable|string|max:10',
            'catatan' => 'nullable|string',
        ]);

        try {
            Kunjungan::create([
                'pasien_id'          => $request->pasien_id,
                'poli'               => $request->poli,
                'keluhan'            => $request->keluhan,
                'dokter_id'          => $request->dokter_id,
                'tensi'              => $request->tensi,
                'suhu'               => $request->suhu,
                'catatan'            => $request->catatan,
                'tanggal_kunjungan' => now(),
            ]);

            return to_route('kunjungan.home')
                ->with('success', 'Data kunjungan berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Gagal menyimpan data kunjungan'
                ]);
        }
    }

    public function update(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli' => 'required|string|max:100',
            'keluhan' => 'required|string|max:255',
            'dokter_id' => 'required|exists:dokters,id',
            'tensi' => 'nullable|string|max:20',
            'suhu' => 'nullable|string|max:10',
            'catatan' => 'nullable|string',
        ]);

        try {
            $kunjungan->update([
                'pasien_id' => $request->pasien_id,
                'poli' => $request->poli,
                'keluhan' => $request->keluhan,
                'dokter_id' => $request->dokter_id,
                'tensi' => $request->tensi,
                'suhu' => $request->suhu,
                'catatan' => $request->catatan,
                'tanggal_kunjungan' => now(),
            ]);

            return to_route('kunjungan.home')
                ->with('success', 'Data kunjungan berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Gagal memperbarui data kunjungan'
                ]);
        }
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();

        return redirect()
            ->back()
            ->with('success', 'Data Pasien berhasil dihapus.');
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'dokter.poli']);

        return Inertia::render('Kunjungan/kunjungan-detail', [
            'kunjungan' => $kunjungan,
        ]);
    }
}
