@extends('layouts.app')

@section('title', 'Tambah Data Keluarga KK')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <h6 class="mb-4">Tambah Data Keluarga KK</h6>

        <form action="{{ route('keluargakk.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nomor KK</label>
                    <input type="text" name="kk_nomor" class="form-control" value="{{ old('kk_nomor') }}" placeholder="Masukkan nomor KK" required>
                </div>
                <div class="col-md-6">
                    <label>ID Kepala Keluarga</label>
                    <input type="number" name="kepala_keluarga_warga_id" class="form-control" value="{{ old('kepala_keluarga_warga_id') }}" placeholder="Masukkan ID kepala keluarga" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Masukkan alamat" required>
                </div>
                <div class="col-md-3">
                    <label>RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt') }}" placeholder="RT" maxlength="5" required>
                </div>
                <div class="col-md-3">
                    <label>RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw') }}" placeholder="RW" maxlength="5" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('keluargakk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
