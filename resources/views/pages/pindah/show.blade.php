{{-- resources/views/pages/pindah/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Peristiwa Pindah')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pindah.index') }}">Peristiwa Pindah</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pindah.index') }}">Peristiwa Pindah</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-eye me-2"></i>Detail Peristiwa Pindah
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Card: Informasi Utama -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Peristiwa Pindah
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger'
                            ];
                            $statusIcons = [
                                'pending' => 'fa-clock',
                                'approved' => 'fa-check-circle',
                                'rejected' => 'fa-times-circle'
                            ];
                            $statusText = [
                                'pending' => 'PENDING',
                                'approved' => 'DISETUJUI',
                                'rejected' => 'DITOLAK'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$peristiwaPindah->status] ?? 'secondary' }} fs-5 p-3">
                            <i class="fas {{ $statusIcons[$peristiwaPindah->status] ?? 'fa-question' }} me-2"></i>
                            {{ $statusText[$peristiwaPindah->status] ?? strtoupper($peristiwaPindah->status) }}
                        </span>
                    </div>

                    <div class="row">
                        <!-- Data Warga -->
                        <div class="col-md-6 mb-4">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Warga</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="avatar-lg mx-auto mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user fa-2x text-white"></i>
                                        </div>
                                        <h5>{{ $peristiwaPindah->warga->nama }}</h5>
                                        <p class="text-muted">NIK: {{ $peristiwaPindah->warga->nik }}</p>
                                    </div>

                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Jenis Kelamin</strong></td>
                                            <td>{{ $peristiwaPindah->warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>TTL</strong></td>
                                            <td>{{ $peristiwaPindah->warga->tempat_lahir ?? '-' }}, {{ $peristiwaPindah->warga->tanggal_lahir ? \Carbon\Carbon::parse($peristiwaPindah->warga->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Usia</strong></td>
                                            <td>
                                                @if($peristiwaPindah->warga->tanggal_lahir)
                                                    {{ \Carbon\Carbon::parse($peristiwaPindah->warga->tanggal_lahir)->age }} tahun
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pekerjaan</strong></td>
                                            <td>{{ $peristiwaPindah->warga->pekerjaan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pindah -->
                        <div class="col-md-6 mb-4">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Data Pindah</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="avatar-lg mx-auto mb-3 bg-info rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-calendar-alt fa-2x text-white"></i>
                                        </div>
                                        <h5 class="text-primary">
                                            {{ \Carbon\Carbon::parse($peristiwaPindah->tgl_pindah)->format('d/m/Y') }}
                                        </h5>
                                        <p class="text-muted">Tanggal Pindah</p>
                                    </div>

                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>No. Surat</strong></td>
                                            <td>
                                                @if($peristiwaPindah->no_surat)
                                                    <span class="badge bg-info">{{ $peristiwaPindah->no_surat }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat</strong></td>
                                            <td>{{ $peristiwaPindah->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diperbarui</strong></td>
                                            <td>{{ $peristiwaPindah->updated_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Tujuan -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Alamat Tujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap:</label>
                                <div class="alert alert-light">
                                    <i class="fas fa-home me-2"></i>
                                    {{ $peristiwaPindah->alamat_tujuan }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="card border">
                                        <div class="card-body text-center py-2">
                                            <small class="text-muted d-block">Kecamatan</small>
                                            <strong>{{ $peristiwaPindah->kecamatan_tujuan }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card border">
                                        <div class="card-body text-center py-2">
                                            <small class="text-muted d-block">Kabupaten/Kota</small>
                                            <strong>{{ $peristiwaPindah->kabupaten_tujuan }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card border">
                                        <div class="card-body text-center py-2">
                                            <small class="text-muted d-block">Provinsi</small>
                                            <strong>{{ $peristiwaPindah->provinsi_tujuan }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="card border">
                                        <div class="card-body text-center py-2">
                                            <small class="text-muted d-block">Negara</small>
                                            <strong>{{ $peristiwaPindah->negara_tujuan }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alasan dan Keterangan -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-comment me-2"></i>Alasan Pindah</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $peristiwaPindah->alasan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Keterangan</h6>
                                </div>
                                <div class="card-body">
                                    @if($peristiwaPindah->keterangan)
                                        <p>{{ $peristiwaPindah->keterangan }}</p>
                                    @else
                                        <p class="text-muted text-center py-3">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Tidak ada keterangan tambahan
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            @if($peristiwaPindah->media && $peristiwaPindah->media->count() > 0)
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Dokumen Pendukung
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($peristiwaPindah->media as $media)
                        <div class="col-md-4 mb-3">
                            <div class="card border document-card">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        @if($media->is_image)
                                            <i class="fas fa-image fa-4x text-success"></i>
                                        @elseif($media->is_pdf)
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                        @else
                                            <i class="fas fa-file fa-4x text-primary"></i>
                                        @endif
                                    </div>
                                    <h6 class="document-title">{{ Str::limit($media->file_name, 25) }}</h6>
                                    <small class="text-muted d-block mb-2">{{ $media->file_type }}</small>
                                    <div>
                                        <a href="{{ $media->url }}" target="_blank" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ $media->url }}" download class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Kanan -->
        <div class="col-lg-4">
            <!-- Card: Aksi -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <!-- Edit Button -->
                        <a href="{{ route('pindah.edit', $peristiwaPindah->pindah_id) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>

                        <!-- SIMPLE FORM FOR STATUS UPDATE - PASTI BERHASIL -->
                        @if($peristiwaPindah->status != 'approved')
                        <form action="{{ route('pindah.updateStatus', $peristiwaPindah->pindah_id) }}" method="POST" class="d-grid">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success btn-lg mb-2">
                                <i class="fas fa-check-circle me-2"></i>Setujui Pindah
                            </button>
                        </form>
                        @endif

                        @if($peristiwaPindah->status != 'rejected')
                        <form action="{{ route('pindah.updateStatus', $peristiwaPindah->pindah_id) }}" method="POST" class="d-grid">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-lg mb-2">
                                <i class="fas fa-times-circle me-2"></i>Tolak Pindah
                            </button>
                        </form>
                        @endif

                        <!-- Delete Button with Modal -->
                        <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus Data
                        </button>

                        <!-- Back Button -->
                        <a href="{{ route('pindah.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pindah -->
            @if(isset($riwayatPindah) && $riwayatPindah->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Pindah
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($riwayatPindah as $pindah)
                        <a href="{{ route('pindah.show', $pindah->pindah_id) }}"
                           class="list-group-item list-group-item-action {{ $pindah->pindah_id == $peristiwaPindah->pindah_id ? 'active' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ \Carbon\Carbon::parse($pindah->tgl_pindah)->format('d/m/Y') }}</h6>
                                <small>
                                    @if($pindah->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($pindah->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </small>
                            </div>
                            <p class="mb-1 small">{{ Str::limit($pindah->alasan, 50) }}</p>
                            <small>{{ $pindah->kecamatan_tujuan }}, {{ $pindah->kabupaten_tujuan }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistik Warga -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0">
                                    @if(isset($riwayatPindah))
                                        {{ $riwayatPindah->count() + 1 }}
                                    @else
                                        1
                                    @endif
                                </h4>
                                <small class="text-muted">Total Pindah</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-calendar-alt fa-2x text-success mb-2"></i>
                                <h4 class="mb-0">
                                    @if($peristiwaPindah->warga->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($peristiwaPindah->warga->tanggal_lahir)->age }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <small class="text-muted">Usia (tahun)</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Data terakhir diperbarui: {{ $peristiwaPindah->updated_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data peristiwa pindah ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Perhatian:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                </div>
                <table class="table table-sm">
                    <tr>
                        <th>Warga</th>
                        <td>{{ $peristiwaPindah->warga->nama }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ \Carbon\Carbon::parse($peristiwaPindah->tgl_pindah)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Tujuan</th>
                        <td>{{ $peristiwaPindah->kecamatan_tujuan }}, {{ $peristiwaPindah->kabupaten_tujuan }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <form action="{{ route('pindah.destroy', $peristiwaPindah->pindah_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-lg {
        width: 80px;
        height: 80px;
    }
    .document-card {
        transition: transform 0.2s;
    }
    .document-card:hover {
        transform: translateY(-5px);
    }
    .document-title {
        font-size: 0.9rem;
        font-weight: 600;
        word-break: break-word;
    }
</style>
@endpush

@push('scripts')
<script>
// Auto-hide alerts setelah 5 detik
setTimeout(function() {
    $('.alert').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 5000);

// Tooltip initialization
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip()
});

// Confirm sebelum submit form status
document.querySelectorAll('form[action*="updateStatus"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        const status = this.querySelector('input[name="status"]').value;
        const statusText = status === 'approved' ? 'menyetujui' : 'menolak';

        if (!confirm(`Anda yakin ingin ${statusText} peristiwa pindah ini?`)) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
