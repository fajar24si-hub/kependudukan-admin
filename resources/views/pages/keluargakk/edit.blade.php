@extends('layouts.app')

@section('title', 'Edit Data Keluarga KK')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <h6 class="mb-4">Edit Data Keluarga KK</h6>

        <form action="{{ route('keluargakk.update', $keluarga->kk_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nomor KK</label>
                    <input type="text" name="kk_nomor" class="form-control" value="{{ old('kk_nomor', $keluarga->kk_nomor) }}" required>
                </div>
                <div class="col-md-6">
                    <label>ID Kepala Keluarga</label>
                    <input type="number" name="kepala_keluarga_warga_id" class="form-control" value="{{ old('kepala_keluarga_warga_id', $keluarga->kepala_keluarga_warga_id) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $keluarga->alamat) }}" required>
                </div>
                <div class="col-md-3">
                    <label>RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt', $keluarga->rt) }}" maxlength="5" required>
                </div>
                <div class="col-md-3">
                    <label>RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw', $keluarga->rw) }}" maxlength="5" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('keluargakk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
