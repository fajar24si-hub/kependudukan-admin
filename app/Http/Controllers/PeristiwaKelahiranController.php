<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PeristiwaKelahiran;
use App\Models\Media;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeristiwaKelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelahirans = PeristiwaKelahiran::with(['warga', 'ayah', 'ibu', 'media'])
            ->latest()
            ->get();

        // PERBAIKAN: Sesuaikan dengan folder Kelahiran (huruf K kapital)
        return view('pages.Kelahiran.index', compact('kelahirans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wargas = Warga::all();
        // PERBAIKAN: Sesuaikan dengan folder Kelahiran (huruf K kapital)
        return view('pages.Kelahiran.create', compact('wargas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_akta' => 'required|unique:peristiwa_kelahiran,no_akta',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'warga_id' => 'required|exists:warga,warga_id',
            'ayah_warga_id' => 'required|exists:warga,warga_id',
            'ibu_warga_id' => 'required|exists:warga,warga_id',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
        ], [
            'warga_id.exists' => 'Data bayi tidak ditemukan',
            'ayah_warga_id.exists' => 'Data ayah tidak ditemukan',
            'ibu_warga_id.exists' => 'Data ibu tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data kelahiran
            $kelahiran = PeristiwaKelahiran::create([
                'no_akta' => $request->no_akta,
                'tgl_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'warga_id' => $request->warga_id,
                'ayah_warga_id' => $request->ayah_warga_id,
                'ibu_warga_id' => $request->ibu_warga_id,
            ]);

            // Upload files jika ada
            if ($request->hasFile('files')) {
                $this->uploadFiles($request->file('files'), 'peristiwa_kelahiran', $kelahiran->kelahiran_id);
            }

            return redirect()->route('peristiwa-kelahiran.index')
                ->with('success', 'Data kelahiran berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelahiran = PeristiwaKelahiran::with(['warga', 'ayah', 'ibu', 'media'])
            ->findOrFail($id);

        // PERBAIKAN: Sesuaikan dengan folder Kelahiran (huruf K kapital)
        return view('pages.Kelahiran.show', compact('kelahiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kelahiran = PeristiwaKelahiran::with(['warga', 'ayah', 'ibu', 'media'])->findOrFail($id);
        $wargas = Warga::all();

        // PERBAIKAN: Sesuaikan dengan folder Kelahiran (huruf K kapital)
        return view('pages.Kelahiran.edit', compact('kelahiran', 'wargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kelahiran = PeristiwaKelahiran::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'no_akta' => 'required|unique:peristiwa_kelahiran,no_akta,' . $id . ',kelahiran_id',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'warga_id' => 'required|exists:warga,warga_id',
            'ayah_warga_id' => 'required|exists:warga,warga_id',
            'ibu_warga_id' => 'required|exists:warga,warga_id',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
            'delete_files' => 'array',
        ], [
            'warga_id.exists' => 'Data bayi tidak ditemukan',
            'ayah_warga_id.exists' => 'Data ayah tidak ditemukan',
            'ibu_warga_id.exists' => 'Data ibu tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update data kelahiran
            $kelahiran->update([
                'no_akta' => $request->no_akta,
                'tgl_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'warga_id' => $request->warga_id,
                'ayah_warga_id' => $request->ayah_warga_id,
                'ibu_warga_id' => $request->ibu_warga_id,
            ]);

            // Hapus file yang dipilih
            if ($request->has('delete_files')) {
                $this->deleteFiles($request->delete_files);
            }

            // Upload file baru
            if ($request->hasFile('files')) {
                $this->uploadFiles($request->file('files'), 'peristiwa_kelahiran', $kelahiran->kelahiran_id);
            }
            return redirect()->route('peristiwa-kelahiran.index')
                ->with('success', 'Data kelahiran berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kelahiran = PeristiwaKelahiran::findOrFail($id);

            // Hapus file media terkait
            $mediaFiles = Media::where('ref_table', 'peristiwa_kelahiran')
                ->where('ref_id', $id)
                ->get();

            foreach ($mediaFiles as $media) {
                Storage::delete('public/media/' . $media->file_name);
                $media->delete();
            }

            $kelahiran->delete();

            // PERBAIKAN: Pastikan route name benar
            return redirect()->route('peristiwa-kelahiran.index')
                ->with('success', 'Data kelahiran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Upload multiple files
     */
    private function uploadFiles($files, $refTable, $refId)
    {
        foreach ($files as $index => $file) {
            if ($file->isValid()) {
                $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/media', $fileName);

                Media::create([
                    'ref_table' => $refTable,
                    'ref_id' => $refId,
                    'file_name' => $fileName,
                    'mime_type' => $file->getMimeType(),
                    'caption' => $file->getClientOriginalName(),
                    'sort_order' => $index
                ]);
            }
        }
    }

    /**
     * Delete selected files
     */
    private function deleteFiles($mediaIds)
    {
        $mediaFiles = Media::whereIn('media_id', $mediaIds)->get();

        foreach ($mediaFiles as $media) {
            Storage::delete('public/media/' . $media->file_name);
            $media->delete();
        }
    }
}
