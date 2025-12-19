{{-- resources/views/pages/pindah/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Peristiwa Pindah')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pindah.index') }}">Peristiwa Pindah</a></li>
                        <li class="breadcrumb-item active">Tambah Data</li>
                    </ol>
                </div>
                <h4 class="page-title">Tambah Peristiwa Pindah</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pindah.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- Warga -->
                                <div class="mb-3">
                                    <label class="form-label">Warga <span class="text-danger">*</span></label>
                                    <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror" required id="warga_id">
                                        <option value="">Pilih warga...</option>
                                        @foreach($warga as $item)
                                        @php
                                            $jumlahPindah = $item->peristiwaPindah->count();
                                            $lastPindah = $item->peristiwaPindah->sortByDesc('tgl_pindah')->first();
                                            $isMeninggal = $item->isMeninggal();
                                        @endphp
                                        <option value="{{ $item->warga_id }}"
                                            {{ old('warga_id') == $item->warga_id ? 'selected' : '' }}
                                            data-pindah-count="{{ $jumlahPindah }}"
                                            data-last-pindah="{{ $lastPindah ? $lastPindah->tgl_pindah : '' }}"
                                            data-meninggal="{{ $isMeninggal ? '1' : '0' }}">
                                            {{ $item->nama }} - {{ $item->nik }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('warga_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted" id="warga-info"></small>
                                </div>

                                <!-- Tanggal Pindah -->
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pindah <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_pindah" class="form-control @error('tgl_pindah') is-invalid @enderror"
                                           value="{{ old('tgl_pindah') }}" required>
                                    @error('tgl_pindah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alamat Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label">Alamat Tujuan <span class="text-danger">*</span></label>
                                    <textarea name="alamat_tujuan" class="form-control @error('alamat_tujuan') is-invalid @enderror"
                                              rows="3" required>{{ old('alamat_tujuan') }}</textarea>
                                    @error('alamat_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Kecamatan Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" name="kecamatan_tujuan" class="form-control @error('kecamatan_tujuan') is-invalid @enderror"
                                           value="{{ old('kecamatan_tujuan') }}" required>
                                    @error('kecamatan_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <!-- Kabupaten/Kota Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" name="kabupaten_tujuan" class="form-control @error('kabupaten_tujuan') is-invalid @enderror"
                                           value="{{ old('kabupaten_tujuan') }}" required>
                                    @error('kabupaten_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Provinsi Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label">Provinsi Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" name="provinsi_tujuan" class="form-control @error('provinsi_tujuan') is-invalid @enderror"
                                           value="{{ old('provinsi_tujuan') }}" required>
                                    @error('provinsi_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Negara Tujuan -->
                                <div class="mb-3">
                                    <label class="form-label">Negara Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" name="negara_tujuan" class="form-control @error('negara_tujuan') is-invalid @enderror"
                                           value="{{ old('negara_tujuan', 'Indonesia') }}" required>
                                    @error('negara_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alasan Pindah -->
                                <div class="mb-3">
                                    <label class="form-label">Alasan Pindah <span class="text-danger">*</span></label>
                                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                                              rows="3" required>{{ old('alasan') }}</textarea>
                                    @error('alasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nomor Surat -->
                                <div class="mb-3">
                                    <label class="form-label">Nomor Surat</label>
                                    <input type="text" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror"
                                           value="{{ old('no_surat') }}">
                                    @error('no_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Dokumen -->
                                <div class="mb-3">
                                    <label class="form-label">Dokumen Pendukung</label>
                                    <input type="file" name="dokumen" class="form-control @error('dokumen') is-invalid @enderror"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    @error('dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Maks: 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                      rows="2">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pindah.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wargaSelect = document.getElementById('warga_id');
    const wargaInfo = document.getElementById('warga-info');

    function updateWargaInfo() {
        const selectedOption = wargaSelect.options[wargaSelect.selectedIndex];
        const pindahCount = selectedOption.getAttribute('data-pindah-count');
        const lastPindah = selectedOption.getAttribute('data-last-pindah');
        const isMeninggal = selectedOption.getAttribute('data-meninggal');

        let info = '';

        if (isMeninggal === '1') {
            info = '<span class="text-danger">Warga ini sudah meninggal!</span>';
        } else if (pindahCount > 0) {
            info = `Sudah pernah pindah ${pindahCount} kali.`;
            if (lastPindah) {
                info += ` Terakhir: ${lastPindah}`;
            }
        } else {
            info = 'Belum pernah pindah.';
        }

        wargaInfo.innerHTML = info;
    }

    wargaSelect.addEventListener('change', updateWargaInfo);
    updateWargaInfo(); // Initial call
});
</script>
@endpush
