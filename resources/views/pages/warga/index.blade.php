@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Warga</h6>
            <a href="{{ route('warga.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Tambah Warga
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success text-start">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Status Perkawinan</th>
                        <th>Status Dalam Keluarga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $item->tempat_lahir }}</td>
                            <td>{{ $item->tanggal_lahir }}</td>
                            <td>{{ $item->agama }}</td>
                            <td>{{ $item->pendidikan }}</td>
                            <td>{{ $item->pekerjaan }}</td>
                            <td>{{ $item->status_perkawinan }}</td>
                            <td>{{ $item->status_dalam_keluarga }}</td>
                            <td>
                                <a href="{{ route('warga.edit', $item->warga_id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center">Belum ada data warga</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
