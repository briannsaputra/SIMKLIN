<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();

        return Inertia::render('Poli/poli-home', [
            'polis' => $polis
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_poli'           => 'required|string|max:255',
        ]);
        try {
            Poli::create([
                'nama_poli'           => $request->nama_poli,
            ]);
            return to_route('poli.home')->with('success', 'Data Poli Dokter Behasil Di Tambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Poli $poli)
    {
        try {
            $validated = $request->validate([
                'nama_poli'           => 'required|string|max:255',
            ]);

            $poli->update($validated);

            return back()->with('success', 'Data Poli Dokter berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()
            ->back()
            ->with('success', 'Data Poli Dokter berhasil dihapus.');
    }
}
