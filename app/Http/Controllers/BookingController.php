<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Dokter;
use App\Models\Booking;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bokings = Booking::with(['dokter:id,nama_dokter', 'pasien:id,nama,nik'])->select('id', 'pasien_id', 'dokter_id', 'tanggal_booking', 'kode_booking', 'status', 'keluhan')->get();

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
            ->select('id','nama_dokter')
            ->get();

            $pasienList = Pasien::select('id','no_rm', 'nama',)->orderBy('nama')->get();

        return Inertia::render('Booking/boking-home', [
            'bokings' => $bokings,
            'dokterList' => $dokterList,
            'pasienList' => $pasienList,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id' => ['required', 'exists:dokters,id'],
            'pasien_id' => ['required', 'exists:pasien,id'],
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
                'dokter_id' => $validated['dokter_id'],
                'pasien_id' => $validated['pasien_id'],
                'jadwal_dokter_id' => $validated['jadwal_dokter_id'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'kode_booking' => 'BK-' . now()->format('Ymd') . '-' . rand(1000, 9999),
                'keluhan' => $validated['keluhan'],
            ]);

            $jadwal->decrement('kuota');
        });

        return back()->with('success', 'Booking anda berhasil ditambahkan.');
    }

    public function show(Booking $boking)
    {
        $boking->load([
            'dokter:id,nama_dokter,image,poli_id',
            'jadwalDokter:id,dokter_id,hari,jam_mulai,jam_selesai,kuota,aktif'
        ]);

        return Inertia::render('Booking/boking-detail', [
            'boking' => $boking,
        ]);
    }
}
