<?php

namespace App\Http\Controllers;

use App\Models\PeristiwaPindah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // IMPORT INI

class PeristiwaPindahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PeristiwaPindah::with(['warga', 'media'])
            ->select('peristiwa_pindah.*')
            ->join('warga', 'peristiwa_pindah.warga_id', '=', 'warga.warga_id');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('warga.nama', 'like', "%{$search}%")
                    ->orWhere('warga.nik', 'like', "%{$search}%")
                    ->orWhere('peristiwa_pindah.no_surat', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('peristiwa_pindah.status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tgl_dari') && $request->tgl_dari != '') {
            $query->whereDate('peristiwa_pindah.tgl_pindah', '>=', $request->tgl_dari);
        }

        if ($request->has('tgl_sampai') && $request->tgl_sampai != '') {
            $query->whereDate('peristiwa_pindah.tgl_pindah', '<=', $request->tgl_sampai);
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        if ($sort == 'terbaru') {
            $query->orderBy('peristiwa_pindah.tgl_pindah', 'desc')
                ->orderBy('peristiwa_pindah.created_at', 'desc');
        } elseif ($sort == 'terlama') {
            $query->orderBy('peristiwa_pindah.tgl_pindah', 'asc')
                ->orderBy('peristiwa_pindah.created_at', 'asc');
        } elseif ($sort == 'nama') {
            $query->orderBy('warga.nama', 'asc');
        } elseif ($sort == 'status') {
            $query->orderBy('peristiwa_pindah.status', 'asc')
                ->orderBy('peristiwa_pindah.tgl_pindah', 'desc');
        }

        $peristiwaPindah = $query->paginate(10);

        return view('pages.pindah.index', compact('peristiwaPindah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil warga yang masih hidup dan belum pindah yang disetujui
        $warga = Warga::whereDoesntHave('peristiwaKematian')
            ->whereDoesntHave('peristiwaPindah', function ($query) {
                $query->where('status', 'approved');
            })
            ->orderBy('nama')
            ->get();

        return view('pages.pindah.create', compact('warga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_pindah' => 'required|date',
            'alamat_tujuan' => 'required|string|max:255',
            'kecamatan_tujuan' => 'required|string|max:100',
            'kabupaten_tujuan' => 'required|string|max:100',
            'provinsi_tujuan' => 'required|string|max:100',
            'negara_tujuan' => 'required|string|max:100',
            'alasan' => 'required|string',
            'keterangan' => 'nullable|string',
            'no_surat' => 'nullable|string|max:50',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Validasi tambahan: pastikan warga belum pindah yang disetujui
        $sudahPindah = PeristiwaPindah::where('warga_id', $validated['warga_id'])
            ->where('status', 'approved')
            ->exists();

        if ($sudahPindah) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Warga ini sudah memiliki data pindah yang disetujui.');
        }

        $validated['status'] = 'pending';

        $peristiwaPindah = PeristiwaPindah::create($validated);

        // Handle upload file jika ada
        if ($request->hasFile('dokumen')) {
            $this->uploadDokumen($peristiwaPindah, $request->file('dokumen'));
        }

        return redirect()->route('pindah.index')
            ->with('success', 'Data peristiwa pindah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peristiwaPindah = PeristiwaPindah::with(['warga', 'media'])->findOrFail($id);

        // Ambil riwayat pindah warga ini
        $riwayatPindah = PeristiwaPindah::where('warga_id', $peristiwaPindah->warga_id)
            ->where('pindah_id', '!=', $id)
            ->orderBy('tgl_pindah', 'desc')
            ->get();

        return view('pages.pindah.show', compact('peristiwaPindah', 'riwayatPindah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $peristiwaPindah = PeristiwaPindah::with('warga')->findOrFail($id);

        // Ambil warga yang masih hidup dan belum pindah yang disetujui
        // Termasuk warga yang sedang diedit
        $warga = Warga::whereDoesntHave('peristiwaKematian')
            ->where(function ($query) use ($peristiwaPindah) {
                $query->whereDoesntHave('peristiwaPindah', function ($q) {
                    $q->where('status', 'approved');
                })
                    ->orWhere('warga_id', $peristiwaPindah->warga_id);
            })
            ->orderBy('nama')
            ->get();

        // Ambil data pindah sebelumnya dan selanjutnya untuk validasi
        $previousPindah = PeristiwaPindah::where('warga_id', $peristiwaPindah->warga_id)
            ->where('pindah_id', '<', $peristiwaPindah->pindah_id)
            ->orderBy('tgl_pindah', 'desc')
            ->first();

        $nextPindah = PeristiwaPindah::where('warga_id', $peristiwaPindah->warga_id)
            ->where('pindah_id', '>', $peristiwaPindah->pindah_id)
            ->orderBy('tgl_pindah', 'asc')
            ->first();

        return view('pages.pindah.edit', compact(
            'peristiwaPindah',
            'warga',
            'previousPindah',
            'nextPindah'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $peristiwaPindah = PeristiwaPindah::findOrFail($id);

        $validated = $request->validate([
            'warga_id' => 'required|exists:warga,warga_id',
            'tgl_pindah' => 'required|date',
            'alamat_tujuan' => 'required|string|max:255',
            'kecamatan_tujuan' => 'required|string|max:100',
            'kabupaten_tujuan' => 'required|string|max:100',
            'provinsi_tujuan' => 'required|string|max:100',
            'negara_tujuan' => 'required|string|max:100',
            'alasan' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'no_surat' => 'nullable|string|max:50',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Validasi: jika mengganti warga, pastikan warga baru belum pindah yang disetujui
        if ($peristiwaPindah->warga_id != $validated['warga_id']) {
            $sudahPindah = PeristiwaPindah::where('warga_id', $validated['warga_id'])
                ->where('status', 'approved')
                ->where('pindah_id', '!=', $id)
                ->exists();

            if ($sudahPindah) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Warga yang dipilih sudah memiliki data pindah yang disetujui.');
            }
        }

        $peristiwaPindah->update($validated);

        // Handle upload file jika ada
        if ($request->hasFile('dokumen')) {
            $this->uploadDokumen($peristiwaPindah, $request->file('dokumen'));
        }

        return redirect()->route('pindah.index')
            ->with('success', 'Data peristiwa pindah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peristiwaPindah = PeristiwaPindah::findOrFail($id);

        // Hapus media terkait jika ada
        if ($peristiwaPindah->media()->exists()) {
            $peristiwaPindah->media()->delete();
        }

        $peristiwaPindah->delete();

        return redirect()->route('pindah.index')
            ->with('success', 'Data peristiwa pindah berhasil dihapus.');
    }

    /**
     * Update status pindah
     */
    public function updateStatus(Request $request, $id)
    {
        // SIMPLE & DIRECT - NO VALIDATION, NO COMPLEX LOGIC
        $peristiwaPindah = PeristiwaPindah::find($id);

        if (!$peristiwaPindah) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        // Update langsung
        $peristiwaPindah->status = $request->status;
        $peristiwaPindah->save();

        // Redirect dengan pesan
        return redirect()->route('pindah.show', $id)
            ->with('success', 'Status berhasil diubah menjadi: ' . strtoupper($request->status));
    }
    /**
     * Upload dokumen untuk peristiwa pindah
     */
    private function uploadDokumen(PeristiwaPindah $peristiwaPindah, $file)
    {
        try {
            // Simpan file
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen/pindah', $fileName, 'public');

            // Simpan ke media
            $peristiwaPindah->media()->create([
                'ref_table' => 'peristiwa_pindah',
                'ref_id' => $peristiwaPindah->pindah_id,
                'file_name' => $fileName,
                'caption' => 'Dokumen Peristiwa Pindah',
                'mime_type' => $file->getMimeType(),
                'sort_order' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading dokumen pindah: ' . $e->getMessage());
        }
    }

    /**
     * Get statistik peristiwa pindah
     */
    public function getStatistik()
    {
        $statistik = [
            'total' => PeristiwaPindah::count(),
            'pending' => PeristiwaPindah::where('status', 'pending')->count(),
            'approved' => PeristiwaPindah::where('status', 'approved')->count(),
            'rejected' => PeristiwaPindah::where('status', 'rejected')->count(),
            'bulan_ini' => PeristiwaPindah::whereMonth('tgl_pindah', date('m'))
                ->whereYear('tgl_pindah', date('Y'))
                ->count(),
            'tahun_ini' => PeristiwaPindah::whereYear('tgl_pindah', date('Y'))->count(),
        ];

        return response()->json($statistik);
    }

    /**
     * Get data for select2 (AJAX)
     */
    public function getWargaForSelect2(Request $request)
    {
        $search = $request->get('search', '');

        $warga = Warga::select('warga_id', 'nama', 'nik')
            ->whereDoesntHave('peristiwaKematian')
            ->whereDoesntHave('peristiwaPindah', function ($query) {
                $query->where('status', 'approved');
            })
            ->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->limit(50)
            ->get()
            ->map(function ($warga) {
                return [
                    'id' => $warga->warga_id,
                    'text' => "{$warga->nama} - {$warga->nik}"
                ];
            });

        return response()->json(['results' => $warga]);
    }
}
