<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKK;
use Illuminate\Http\Request;

class KeluargaKKController extends Controller
{
    /**
     * Menampilkan semua data keluarga KK
     */
    public function index()
    {
        $data = KeluargaKK::all();
        return view('pages.keluargakk.index', compact('data'));
    }

    /**
     * Menampilkan form tambah data keluarga KK
     */
    public function create()
    {
        return view('pages.keluargakk.create');
    }

    /**
     * Menyimpan data baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kk_nomor' => 'required|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
        ]);

        KeluargaKK::create($validated);

        return redirect()->route('keluargakk.index')
            ->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit data keluarga KK
     */
    public function edit($id)
    {
        $keluarga = KeluargaKK::findOrFail($id);
        return view('pages.keluargakk.edit', compact('keluarga'));
    }

    /**
     * Menyimpan perubahan data
     */
    public function update(Request $request, $id)
    {
        $keluarga = KeluargaKK::findOrFail($id);

        $validated = $request->validate([
            'kk_nomor' => 'required|unique:keluarga_kk,kk_nomor,' . $id . ',kk_id',
            'kepala_keluarga_warga_id' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
        ]);

        $keluarga->update($validated);

        return redirect()->route('keluargakk.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data
     */
    public function destroy($id)
    {
        $keluarga = KeluargaKK::findOrFail($id);
        $keluarga->delete();

        return redirect()->route('keluargakk.index')
            ->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Menampilkan data untuk dashboard (opsional)
     */
    public function dashboard()
    {
        $total_kk = KeluargaKK::count();
        return view('index', compact('total_kk'));
    }
}
