<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('tempat_lahir', 'like', "%{$search}%")
                  ->orWhere('agama', 'like', "%{$search}%")
                  ->orWhere('pekerjaan', 'like', "%{$search}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->has('jenis_kelamin') && !empty($request->jenis_kelamin)) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by agama
        if ($request->has('agama') && !empty($request->agama)) {
            $query->where('agama', $request->agama);
        }

        // Filter by pendidikan
        if ($request->has('pendidikan') && !empty($request->pendidikan)) {
            $query->where('pendidikan', $request->pendidikan);
        }

        // Filter by status perkawinan
        if ($request->has('status_perkawinan') && !empty($request->status_perkawinan)) {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        // Filter by date range (tanggal lahir)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('tanggal_lahir', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('tanggal_lahir', '<=', $request->end_date);
        }

        // Sort functionality
        $sort = $request->get('sort', 'warga_id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Pagination dengan 10 data per halaman
        $data = $query->paginate(10)->withQueryString();

        // Get unique values for filter dropdowns
        $agamaList = Warga::distinct()->whereNotNull('agama')->pluck('agama');
        $pendidikanList = Warga::distinct()->whereNotNull('pendidikan')->pluck('pendidikan');
        $statusPerkawinanList = Warga::distinct()->whereNotNull('status_perkawinan')->pluck('status_perkawinan');

        return view('pages.warga.index', compact('data', 'agamaList', 'pendidikanList', 'statusPerkawinanList'));
    }

    public function create()
    {
        return view('pages.warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:warga,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required',
            'status_dalam_keluarga' => 'required|string',
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $warga = Warga::findOrFail($id);
        return view('pages.warga.edit', compact('warga'));
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:warga,nik,' . $id . ',warga_id',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required',
            'status_dalam_keluarga' => 'required|string',
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus!');
    }
}
