<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use Illuminate\Http\Request;

class PeristiwaKematianController extends Controller
{
    public function index()
    {
        $kematian = PeristiwaKematian::with('warga')->get();
        return view('peristiwa_kematian.index', compact('kematian'));
    }

    public function create()
    {
        return view('peristiwa_kematian.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required',
            'tgl_meninggal' => 'required|date',
            'sebab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'no_surat' => 'required|unique:peristiwa_kematian',
        ]);

        PeristiwaKematian::create($validated);
        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        return view('peristiwa_kematian.edit', compact('kematian'));
    }

    public function update(Request $request, $id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);

        $validated = $request->validate([
            'tgl_meninggal' => 'required|date',
            'sebab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'no_surat' => 'required|unique:peristiwa_kematian,no_surat,' . $kematian->kematian_id . ',kematian_id',
        ]);

        $kematian->update($validated);
        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PeristiwaKematian::destroy($id);
        return redirect()->route('kematian.index')->with('success', 'Data kematian berhasil dihapus.');
    }
}
