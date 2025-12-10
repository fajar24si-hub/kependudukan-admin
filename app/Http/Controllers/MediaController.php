<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Menampilkan daftar media (Admin)
     */
    public function index(Request $request)
    {
        $query = Media::query();

        // Filter berdasarkan referensi
        if ($request->has('ref_table') && $request->ref_table) {
            $query->where('ref_table', $request->ref_table);
        }

        if ($request->has('ref_id') && $request->ref_id) {
            $query->where('ref_id', $request->ref_id);
        }

        $media = $query->orderBy('sort_order')->paginate(20);

        return view('admin.media.index', compact('media'));
    }

    /**
     * Menampilkan form upload media (Admin)
     */
    public function create()
    {
        $refTables = [
            'peristiwa_kelahiran' => 'Peristiwa Kelahiran',
            'peristiwa_kematian' => 'Peristiwa Kematian',
            'peristiwa_pindah' => 'Peristiwa Pindah',
        ];

        return view('admin.media.create', compact('refTables'));
    }

    /**
     * Menyimpan media baru (Admin)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_table' => 'required|string|max:50',
            'ref_id' => 'required|integer',
            'file' => 'required|file|max:10240', // Max 10MB
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();

        // Generate unique filename
        $fileName = time() . '_' . Str::random(10) . '.' . $extension;

        // Tentukan folder berdasarkan mime type
        $folder = $this->getFolderByMimeType($mimeType);

        // Simpan file (path: storage/app/public/media/{folder}/{filename})
        $filePath = $file->storeAs("media/{$folder}", $fileName, 'public');

        // Simpan ke database
        $media = Media::create([
            'ref_table' => $request->ref_table,
            'ref_id' => $request->ref_id,
            'file_name' => $fileName, // Simpan nama file unik
            'caption' => $request->caption,
            'mime_type' => $mimeType,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Media berhasil diupload.');
    }

    /**
     * Menampilkan detail media (Admin)
     */
    public function show($id)
    {
        $media = Media::findOrFail($id);

        return view('admin.media.show', compact('media'));
    }

    /**
     * Menampilkan detail media (Guest)
     */
    public function showGuest($id)
    {
        $media = Media::findOrFail($id);

        return view('guest.media.show', compact('media'));
    }

    /**
     * Menampilkan form edit media (Admin)
     */
    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $refTables = [
            'peristiwa_kelahiran' => 'Peristiwa Kelahiran',
            'peristiwa_kematian' => 'Peristiwa Kematian',
            'peristiwa_pindah' => 'Peristiwa Pindah',
        ];

        return view('admin.media.edit', compact('media', 'refTables'));
    }

    /**
     * Update media (Admin)
     */
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ref_table' => 'required|string|max:50',
            'ref_id' => 'required|integer',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'file' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'ref_table' => $request->ref_table,
            'ref_id' => $request->ref_id,
            'caption' => $request->caption,
            'sort_order' => $request->sort_order ?? $media->sort_order,
        ];

        // Jika ada file baru diupload
        if ($request->hasFile('file')) {
            // Hapus file lama
            $oldFolder = $this->getFolderByMimeType($media->mime_type);
            $oldFilePath = "media/{$oldFolder}/{$media->file_name}";
            Storage::disk('public')->delete($oldFilePath);

            // Upload file baru
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();

            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            $folder = $this->getFolderByMimeType($mimeType);
            $filePath = $file->storeAs("media/{$folder}", $fileName, 'public');

            $data['file_name'] = $fileName;
            $data['mime_type'] = $mimeType;
        }

        $media->update($data);

        return redirect()->route('admin.media.show', $media->media_id)
            ->with('success', 'Media berhasil diperbarui.');
    }

    /**
     * Hapus media (Admin)
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Hapus file dari storage
        $folder = $this->getFolderByMimeType($media->mime_type);
        $filePath = "media/{$folder}/{$media->file_name}";
        Storage::disk('public')->delete($filePath);

        // Hapus dari database
        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media berhasil dihapus.');
    }

    /**
     * Download file media
     */
    public function download($id)
    {
        $media = Media::findOrFail($id);

        $folder = $this->getFolderByMimeType($media->mime_type);
        $filePath = storage_path("app/public/media/{$folder}/{$media->file_name}");

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Ambil original name dari file_name jika mengandung info original
        $originalName = $this->getOriginalFileName($media);

        return response()->download($filePath, $originalName);
    }

    /**
     * Preview file (untuk gambar dan PDF)
     */
    public function preview($id)
    {
        $media = Media::findOrFail($id);

        $folder = $this->getFolderByMimeType($media->mime_type);
        $filePath = storage_path("app/public/media/{$folder}/{$media->file_name}");

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $headers = [
            'Content-Type' => $media->mime_type,
        ];

        return response()->file($filePath, $headers);
    }

    /**
     * Mendapatkan URL file untuk ditampilkan
     */
    public function getUrl($id)
    {
        $media = Media::findOrFail($id);
        $folder = $this->getFolderByMimeType($media->mime_type);

        return response()->json([
            'url' => asset("storage/media/{$folder}/{$media->file_name}"),
            'type' => $media->mime_type
        ]);
    }

    /**
     * Mendapatkan daftar media berdasarkan referensi
     */
    public function getByReference($refTable, $refId)
    {
        $media = Media::where('ref_table', $refTable)
            ->where('ref_id', $refId)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                $item->url = $this->getFileUrl($item);
                $item->icon = $this->getIcon($item->mime_type);
                $item->file_type = $this->getFileType($item->mime_type);
                $item->is_image = Str::startsWith($item->mime_type, 'image/');
                $item->is_pdf = $item->mime_type == 'application/pdf';
                return $item;
            });

        return response()->json($media);
    }

    /**
     * Helper: Mendapatkan folder berdasarkan mime type
     */
    private function getFolderByMimeType($mimeType)
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return 'images';
        } elseif ($mimeType == 'application/pdf') {
            return 'pdf';
        } elseif (in_array($mimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ])) {
            return 'documents';
        } elseif (in_array($mimeType, [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ])) {
            return 'excel';
        } else {
            return 'others';
        }
    }

    /**
     * Helper: Mendapatkan URL file
     */
    private function getFileUrl($media)
    {
        $folder = $this->getFolderByMimeType($media->mime_type);
        return asset("storage/media/{$folder}/{$media->file_name}");
    }

    /**
     * Helper: Mendapatkan icon berdasarkan mime type
     */
    private function getIcon($mimeType)
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return 'fas fa-image';
        } elseif ($mimeType == 'application/pdf') {
            return 'fas fa-file-pdf';
        } elseif (Str::contains($mimeType, 'word')) {
            return 'fas fa-file-word';
        } elseif (Str::contains($mimeType, 'excel') || Str::contains($mimeType, 'spreadsheet')) {
            return 'fas fa-file-excel';
        } else {
            return 'fas fa-file';
        }
    }

    /**
     * Helper: Mendapatkan tipe file
     */
    private function getFileType($mimeType)
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return 'Gambar';
        } elseif ($mimeType == 'application/pdf') {
            return 'PDF';
        } elseif (Str::contains($mimeType, 'word')) {
            return 'Dokumen Word';
        } elseif (Str::contains($mimeType, 'excel') || Str::contains($mimeType, 'spreadsheet')) {
            return 'Excel';
        } else {
            return 'File';
        }
    }

    /**
     * Helper: Mendapatkan nama file asli dari nama file yang disimpan
     */
    private function getOriginalFileName($media)
    {
        // Jika file_name mengandung timestamp dan random string, kita gunakan caption atau nama sederhana
        if ($media->caption) {
            $extension = pathinfo($media->file_name, PATHINFO_EXTENSION);
            return Str::slug($media->caption) . '.' . $extension;
        }

        return $media->file_name;
    }
}
