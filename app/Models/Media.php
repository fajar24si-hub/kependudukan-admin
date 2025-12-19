<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_name',
        'caption',
        'mime_type',
        'sort_order'
    ];

    protected $appends = ['url', 'icon', 'file_type', 'is_image', 'is_pdf', 'is_previewable'];

    // TAMBAHKAN INI untuk polymorphic relationships
    protected $foreignKey = 'ref_id';
    protected $morphClass = 'ref_table';

    /**
     * Get the parent model (polymorphic).
     */
    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'ref_table', 'ref_id');
    }

    /**
     * Scope untuk filter berdasarkan model
     */
    public function scopeWhereModel($query, $model, $id = null)
    {
        $modelClass = is_object($model) ? get_class($model) : $model;
        $modelName = is_object($model) ? class_basename($model) : $model;

        $query->where('ref_table', $modelClass);

        if ($id) {
            $query->where('ref_id', $id);
        }

        return $query;
    }


    /**
     * Accessor: URL lengkap file
     */
    public function getUrlAttribute()
    {
        $folder = $this->getFolderByMimeType($this->mime_type);
        return asset("storage/media/{$folder}/{$this->file_name}");
    }

    /**
     * Accessor: Icon berdasarkan mime type
     */
    public function getIconAttribute()
    {
        if (Str::startsWith($this->mime_type, 'image/')) {
            return 'fas fa-image';
        } elseif ($this->mime_type == 'application/pdf') {
            return 'fas fa-file-pdf';
        } elseif (Str::contains($this->mime_type, 'word')) {
            return 'fas fa-file-word';
        } elseif (Str::contains($this->mime_type, 'excel') || Str::contains($this->mime_type, 'spreadsheet')) {
            return 'fas fa-file-excel';
        } else {
            return 'fas fa-file';
        }
    }

    /**
     * Accessor: Tipe file yang mudah dibaca
     */
    public function getFileTypeAttribute()
    {
        if (Str::startsWith($this->mime_type, 'image/')) {
            return 'Gambar';
        } elseif ($this->mime_type == 'application/pdf') {
            return 'PDF';
        } elseif (Str::contains($this->mime_type, 'word')) {
            return 'Dokumen Word';
        } elseif (Str::contains($this->mime_type, 'excel') || Str::contains($this->mime_type, 'spreadsheet')) {
            return 'Excel';
        } else {
            return 'File';
        }
    }

    /**
     * Accessor: Cek apakah file adalah gambar
     */
    public function getIsImageAttribute()
    {
        return Str::startsWith($this->mime_type, 'image/');
    }

    /**
     * Accessor: Cek apakah file adalah PDF
     */
    public function getIsPdfAttribute()
    {
        return $this->mime_type == 'application/pdf';
    }

    /**
     * Accessor: Cek apakah file dapat dipreview di browser
     */
    public function getIsPreviewableAttribute()
    {
        return $this->is_image || $this->is_pdf;
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
     * Mendapatkan warna badge untuk tampilan
     */
    public function getBadgeColor()
    {
        if ($this->is_image) {
            return 'success';
        } elseif ($this->is_pdf) {
            return 'danger';
        } elseif (Str::contains($this->mime_type, 'word')) {
            return 'primary';
        } elseif (Str::contains($this->mime_type, 'excel') || Str::contains($this->mime_type, 'spreadsheet')) {
            return 'success';
        } else {
            return 'secondary';
        }
    }
}
