@extends('layouts.app')

@section('title', 'Tambah Data Keluarga KK')
@section('subtitle', 'Tambahkan data kartu keluarga baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('keluargakk.index') }}">Data Keluarga KK</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Data Keluarga</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('keluargakk.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nomor KK <span class="text-danger">*</span></label>
                                <input type="text" name="kk_nomor"
                                    class="form-control @error('kk_nomor') is-invalid @enderror"
                                    value="{{ old('kk_nomor') }}" placeholder="Masukkan nomor KK" required>
                                @error('kk_nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: 16 digit angka</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ID Kepala Keluarga <span class="text-danger">*</span></label>
                                <input type="number" name="kepala_keluarga_warga_id"
                                    class="form-control @error('kepala_keluarga_warga_id') is-invalid @enderror"
                                    value="{{ old('kepala_keluarga_warga_id') }}" placeholder="Masukkan ID kepala keluarga"
                                    required>
                                @error('kepala_keluarga_warga_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">ID warga yang menjadi kepala keluarga</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror"
                                    value="{{ old('rt') }}" placeholder="Contoh: 001" maxlength="3" required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror"
                                    value="{{ old('rw') }}" placeholder="Contoh: 002" maxlength="3" required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                            <a href="{{ route('keluargakk.index') }}" class="btn btn-outline-secondary">
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
            // Format input RT/RW
            const rtInput = document.querySelector('input[name="rt"]');
            const rwInput = document.querySelector('input[name="rw"]');

            function formatRT(input) {
                let value = input.value.replace(/\D/g, '');
                if (value.length === 1) {
                    value = '00' + value;
                } else if (value.length === 2) {
                    value = '0' + value;
                }
                input.value = value;
            }

            if (rtInput) {
                rtInput.addEventListener('blur', function() {
                    formatRT(this);
                });
            }

            if (rwInput) {
                rwInput.addEventListener('blur', function() {
                    formatRT(this);
                });
            }
        });
    </script>
@endpush
