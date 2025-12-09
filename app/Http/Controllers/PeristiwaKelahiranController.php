<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PeristiwaKelahiran;
use App\Models\Media;
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
        $kelahirans = PeristiwaKelahiran::with('media')
            ->latest()
            ->get()
            ->map(function ($kelahiran) {
                // Convert tgl_lahir to Carbon if not already
                if ($kelahiran->tgl_lahir && !$kelahiran->tgl_lahir instanceof \Carbon\Carbon) {
                    $kelahiran->tgl_lahir = \Carbon\Carbon::parse($kelahiran->tgl_lahir);
                }
                return $kelahiran;
            });

        return view('pages.kelahiran.index', compact('kelahirans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ✅ Ubah path view
        return view('pages.kelahiran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_akta' => 'required|unique:peristiwa_kelahiran',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            // 'warga_id' => 'required|exists:warga,id',
            // 'ayah_warga_id' => 'required|exists:warga,id',
            // 'ibu_warga_id' => 'required|exists:warga,id',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data kelahiran
            $kelahiran = PeristiwaKelahiran::create($request->all());

            // Upload files jika ada
            if ($request->hasFile('files')) {
                $this->uploadFiles($request->file('files'), 'peristiwa_kelahiran', $kelahiran->kelahiran_id);
            }

            // ✅ Ubah route name
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
        $kelahiran = PeristiwaKelahiran::with('media')->findOrFail($id);
        // ✅ Buat view show atau gunakan index/edit
        return view('pages.Kelahiran.show', compact('kelahiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kelahiran = PeristiwaKelahiran::with('media')->findOrFail($id);
        // ✅ Ubah path view
        return view('pages.Kelahiran.edit', compact('kelahiran'));
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
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
            'delete_files' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update data kelahiran
            $kelahiran->update($request->except(['files', 'delete_files']));

            // Hapus file yang dipilih
            if ($request->has('delete_files')) {
                $this->deleteFiles($request->delete_files);
            }

            // Upload file baru
            if ($request->hasFile('files')) {
                $this->uploadFiles($request->file('files'), 'peristiwa_kelahiran', $kelahiran->kelahiran_id);
            }

            // ✅ Ubah route name
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

            // ✅ Ubah route name
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
