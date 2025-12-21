@extends('layouts.app')

@section('title', 'Detail Data Kelahiran')
@section('subtitle', 'Informasi lengkap peristiwa kelahiran')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('peristiwa-kelahiran.index') }}">Data Kelahiran</a></li>
    <li class="breadcrumb-item active">Detail Data</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Detail Data Kelahiran</h5>
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
                                            <label class="form-label">No. Akta Kelahiran</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                <strong>{{ $kelahiran->no_akta }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $kelahiran->tgl_lahir ? \Carbon\Carbon::parse($kelahiran->tgl_lahir)->format('d/m/Y') : '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tempat Lahir</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $kelahiran->tempat_lahir ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jam Lahir</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $kelahiran->jam_lahir ?? '-' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Dibuat</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $kelahiran->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Terakhir Diupdate</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $kelahiran->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($kelahiran->tgl_lahir)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Usia Saat Ini</label>
                                                <div class="form-control bg-light" style="cursor: not-allowed;">
                                                    {{ \Carbon\Carbon::parse($kelahiran->tgl_lahir)->age }} tahun
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card border mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-users me-2"></i> Informasi Keluarga
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-primary bg-opacity-10 border-primary h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-baby text-primary me-2"></i> Bayi
                                                </h6>
                                                @if ($kelahiran->warga)
                                                    <p class="mb-1"><strong>{{ $kelahiran->warga->nama }}</strong></p>
                                                    <small class="text-muted">NIK: {{ $kelahiran->warga->nik }}</small>
                                                @else
                                                    <p class="text-muted mb-0">Data bayi tidak ditemukan</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-success bg-opacity-10 border-success h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-male text-success me-2"></i> Ayah
                                                </h6>
                                                @if ($kelahiran->ayah)
                                                    <p class="mb-1"><strong>{{ $kelahiran->ayah->nama }}</strong></p>
                                                    <small class="text-muted">NIK: {{ $kelahiran->ayah->nik }}</small>
                                                @else
                                                    <p class="text-muted mb-0">Data ayah tidak ditemukan</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card bg-danger bg-opacity-10 border-danger h-100">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-female text-danger me-2"></i> Ibu
                                                </h6>
                                                @if ($kelahiran->ibu)
                                                    <p class="mb-1"><strong>{{ $kelahiran->ibu->nama }}</strong></p>
                                                    <small class="text-muted">NIK: {{ $kelahiran->ibu->nik }}</small>
                                                @else
                                                    <p class="text-muted mb-0">Data ibu tidak ditemukan</p>
                                                @endif
                                            </div>
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
                                        <span class="badge bg-info ms-2">{{ $kelahiran->media->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if ($kelahiran->media->count() > 0)
                                        <div class="row">
                                            @foreach ($kelahiran->media as $media)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border h-100">
                                                        <div class="card-body text-center">
                                                            @if (in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif']))
                                                                <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                    target="_blank" class="d-block mb-2">
                                                                    <img src="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                        class="img-fluid rounded"
                                                                        style="height: 100px; object-fit: cover;"
                                                                        alt="{{ $media->caption }}"
                                                                        onerror="this.onerror=null; this.src='{{ asset('img/placeholder-doc.png') }}'">
                                                                </a>
                                                            @else
                                                                <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                    target="_blank"
                                                                    class="d-block mb-2 text-decoration-none">
                                                                    <div class="py-3">
                                                                        <i class="fas fa-file fa-2x text-primary"></i>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                            <p class="small mb-1 text-truncate"
                                                                title="{{ $media->caption }}">
                                                                {{ $media->caption }}
                                                            </p>
                                                            <p class="small text-muted mb-2">
                                                                {{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                                            </p>
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
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada dokumen</h6>
                                            <p class="small mb-0">Belum ada dokumen yang diupload</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('peristiwa-kelahiran.edit', $kelahiran->kelahiran_id) }}"
                            class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit Data
                        </a>
                        <form action="{{ route('peristiwa-kelahiran.destroy', $kelahiran->kelahiran_id) }}"
                            method="POST" class="d-inline" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data kelahiran ini? Aksi ini tidak dapat dibatalkan!');
        }
    </script>
@endpush

@push('styles')
    <style>
        .form-control[style*="cursor: not-allowed"] {
            background-color: var(--light-color) !important;
            border-color: #dee2e6 !important;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .img-fluid {
            transition: transform 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.05);
        }
    </style>
@endpush
