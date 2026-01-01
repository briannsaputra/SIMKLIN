<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $pasiens = Pasien::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%')
                    ->orWhere('telepon', 'like', '%' . $request->search . '%');
            })
            ->get();

        return Inertia::render('Pasien/pasien-home', [
            'pasiens' => $pasiens,
            'search' => $request->search
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'nik'            => 'nullable|digits:16',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat'         => 'nullable|string|max:255',
            'telepon'        => 'nullable|string|max:20',
            'status_bpjs'    => 'nullable|string|max:50',
            'alergi'         => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
        ]);

        try {
            Pasien::create([
                'nama'           => $request->nama,
                'nik'            => $request->nik,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'alamat'         => $request->alamat,
                'telepon'        => $request->telepon,
                'status_bpjs'    => $request->status_bpjs,
                'alergi'         => $request->alergi,
                'catatan'        => $request->catatan,
            ]);
            return to_route('pasien.home')->with('success', 'Data Pasien Behasil Di Tambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Pasien $pasien)
    {
        try {
            $validated = $request->validate([
                'nama'           => 'required|string|max:255',
                'nik'            => 'nullable|digits:16',
                'tanggal_lahir'  => 'nullable|date',
                'jenis_kelamin'  => 'nullable|in:L,P',
                'alamat'         => 'nullable|string|max:255',
                'telepon'        => 'nullable|string|max:20',
                'status_bpjs'    => 'nullable|string|max:50',
                'alergi'         => 'nullable|string|max:255',
                'catatan'        => 'nullable|string',
            ]);

            $pasien->update($validated);

            return back()->with('success', 'Data pasien berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()
            ->back()
            ->with('success', 'Data Pasien berhasil dihapus.');
    }

    public function show(Pasien $pasien)
    {
        return Inertia::render('Pasien/pasien-detail', [
            'pasien' => $pasien,
        ]);
    }
}
