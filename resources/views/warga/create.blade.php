@extends('layouts.app')

@section('title', 'Tambah Warga')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <h6 class="mb-4">Tambah Data Warga</h6>

        <form action="{{ route('warga.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Agama</label>
                    <input type="text" name="agama" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Pendidikan</label>
                    <input type="text" name="pendidikan" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Status Dalam Keluarga</label>
                    <input type="text" name="status_dalam_keluarga" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
