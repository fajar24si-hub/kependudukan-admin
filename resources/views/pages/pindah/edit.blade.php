{{-- resources/views/pages/pindah/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Peristiwa Pindah')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pindah.index') }}">Peristiwa Pindah</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Data Peristiwa Pindah
                    </h4>
                </div>

                <div class="card-body">
                    <!-- Alert Info Warga -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="alert-heading mb-2">{{ $peristiwaPindah->warga->nama }} - {{ $peristiwaPindah->warga->nik }}</h5>
                                <p class="mb-1">TTL: {{ $peristiwaPindah->warga->tempat_lahir }}, {{ $peristiwaPindah->warga->tanggal_lahir_formatted }}</p>
                                <p class="mb-0">Usia: {{ $peristiwaPindah->warga->usia }} tahun</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('pindah.update', $peristiwaPindah->pindah_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-lg-6">
                                <!-- Section: Data Warga -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Warga</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Pilih Warga <span class="text-danger">*</span></label>
                                            <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required id="warga_id">
                                                <option value="">-- Pilih Warga --</option>
                                                @foreach($warga as $item)
                                                @php
                                                    $jumlahPindah = $item->peristiwaPindah->count();
                                                    $lastPindah = $item->peristiwaPindah->sortByDesc('tgl_pindah')->first();
                                                    $isMeninggal = $item->isMeninggal();
                                                    $statusColor = $isMeninggal ? 'text-danger' : ($jumlahPindah > 0 ? 'text-warning' : 'text-success');
                                                @endphp
                                                <option value="{{ $item->warga_id }}"
                                                    {{ old('warga_id', $peristiwaPindah->warga_id) == $item->warga_id ? 'selected' : '' }}
                                                    data-pindah-count="{{ $jumlahPindah }}"
                                                    data-last-pindah="{{ $lastPindah ? $lastPindah->tgl_pindah : '' }}"
                                                    data-meninggal="{{ $isMeninggal ? '1' : '0' }}"
                                                    class="{{ $statusColor }}">
                                                    {{ $item->nama }} - {{ $item->nik }}
                                                    @if($isMeninggal)
                                                        (Meninggal)
                                                    @elseif($jumlahPindah > 0)
                                                        (Sudah Pindah {{ $jumlahPindah }}x)
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('warga_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="mt-2" id="warga-info">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Pilih warga yang akan didata peristiwa pindahnya
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Data Pindah -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Data Pindah</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tanggal Pindah -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Pindah <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <input type="date" name="tgl_pindah" class="form-control @error('tgl_pindah') is-invalid @enderror"
                                                       value="{{ old('tgl_pindah', $peristiwaPindah->tgl_pindah->format('Y-m-d')) }}" required>
                                            </div>
                                            @error('tgl_pindah')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                            <!-- Info Tanggal Validasi -->
                                            @if($previousPindah)
                                            <div class="alert alert-info mt-3 p-2">
                                                <small>
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    <strong>Perhatian:</strong> Tanggal pindah harus setelah tanggal pindah sebelumnya
                                                    (<strong>{{ \Carbon\Carbon::parse($previousPindah->tgl_pindah)->format('d/m/Y') }}</strong>)
                                                </small>
                                            </div>
                                            @endif

                                            @if($nextPindah)
                                            <div class="alert alert-warning mt-2 p-2">
                                                <small>
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    <strong>Perhatian:</strong> Tanggal pindah harus sebelum tanggal pindah berikutnya
                                                    (<strong>{{ \Carbon\Carbon::parse($nextPindah->tgl_pindah)->format('d/m/Y') }}</strong>)
                                                </small>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="pending" {{ old('status', $peristiwaPindah->status) == 'pending' ? 'selected' : '' }}>
                                                    <span class="badge bg-warning">Pending</span>
                                                </option>
                                                <option value="approved" {{ old('status', $peristiwaPindah->status) == 'approved' ? 'selected' : '' }}>
                                                    <span class="badge bg-success">Disetujui</span>
                                                </option>
                                                <option value="rejected" {{ old('status', $peristiwaPindah->status) == 'rejected' ? 'selected' : '' }}>
                                                    <span class="badge bg-danger">Ditolak</span>
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nomor Surat -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nomor Surat</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                <input type="text" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror"
                                                       value="{{ old('no_surat', $peristiwaPindah->no_surat) }}" placeholder="Masukkan nomor surat">
                                            </div>
                                            @error('no_surat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-lg-6">
                                <!-- Section: Alamat Tujuan -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Alamat Tujuan</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Alamat Tujuan -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea name="alamat_tujuan" class="form-control @error('alamat_tujuan') is-invalid @enderror"
                                                      rows="3" required placeholder="Masukkan alamat lengkap tujuan">{{ old('alamat_tujuan', $peristiwaPindah->alamat_tujuan) }}</textarea>
                                            @error('alamat_tujuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                                                <input type="text" name="kecamatan_tujuan" class="form-control @error('kecamatan_tujuan') is-invalid @enderror"
                                                       value="{{ old('kecamatan_tujuan', $peristiwaPindah->kecamatan_tujuan) }}" required>
                                                @error('kecamatan_tujuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Kabupaten/Kota <span class="text-danger">*</span></label>
                                                <input type="text" name="kabupaten_tujuan" class="form-control @error('kabupaten_tujuan') is-invalid @enderror"
                                                       value="{{ old('kabupaten_tujuan', $peristiwaPindah->kabupaten_tujuan) }}" required>
                                                @error('kabupaten_tujuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Provinsi <span class="text-danger">*</span></label>
                                                <input type="text" name="provinsi_tujuan" class="form-control @error('provinsi_tujuan') is-invalid @enderror"
                                                       value="{{ old('provinsi_tujuan', $peristiwaPindah->provinsi_tujuan) }}" required>
                                                @error('provinsi_tujuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Negara <span class="text-danger">*</span></label>
                                                <input type="text" name="negara_tujuan" class="form-control @error('negara_tujuan') is-invalid @enderror"
                                                       value="{{ old('negara_tujuan', $peristiwaPindah->negara_tujuan) }}" required>
                                                @error('negara_tujuan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Keterangan & Dokumen -->
                                <div class="card border mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Keterangan & Dokumen</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Alasan -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alasan Pindah <span class="text-danger">*</span></label>
                                            <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                                                      rows="3" required placeholder="Jelaskan alasan pindah">{{ old('alasan', $peristiwaPindah->alasan) }}</textarea>
                                            @error('alasan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Keterangan Tambahan</label>
                                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                                      rows="2" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $peristiwaPindah->keterangan) }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Dokumen -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Dokumen Pendukung</label>
                                            <input type="file" name="dokumen" class="form-control @error('dokumen') is-invalid @enderror"
                                                   accept=".pdf,.jpg,.jpeg,.png">
                                            @error('dokumen')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format: PDF, JPG, JPEG, PNG | Maks: 2MB
                                            </small>

                                            <!-- Dokumen yang sudah ada -->
                                            @if($peristiwaPindah->media->count() > 0)
                                            <div class="mt-3">
                                                <label class="form-label fw-semibold">Dokumen Terupload:</label>
                                                <div class="list-group">
                                                    @foreach($peristiwaPindah->media as $media)
                                                    <div class="list-group-item list-group-item-action">
                                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                                            <div>
                                                                <i class="{{ $media->icon }} me-2"></i>
                                                                <span>{{ $media->file_name }}</span>
                                                            </div>
                                                            <div>
                                                                <a href="{{ $media->url }}" target="_blank" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeFile({{ $media->media_id }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="card border mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('pindah.show', $peristiwaPindah->pindah_id) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                        <a href="{{ route('pindah.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Batal
                                        </a>
                                    </div>
                                    <div>
                                        <button type="reset" class="btn btn-warning me-2">
                                            <i class="fas fa-redo me-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .card-header.bg-light {
        background-color: rgba(0,0,0,.03) !important;
    }
    select option.text-danger {
        color: #dc3545 !important;
        background-color: #fff8f8;
    }
    select option.text-warning {
        color: #ffc107 !important;
        background-color: #fff9e6;
    }
    select option.text-success {
        color: #198754 !important;
        background-color: #f0fff4;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wargaSelect = document.getElementById('warga_id');
    const wargaInfo = document.getElementById('warga-info');

    function updateWargaInfo() {
        const selectedOption = wargaSelect.options[wargaSelect.selectedIndex];
        const pindahCount = selectedOption.getAttribute('data-pindah-count') || 0;
        const lastPindah = selectedOption.getAttribute('data-last-pindah');
        const isMeninggal = selectedOption.getAttribute('data-meninggal');

        let info = '';
        let infoClass = 'text-muted';

        if (selectedOption.value === '') {
            info = '<i class="fas fa-info-circle me-1"></i> Pilih warga untuk melihat informasi';
        } else if (isMeninggal === '1') {
            info = '<i class="fas fa-exclamation-triangle me-1"></i> <span class="text-danger">Warga ini sudah meninggal!</span>';
            infoClass = 'text-danger';
        } else if (pindahCount > 0) {
            info = `<i class="fas fa-history me-1"></i> Sudah pernah pindah <strong>${pindahCount}</strong> kali`;
            if (lastPindah) {
                const lastDate = new Date(lastPindah).toLocaleDateString('id-ID');
                info += ` (Terakhir: ${lastDate})`;
            }
            infoClass = 'text-warning';
        } else {
            info = '<i class="fas fa-check-circle me-1"></i> Belum pernah pindah';
            infoClass = 'text-success';
        }

        wargaInfo.innerHTML = `<small class="${infoClass}">${info}</small>`;
    }

    wargaSelect.addEventListener('change', updateWargaInfo);
    updateWargaInfo(); // Initial call

    // Format tanggal untuk placeholder
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tgl_pindah"]').setAttribute('max', today);
});

function removeFile(mediaId) {
    if (confirm('Yakin ingin menghapus dokumen ini?')) {
        fetch(`/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus dokumen');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
@endpush
