@extends('index')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Keluarga KK</h6>
            <a href="{{ route('keluargakk.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Tambah Data
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">No</th>
                        <th scope="col">Nomor KK</th>
                        <th scope="col">ID Kepala Keluarga</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">RT</th>
                        <th scope="col">RW</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $kk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kk->kk_nomor }}</td>
                            <td>{{ $kk->kepala_keluarga_warga_id }}</td>
                            <td>{{ $kk->alamat }}</td>
                            <td>{{ $kk->rt }}</td>
                            <td>{{ $kk->rw }}</td>
                            <td>
                                <a href="{{ route('keluargakk.edit', $kk->kk_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('keluargakk.destroy', $kk->kk_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
