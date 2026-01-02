<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('poli')->get()->map(function ($dokters) {
            $dokters->image_url = $dokters->image ? asset('storage/' . $dokters->image) : null;
            return $dokters;
        });

        $poliList = Poli::select('id', 'nama_poli')->orderBy('nama_poli')->get();

        return Inertia::render('Dokter/dokter-home', [
            'dokters' => $dokters,
            'poliList' => $poliList,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_hp' => 'required',
            'poli_id' => 'required|exists:polis,id',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            }

            Dokter::create([
                'nama_dokter' => $request->nama_dokter,
                'image' => $imagePath,
                'no_hp' => $request->no_hp,
                'poli_id' => $request->poli_id,
            ]);

            return to_route('dokter.home')->with('success', 'Data Dokter Behasil Di Tambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'no_hp' => 'required|string|max:15',
            'poli_id' => 'required|exists:polis,id',
        ]);

        $dataToUpdate = $request->only(['nama_dokter', 'spesialis', 'no_hp', 'poli_id']);

        if ($request->hasFile('image')) {

            if ($dokter->image && Storage::disk('public')->exists($dokter->image)) {
                Storage::disk('public')->delete($dokter->image);
            }

            $dataToUpdate['image'] = $request->file('image')->store('images', 'public');
        }

        $dokter->update($dataToUpdate);

        return back()->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Dokter $dokter)
    {
        if ($dokter->image && Storage::exists($dokter->image)) {
            Storage::delete($dokter->image);
        }

        $dokter->delete();

        return redirect()
            ->back()
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}
