@extends('layouts.app')

@section('title', 'Tambah Data Kematian')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('peristiwa-kematian.index') }}">Data Kematian</a></li>
<li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Data Kematian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('peristiwa-kematian.store') }}" method="POST" enctype="multipart/form-data" id="kematianForm">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cross me-2"></i> Informasi Kematian</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Warga -->
                                    <div class="mb-3">
                                        <label class="form-label">Warga <span class="text-danger">*</span></label>
                                        <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required>
                                            <option value="">Pilih Warga...</option>
                                            @foreach($wargas as $warga)
                                                <option value="{{ $warga->warga_id }}" {{ old('warga_id') == $warga->warga_id ? 'selected' : '' }}>
                                                    {{ $warga->nama }} - {{ $warga->nik }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warga_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Pilih warga yang meninggal</small>
                                    </div>

                                    <!-- No Surat -->
                                    <div class="mb-3">
                                        <label class="form-label">No. Surat Kematian <span class="text-danger">*</span></label>
                                        <input type="text" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror"
                                               value="{{ old('no_surat') }}" placeholder="Masukkan nomor surat kematian" required>
                                        @error('no_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Nomor surat harus unik</small>
                                    </div>

                                    <!-- Tanggal Meninggal -->
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Meninggal <span class="text-danger">*</span></label>
                                        <input type="date" name="tgl_meninggal" class="form-control @error('tgl_meninggal') is-invalid @enderror"
                                               value="{{ old('tgl_meninggal') }}" required max="{{ date('Y-m-d') }}">
                                        @error('tgl_meninggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: DD/MM/YYYY, tidak boleh lebih dari hari ini</small>
                                    </div>

                                    <!-- Sebab -->
                                    <div class="mb-3">
                                        <label class="form-label">Sebab Meninggal <span class="text-danger">*</span></label>
                                        <input type="text" name="sebab" class="form-control @error('sebab') is-invalid @enderror"
                                               value="{{ old('sebab') }}" placeholder="Masukkan sebab kematian" required>
                                        @error('sebab')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Contoh: Sakit, Kecelakaan, dll</small>
                                    </div>

                                    <!-- Lokasi -->
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi Meninggal <span class="text-danger">*</span></label>
                                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                                               value="{{ old('lokasi') }}" placeholder="Masukkan lokasi kematian" required>
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Contoh: Rumah Sakit, Rumah, Jalan, dll</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Dokumen Pendukung -->
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i> Dokumen Pendukung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Upload Dokumen</label>
                                        <input type="file" name="files[]" class="form-control" multiple
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, XLS. Maksimal 5MB per file.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                        <a href="{{ route('peristiwa-kematian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kematianForm');

    form.addEventListener('submit', function(e) {
        const requiredFields = [
            'warga_id', 'no_surat', 'tgl_meninggal', 'sebab', 'lokasi'
        ];

        let isValid = true;
        let firstEmptyField = null;

        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                isValid = false;
                if (!firstEmptyField) {
                    firstEmptyField = field;
                }
                field.classList.add('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang wajib diisi!');
            if (firstEmptyField) {
                firstEmptyField.focus();
            }
            return false;
        }

        return true;
    });
});
</script>
@endpush
@endsection
