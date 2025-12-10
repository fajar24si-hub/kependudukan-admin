{{-- resources/views/pages/kematian/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Data Kematian')
@section('subtitle', 'Informasi lengkap peristiwa kematian')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('peristiwa-kematian.index') }}">Data Kematian</a></li>
<li class="breadcrumb-item active">Detail Data</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Detail Data Kematian</h5>
                        <div class="badge bg-primary mt-1">
                            ID: {{ $kematian->kematian_id }}
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('peristiwa-kematian.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Informasi Kematian -->
                        <div class="card border mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-cross me-2"></i> Informasi Kematian
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">No. Surat Kematian</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            <strong>{{ $kematian->no_surat }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Meninggal</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ $kematian->tgl_meninggal ? \Carbon\Carbon::parse($kematian->tgl_meninggal)->format('d/m/Y') : '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sebab Meninggal</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ $kematian->sebab ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi Meninggal</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ $kematian->lokasi ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Dibuat</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ $kematian->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Terakhir Diupdate</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ $kematian->updated_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>

                                @if($kematian->tgl_meninggal)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Meninggal Sejak</label>
                                        <div class="form-control bg-light" style="cursor: not-allowed;">
                                            {{ \Carbon\Carbon::parse($kematian->tgl_meninggal)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Warga -->
                        <div class="card border mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i> Informasi Warga
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($kematian->warga)
                                <div class="row">
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="avatar-xl bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                            <i class="fas fa-user fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="mb-2">{{ $kematian->warga->nama_lengkap }}</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-id-card me-2 text-muted"></i>
                                                    <strong>NIK:</strong> {{ $kematian->warga->nik }}
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-birthday-cake me-2 text-muted"></i>
                                                    <strong>Tanggal Lahir:</strong>
                                                    @if($kematian->warga->tanggal_lahir)
                                                        {{ \Carbon\Carbon::parse($kematian->warga->tanggal_lahir)->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-venus-mars me-2 text-muted"></i>
                                                    <strong>Jenis Kelamin:</strong>
                                                    {{ $kematian->warga->jenis_kelamin ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                                    <strong>Alamat:</strong>
                                                </p>
                                                <p class="mb-0 small">
                                                    {{ $kematian->warga->alamat ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Data warga tidak ditemukan</h6>
                                    <p class="small mb-0">Data warga mungkin telah dihapus dari sistem</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Dokumen Pendukung -->
                        <div class="card border mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-file-alt me-2"></i> Dokumen Pendukung
                                    <span class="badge bg-info ms-2">{{ $kematian->media->count() }}</span>
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($kematian->media->count() > 0)
                                    <div class="row">
                                        @foreach($kematian->media as $media)
                                        <div class="col-md-12 mb-3">
                                            <div class="card border h-100">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            @if(in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif']))
                                                                <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                   target="_blank" class="d-block mb-2">
                                                                    <img src="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                         class="rounded"
                                                                         style="width: 80px; height: 80px; object-fit: cover;"
                                                                         alt="{{ $media->caption }}"
                                                                         onerror="this.onerror=null; this.src='{{ asset('img/placeholder-doc.png') }}'">
                                                                </a>
                                                            @else
                                                                <div class="text-center">
                                                                    <i class="fas fa-file fa-2x text-primary"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1 text-truncate" title="{{ $media->caption }}">
                                                                {{ $media->caption }}
                                                            </h6>
                                                            <p class="small text-muted mb-2">
                                                                {{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                                                • {{ \Carbon\Carbon::parse($media->created_at)->format('d/m/Y H:i') }}
                                                            </p>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                   target="_blank" class="btn btn-outline-primary">
                                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                                </a>
                                                                <a href="{{ Storage::url('public/media/' . $media->file_name) }}"
                                                                   download class="btn btn-outline-success">
                                                                    <i class="fas fa-download me-1"></i> Unduh
                                                                </a>
                                                            </div>
                                                        </div>
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

                        <!-- Quick Stats -->
                        <div class="card border">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i> Statistik
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h4 class="mb-0">{{ $kematian->media->count() }}</h4>
                                            <small class="text-muted">Dokumen</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h4 class="mb-0">
                                                @if($kematian->created_at->diffInDays(now()) <= 7)
                                                    <span class="badge bg-success">Baru</span>
                                                @else
                                                    {{ $kematian->created_at->diffInDays(now()) }}
                                                @endif
                                            </h4>
                                            <small class="text-muted">Hari lalu</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('peristiwa-kematian.edit', $kematian->kematian_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>
                    <form action="{{ route('peristiwa-kematian.destroy', $kematian->kematian_id) }}" method="POST" class="d-inline"
                        onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus Data
                        </button>
                    </form>
                    <a href="{{ route('peristiwa-kematian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-1"></i> Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus data kematian ini? Aksi ini tidak dapat dibatalkan!');
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
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.img-fluid {
    transition: transform 0.3s ease;
}

.img-fluid:hover {
    transform: scale(1.05);
}

.avatar-xl {
    width: 100px;
    height: 100px;
}

.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}
</style>
@endpush
