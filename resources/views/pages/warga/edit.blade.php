@extends('layouts.app')

@section('title', 'Edit Warga')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <h6 class="mb-4">Edit Data Warga</h6>

        <form action="{{ route('warga.update', $warga->warga_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>NIK</label>
                    <input type="text" name="nik" value="{{ $warga->nik }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $warga->nama }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L" {{ $warga->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $warga->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ $warga->tempat_lahir }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ $warga->tanggal_lahir }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Agama</label>
                    <input type="text" name="agama" value="{{ $warga->agama }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Pendidikan</label>
                    <input type="text" name="pendidikan" value="{{ $warga->pendidikan }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ $warga->pekerjaan }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-select" required>
                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)
                            <option value="{{ $status }}" {{ $warga->status_perkawinan == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Status Dalam Keluarga</label>
                    <input type="text" name="status_dalam_keluarga" value="{{ $warga->status_dalam_keluarga }}" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
