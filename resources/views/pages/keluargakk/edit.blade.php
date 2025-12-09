@extends('layouts.app')

@section('title', 'Edit Data Keluarga KK')
@section('subtitle', 'Perbarui data kartu keluarga')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('keluargakk.index') }}">Data Keluarga KK</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Data Keluarga</h5>
                        <div class="badge bg-primary">
                            ID: {{ $keluarga->kk_id }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('keluargakk.update', $keluarga->kk_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nomor KK <span class="text-danger">*</span></label>
                                <input type="text" name="kk_nomor"
                                    class="form-control @error('kk_nomor') is-invalid @enderror"
                                    value="{{ old('kk_nomor', $keluarga->kk_nomor) }}" required>
                                @error('kk_nomor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ID Kepala Keluarga <span class="text-danger">*</span></label>
                                <input type="number" name="kepala_keluarga_warga_id"
                                    class="form-control @error('kepala_keluarga_warga_id') is-invalid @enderror"
                                    value="{{ old('kepala_keluarga_warga_id', $keluarga->kepala_keluarga_warga_id) }}"
                                    required>
                                @error('kepala_keluarga_warga_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror"
                                    value="{{ old('rt', $keluarga->rt) }}" maxlength="3" required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="rw" class="form-control @error('rw') is-invalid @enderror"
                                    value="{{ old('rw', $keluarga->rw) }}" maxlength="3" required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Informasi</h6>
                                        <div class="mb-2">
                                            <small class="text-muted">Dibuat:</small>
                                            <div>{{ $keluarga->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                        <div>
                                            <small class="text-muted">Diperbarui:</small>
                                            <div>{{ $keluarga->updated_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Perbarui Data
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
