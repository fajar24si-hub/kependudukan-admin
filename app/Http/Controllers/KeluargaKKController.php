<?php

namespace App\Http\Controllers;

use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Http\Request;

class KeluargaKKController extends Controller
{
    /**
     * Menampilkan semua data keluarga KK dengan pagination, search, dan filter
     */
    public function index(Request $request)
    {
        $query = KeluargaKK::with('kepalaKeluarga');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kk_nomor', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('kepalaKeluarga', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by RT
        if ($request->has('rt') && !empty($request->rt)) {
            $query->where('rt', $request->rt);
        }

        // Filter by RW
        if ($request->has('rw') && !empty($request->rw)) {
            $query->where('rw', $request->rw);
        }

        // Sort functionality
        $sort = $request->get('sort', 'kk_id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Pagination dengan 10 data per halaman
        $data = $query->paginate(10)->withQueryString();

        // Get unique values for filter dropdowns
        $rtList = KeluargaKK::distinct()->whereNotNull('rt')->orderBy('rt')->pluck('rt');
        $rwList = KeluargaKK::distinct()->whereNotNull('rw')->orderBy('rw')->pluck('rw');

        return view('pages.keluargakk.index', compact('data', 'rtList', 'rwList'));
    }

    /**
     * Menampilkan form tambah data keluarga KK
     */
    public function create()
    {
        // Get calon kepala keluarga (laki-laki, sudah menikah)
        $calonKepalaKeluarga = Warga::where('jenis_kelamin', 'L')
            ->where('status_perkawinan', 'Kawin')
            ->get();

        return view('pages.keluargakk.create', compact('calonKepalaKeluarga'));
    }

    /**
     * Menyimpan data baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kk_nomor' => 'required|unique:keluarga_kk,kk_nomor',
            'kepala_keluarga_warga_id' => 'required|numeric|exists:warga,warga_id',
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
        $calonKepalaKeluarga = Warga::where('jenis_kelamin', 'L')
            ->where('status_perkawinan', 'Kawin')
            ->get();

        return view('pages.keluargakk.edit', compact('keluarga', 'calonKepalaKeluarga'));
    }

    /**
     * Menyimpan perubahan data
     */
    public function update(Request $request, $id)
    {
        $keluarga = KeluargaKK::findOrFail($id);

        $validated = $request->validate([
            'kk_nomor' => 'required|unique:keluarga_kk,kk_nomor,' . $id . ',kk_id',
            'kepala_keluarga_warga_id' => 'required|numeric|exists:warga,warga_id',
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
