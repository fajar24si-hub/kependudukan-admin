<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKK;
use Illuminate\Http\Request;

class KeluargaKKController extends Controller
{
    public function index()
    {
        $data = KeluargaKK::all();
        return view('pages.keluargakk.index', compact('data'));
    }

    public function create()
    {
        // Ini sudah benar dan cocok dengan file create.blade.php
        return view('pages.keluargakk.create');
    }

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
        return redirect()->route('keluargakk.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $keluarga = KeluargaKK::findOrFail($id);
        return view('keluargakk.edit', compact('keluarga'));
    }

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
        return redirect()->route('keluargakk.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KeluargaKK::findOrFail($id)->delete();
        return redirect()->route('keluargakk.index')->with('success', 'Data berhasil dihapus!');
    }

    public function dashboard()
    {
        $total_kk = KeluargaKK::count();
        return view('index', compact('total_kk'));
    }
}
