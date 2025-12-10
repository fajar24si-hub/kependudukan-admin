<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaKematian;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeristiwaKematianController extends Controller
{
    public function index()
    {
        // FIX: Gunakan 'warga_id' bukan 'id'
        $kematian = PeristiwaKematian::with([
            'warga:warga_id,nama,nik',
            'media'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pages.kematian.index', compact('kematian'));
    }

    public function create()
    {
        // FIX: Hapus 'id', gunakan 'warga_id'
        $wargas = Warga::select('warga_id', 'nama', 'nik')
                        ->whereDoesntHave('peristiwaKematian')
                        ->orderBy('nama')
                        ->get();
        return view('pages.kematian.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_meninggal' => 'required|date|before_or_equal:today',
            'sebab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'no_surat' => 'required|unique:peristiwa_kematian,no_surat',
        ]);

        // Cek apakah warga sudah memiliki data kematian
        $existing = PeristiwaKematian::where('warga_id', $request->warga_id)->first();
        if ($existing) {
            return back()->withErrors(['warga_id' => 'Warga ini sudah memiliki data kematian.'])->withInput();
        }

        PeristiwaKematian::create($validated);

        return redirect()->route('peristiwa-kematian.index')
                        ->with('success', 'Data kematian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kematian = PeristiwaKematian::with(['warga', 'media'])->findOrFail($id);
        return view('pages.kematian.show', compact('kematian'));
    }

    public function edit($id)
    {
        $kematian = PeristiwaKematian::with(['warga', 'media'])->findOrFail($id);
        return view('pages.kematian.edit', compact('kematian'));
    }

    public function update(Request $request, $id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);

        $validated = $request->validate([
            'tgl_meninggal' => 'required|date|before_or_equal:today',
            'sebab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'no_surat' => 'required|unique:peristiwa_kematian,no_surat,' . $kematian->kematian_id . ',kematian_id',
        ]);

        $kematian->update($validated);

        return redirect()->route('peristiwa-kematian.index')
                        ->with('success', 'Data kematian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kematian = PeristiwaKematian::findOrFail($id);
        $kematian->delete();

        return redirect()->route('peristiwa-kematian.index')
                        ->with('success', 'Data kematian berhasil dihapus.');
    }

    // ... method lainnya
}
