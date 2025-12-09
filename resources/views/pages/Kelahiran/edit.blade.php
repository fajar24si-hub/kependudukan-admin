@extends('layouts.app')

@section('title', 'Edit Data Kelahiran')
@section('subtitle', 'Perbarui informasi peristiwa kelahiran')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('peristiwa-kelahiran.index') }}">Data Kelahiran</a></li>
<li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Edit Data Kelahiran</h5>
                        <div class="badge bg-primary mt-1">
                            ID: {{ $kelahiran->kelahiran_id }}
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('peristiwa-kelahiran.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('peristiwa-kelahiran.update', $kelahiran->kelahiran_id) }}" method="POST" enctype="multipart/form-data" id="kelahiranForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-baby me-2"></i> Informasi Kelahiran
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                No. Akta Kelahiran <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="no_akta"
                                                   class="form-control @error('no_akta') is-invalid @enderror"
                                                   value="{{ old('no_akta', $kelahiran->no_akta) }}"
                                                   placeholder="Masukkan nomor akta"
                                                   required minlength="3" maxlength="100">
                                            @error('no_akta')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Nomor akta harus unik</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Tanggal Lahir <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="tgl_lahir"
                                                   class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                   value="{{ old('tgl_lahir', $kelahiran->tgl_lahir ? \Carbon\Carbon::parse($kelahiran->tgl_lahir)->format('Y-m-d') : '') }}"
                                                   required>
                                            @error('tgl_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Format: DD/MM/YYYY</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Tempat Lahir <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="tempat_lahir"
                                                   class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                   value="{{ old('tempat_lahir', $kelahiran->tempat_lahir) }}"
                                                   placeholder="Masukkan tempat lahir"
                                                   required>
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Contoh: Rumah Sakit, Rumah, dll</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Jam Lahir
                                            </label>
                                            <input type="time" name="jam_lahir"
                                                   class="form-control @error('jam_lahir') is-invalid @enderror"
                                                   value="{{ old('jam_lahir', $kelahiran->jam_lahir) }}">
                                            @error('jam_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Opsional, format: HH:MM</small>
                                        </div>
                                    </div>

                                    <!-- Informasi Sistem -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <i class="fas fa-info-circle me-2"></i> Informasi Sistem
                                                    </h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted">Dibuat:</small>
                                                        <div>{{ $kelahiran->created_at->format('d/m/Y H:i') }}</div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted">Diperbarui:</small>
                                                        <div>{{ $kelahiran->updated_at->format('d/m/Y H:i') }}</div>
                                                    </div>
                                                    @if($kelahiran->tgl_lahir)
                                                    <div>
                                                        <small class="text-muted">Usia saat ini:</small>
                                                        <div>
                                                            <strong>{{ \Carbon\Carbon::parse($kelahiran->tgl_lahir)->age }} tahun</strong>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Dokumen Saat Ini -->
                            @if($kelahiran->media->count() > 0)
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-alt me-2"></i> Dokumen Saat Ini
                                        <span class="badge bg-info ms-2">{{ $kelahiran->media->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="currentFiles">
                                        @foreach($kelahiran->media as $media)
                                        <div class="file-item mb-3" id="file-{{ $media->media_id }}">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="d-flex align-items-center">
                                                            @if(in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif']))
                                                                <i class="fas fa-image text-primary me-2"></i>
                                                            @else
                                                                <i class="fas fa-file text-secondary me-2"></i>
                                                            @endif
                                                            <div>
                                                                <small class="d-block fw-bold text-truncate" style="max-width: 150px;">
                                                                    {{ $media->caption }}
                                                                </small>
                                                                <small class="text-muted">
                                                                    {{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                                                    • {{ \Carbon\Carbon::parse($media->created_at)->format('d/m/Y') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input delete-checkbox"
                                                                   type="checkbox"
                                                                   name="delete_files[]"
                                                                   value="{{ $media->media_id }}"
                                                                   id="delete_{{ $media->media_id }}"
                                                                   onchange="toggleFileDelete(this, {{ $media->media_id }})">
                                                            <label class="form-check-label small" for="delete_{{ $media->media_id }}">
                                                                Hapus
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                               target="_blank" class="btn btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                               download class="btn btn-outline-success">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   id="selectAllFiles" onchange="toggleAllFiles(this)">
                                            <label class="form-check-label small" for="selectAllFiles">
                                                <i class="fas fa-check-double me-1"></i> Pilih semua untuk dihapus
                                            </label>
                                        </div>
                                        <small class="text-muted">
                                            File yang dicentang akan dihapus saat data diperbarui
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Upload Dokumen Baru -->
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-upload me-2"></i> Tambah Dokumen Baru
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Upload Dokumen Baru
                                        </label>
                                        <input type="file" name="files[]"
                                               class="form-control @error('files.*') is-invalid @enderror"
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx"
                                               id="filesInput" multiple onchange="previewNewFiles(this)">
                                        @error('files.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: JPG, PNG, PDF, DOC, XLS. Maksimal 5MB per file.
                                        </small>
                                    </div>

                                    <div class="file-preview" id="newFilesPreview"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Perbarui Data
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-1"></i> Reset Perubahan
                        </button>
                        <a href="{{ route('peristiwa-kelahiran.show', $kelahiran->kelahiran_id) }}"
                           class="btn btn-info">
                            <i class="fas fa-eye me-1"></i> Lihat Detail
                        </a>
                        <a href="{{ route('peristiwa-kelahiran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filesInput = document.getElementById('filesInput');
    const newFilesPreview = document.getElementById('newFilesPreview');
    const selectAllCheckbox = document.getElementById('selectAllFiles');

    // Preview new files function
    window.previewNewFiles = function(input) {
        const files = input.files;
        newFilesPreview.innerHTML = '';

        if (files.length === 0) {
            return;
        }

        // Create file list
        const fileList = document.createElement('div');
        fileList.className = 'list-group mt-3';

        Array.from(files).forEach((file, index) => {
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const extension = file.name.split('.').pop().toUpperCase();

            const fileItem = document.createElement('div');
            fileItem.className = 'list-group-item d-flex justify-content-between align-items-center border-success';
            fileItem.style.borderLeft = '3px solid var(--bs-success)';
            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-plus-circle text-success me-2"></i>
                    <div>
                        <small class="d-block fw-bold">${file.name}</small>
                        <small class="text-muted">${fileSize} MB • ${extension}</small>
                    </div>
                </div>
                <span class="badge bg-success">Baru</span>
            `;
            fileList.appendChild(fileItem);
        });

        newFilesPreview.appendChild(fileList);
    };

    // Toggle individual file delete
    window.toggleFileDelete = function(checkbox, fileId) {
        const fileItem = document.getElementById('file-' + fileId);
        if (checkbox.checked) {
            fileItem.style.opacity = '0.5';
            fileItem.style.backgroundColor = 'rgba(220, 53, 69, 0.1)';
        } else {
            fileItem.style.opacity = '1';
            fileItem.style.backgroundColor = '';
        }
    };

    // Toggle all files for delete
    window.toggleAllFiles = function(checkbox) {
        const deleteCheckboxes = document.querySelectorAll('.delete-checkbox');
        deleteCheckboxes.forEach(cb => {
            cb.checked = checkbox.checked;
            const fileId = cb.value;
            toggleFileDelete(cb, fileId);
        });
    };

    // Reset form function
    window.resetForm = function() {
        document.getElementById('kelahiranForm').reset();
        newFilesPreview.innerHTML = '';

        // Reset file delete checkboxes
        const deleteCheckboxes = document.querySelectorAll('.delete-checkbox');
        deleteCheckboxes.forEach(cb => {
            cb.checked = false;
            const fileId = cb.value;
            toggleFileDelete(cb, fileId);
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
        }

        // Reset files input
        if (filesInput) {
            filesInput.value = '';
        }
    };

    // Form validation
    const form = document.getElementById('kelahiranForm');
    form.addEventListener('submit', function(e) {
        const noAkta = document.querySelector('input[name="no_akta"]').value;
        const tglLahir = document.querySelector('input[name="tgl_lahir"]').value;
        const tempatLahir = document.querySelector('input[name="tempat_lahir"]').value;

        if (!noAkta || !tglLahir || !tempatLahir) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
            return false;
        }

        // Check file size if any new files
        if (filesInput && filesInput.files.length > 0) {
            let totalSize = 0;
            Array.from(filesInput.files).forEach(file => {
                totalSize += file.size;
            });

            if (totalSize > 10 * 1024 * 1024) { // 10MB total
                e.preventDefault();
                alert('Total ukuran file baru melebihi 10MB!');
                return false;
            }
        }

        // Confirm if deleting all files
        const deleteCheckboxes = document.querySelectorAll('.delete-checkbox:checked');
        const currentFileCount = {{ $kelahiran->media->count() }};
        const newFileCount = filesInput ? filesInput.files.length : 0;

        if (deleteCheckboxes.length === currentFileCount && newFileCount === 0) {
            const confirmDelete = confirm('Anda akan menghapus semua dokumen dan tidak menambahkan yang baru. Lanjutkan?');
            if (!confirmDelete) {
                e.preventDefault();
                return false;
            }
        }

        return true;
    });
});
</script>
@endpush

@push('styles')
<style>
.file-preview {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 10px;
}

.list-group-item {
    margin-bottom: 5px;
}

.list-group-item:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.badge {
    font-size: 0.7em;
}

.card.bg-light {
    background-color: var(--light-color) !important;
}

.file-item {
    transition: all 0.3s ease;
}

.file-item:hover {
    transform: translateY(-2px);
}

.form-check-input:checked {
    background-color: var(--bs-danger);
    border-color: var(--bs-danger);
}
</style>
@endpush
