@extends('layouts.app')

@section('title', 'Tambah Data Kelahiran')
@section('subtitle', 'Tambahkan data peristiwa kelahiran baru')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('peristiwa-kelahiran.index') }}">Data Kelahiran</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Form Tambah Data Kelahiran</h5>
                    <div>
                        <a href="{{ route('peristiwa-kelahiran.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('peristiwa-kelahiran.store') }}" method="POST" enctype="multipart/form-data" id="kelahiranForm">
                    @csrf

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
                                                   value="{{ old('no_akta') }}"
                                                   placeholder="Masukkan nomor akta"
                                                   required minlength="3" maxlength="100" autofocus>
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
                                                   value="{{ old('tgl_lahir') }}" required>
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
                                                   value="{{ old('tempat_lahir') }}"
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
                                                   value="{{ old('jam_lahir') }}">
                                            @error('jam_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Opsional, format: HH:MM</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-alt me-2"></i> Dokumen Pendukung
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Upload Dokumen
                                        </label>
                                        <input type="file" name="files[]"
                                               class="form-control @error('files.*') is-invalid @enderror"
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx"
                                               id="filesInput" multiple onchange="previewFiles(this)">
                                        @error('files.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: JPG, PNG, PDF, DOC, XLS. Maksimal 5MB per file.
                                        </small>
                                    </div>

                                    <div class="file-preview" id="filePreview"></div>

                                    <div class="mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="no_document"
                                                   id="noDocument">
                                            <label class="form-check-label small" for="noDocument">
                                                <i class="fas fa-check me-1"></i> Tidak ada dokumen
                                            </label>
                                        </div>
                                        <small class="text-muted">
                                            Jika dicentang, tidak perlu upload dokumen
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-1"></i> Reset Form
                        </button>
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
    const filePreview = document.getElementById('filePreview');
    const noDocumentCheckbox = document.getElementById('noDocument');

    // Preview files function
    window.previewFiles = function(input) {
        const files = input.files;
        filePreview.innerHTML = '';

        if (files.length === 0) {
            return;
        }

        // Update label
        const label = input.nextElementSibling;

        // Create file list
        const fileList = document.createElement('div');
        fileList.className = 'list-group mt-3';

        Array.from(files).forEach((file, index) => {
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const extension = file.name.split('.').pop().toUpperCase();

            const fileItem = document.createElement('div');
            fileItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-file text-primary me-2"></i>
                    <div>
                        <small class="d-block fw-bold">${file.name}</small>
                        <small class="text-muted">${fileSize} MB • ${extension}</small>
                    </div>
                </div>
                <span class="badge bg-light text-dark">${index + 1}</span>
            `;
            fileList.appendChild(fileItem);
        });

        filePreview.appendChild(fileList);
    };

    // Handle no document checkbox
    if (noDocumentCheckbox) {
        noDocumentCheckbox.addEventListener('change', function() {
            filesInput.disabled = this.checked;
            if (this.checked) {
                filesInput.value = '';
                filePreview.innerHTML = '';
            }
        });
    }

    // Reset form function
    window.resetForm = function() {
        document.getElementById('kelahiranForm').reset();
        filePreview.innerHTML = '';
        if (noDocumentCheckbox) {
            noDocumentCheckbox.checked = false;
            filesInput.disabled = false;
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

        // Check file size if any
        if (filesInput.files.length > 0 && !noDocumentCheckbox.checked) {
            let totalSize = 0;
            Array.from(filesInput.files).forEach(file => {
                totalSize += file.size;
            });

            if (totalSize > 10 * 1024 * 1024) { // 10MB total
                e.preventDefault();
                alert('Total ukuran file melebihi 10MB!');
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
    border-left: 3px solid var(--bs-primary);
    margin-bottom: 5px;
}

.list-group-item:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.badge {
    font-size: 0.7em;
}
</style>
@endpush
