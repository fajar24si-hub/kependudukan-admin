<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKelahiran;
use Illuminate\Http\Request;

class PeristiwaKelahiranController extends Controller
{
    public function index()
    {
        $kelahiran = PeristiwaKelahiran::with(['warga', 'ayah', 'ibu'])->get();
        return view('peristiwa_kelahiran.index', compact('kelahiran'));
    }

    public function create()
    {
        return view('peristiwa_kelahiran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'ayah_warga_id' => 'nullable',
            'ibu_warga_id' => 'nullable',
            'no_akta' => 'required|unique:peristiwa_kelahiran',
        ]);

        PeristiwaKelahiran::create($validated);
        return redirect()->route('kelahiran.index')->with('success', 'Data kelahiran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);
        return view('peristiwa_kelahiran.edit', compact('kelahiran'));
    }

    public function update(Request $request, $id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        $validated = $request->validate([
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'no_akta' => 'required|unique:peristiwa_kelahiran,no_akta,' . $kelahiran->kelahiran_id . ',kelahiran_id',
        ]);

        $kelahiran->update($validated);
        return redirect()->route('kelahiran.index')->with('success', 'Data kelahiran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PeristiwaKelahiran::destroy($id);
        return redirect()->route('kelahiran.index')->with('success', 'Data kelahiran berhasil dihapus.');
    }
}
