<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Dokter;
use App\Models\Booking;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bokings = Booking::with('dokter')->select('id', 'nama_pemboking', 'dokter_id', 'tanggal_booking', 'kode_booking', 'status', 'keluhan')->orderBy('nama_pemboking')->get();

        $dokterList = Dokter::with(['jadwal' => function ($query) {
            $query->where('aktif', true)
                ->select(
                    'id',
                    'dokter_id',
                    'hari',
                    'jam_mulai',
                    'jam_selesai',
                    'kuota'
                );
        }])
            ->select('id', 'nama_dokter')
            ->get();

        return Inertia::render('Booking/boking-home', [
            'bokings' => $bokings,
            'dokterList' => $dokterList,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemboking' => ['required', 'string', 'max:100'],
            'dokter_id' => ['required', 'exists:dokters,id'],
            'jadwal_dokter_id' => ['required', 'exists:jadwal_dokter,id'],
            'tanggal_booking' => ['required', 'date', 'after_or_equal:today'],
            'keluhan' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($validated) {

            $jadwal = JadwalDokter::where('id', $validated['jadwal_dokter_id'])
                ->where('dokter_id', $validated['dokter_id'])
                ->where('aktif', true)
                ->lockForUpdate()
                ->firstOrFail();

            if ($jadwal->kuota <= 0) {
                abort(422, 'Kuota jadwal dokter sudah penuh');
            }

            Booking::create([
                'nama_pemboking' => $validated['nama_pemboking'],
                'dokter_id' => $validated['dokter_id'],
                'jadwal_dokter_id' => $validated['jadwal_dokter_id'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'kode_booking' => 'BK-' . now()->format('Ymd') . '-' . rand(1000, 9999),
                'keluhan' => $validated['keluhan'],
            ]);

            $jadwal->decrement('kuota');
        });

        return back()->with('success', 'Booking anda berhasil ditambahkan.');
    }
}
