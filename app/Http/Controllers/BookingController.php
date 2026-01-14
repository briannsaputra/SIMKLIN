<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Booking;
use App\Models\Dokter;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bokings = Booking::with('dokter')->select('id', 'nama_pemboking', 'dokter_id', 'tanggal_booking', 'kode_booking', 'status', 'keluhan')->orderBy('nama_pemboking')->get();

        $dokterList = Dokter::select(['id', 'nama_dokter'])->get();

        return Inertia::render('Booking/boking-home', [
            'bokings' => $bokings,
            'dokterList' => $dokterList,
        ]);
    }
}
