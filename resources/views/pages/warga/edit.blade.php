@extends('layouts.app')

@section('title', 'Edit Warga')
@section('subtitle', 'Perbarui data warga yang sudah ada')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('warga.index') }}">Data Warga</a></li>
<li class="breadcrumb-item active">Edit Warga</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Edit Data Warga</h5>
                    <div class="badge bg-primary">
                        ID: {{ $warga->warga_id }}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="mb-3 border-bottom pb-2">Informasi Pribadi</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                   value="{{ old('nik', $warga->nik) }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $warga->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                   value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                   value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Usia: {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->age }} tahun</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama <span class="text-danger">*</span></label>
                            <select name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                @php
                                    $agamaOptions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                                @endphp
                                @foreach($agamaOptions as $agama)
                                    <option value="{{ $agama }}" {{ old('agama', $warga->agama) == $agama ? 'selected' : '' }}>
                                        {{ $agama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="mb-3 border-bottom pb-2 mt-4">Informasi Pendidikan & Pekerjaan</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan <span class="text-danger">*</span></label>
                            <select name="pendidikan" class="form-select @error('pendidikan') is-invalid @enderror" required>
                                @php
                                    $pendidikanOptions = [
                                        'Tidak Sekolah', 'SD', 'SMP', 'SMA',
                                        'D1/D2/D3', 'S1', 'S2', 'S3'
                                    ];
                                @endphp
                                @foreach($pendidikanOptions as $pendidikan)
                                    <option value="{{ $pendidikan }}" {{ old('pendidikan', $warga->pendidikan) == $pendidikan ? 'selected' : '' }}>
                                        {{ $pendidikan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror"
                                   value="{{ old('pekerjaan', $warga->pekerjaan) }}" required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="mb-3 border-bottom pb-2 mt-4">Status</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                            <select name="status_perkawinan" class="form-select @error('status_perkawinan') is-invalid @enderror" required>
                                @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)
                                    <option value="{{ $status }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_perkawinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Dalam Keluarga <span class="text-danger">*</span></label>
                            <input type="text" name="status_dalam_keluarga" class="form-control @error('status_dalam_keluarga') is-invalid @enderror"
                                   value="{{ old('status_dalam_keluarga', $warga->status_dalam_keluarga) }}" required>
                            @error('status_dalam_keluarga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Informasi Sistem</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Dibuat:</small>
                                        <div>{{ $warga->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div>
                                        <small class="text-muted">Diperbarui:</small>
                                        <div>{{ $warga->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Perbarui Data
                        </button>
                        <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
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
    // Format NIK input (16 digit)
    const nikInput = document.querySelector('input[name="nik"]');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    }

    // Set max date for tanggal lahir (today)
    const tanggalLahirInput = document.querySelector('input[name="tanggal_lahir"]');
    if (tanggalLahirInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalLahirInput.max = today;
    }
});
</script>
@endpush
