@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <h6 class="mb-4">Tambah Data User</h6>

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama" required>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="col-md-6">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
