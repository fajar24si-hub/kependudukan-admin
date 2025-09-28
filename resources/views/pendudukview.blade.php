<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Penduduk - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            margin-bottom: 1rem;
        }

        .search-box {
            max-width: 300px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Daftar Penduduk</h1>
            <a href="{{ url('penduduk/create') }}" class="btn btn-primary">+ Tambah Penduduk</a>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <form class="mb-3 d-flex justify-content-end" method="GET" action="">
                    <input type="text" name="search" class="form-control search-box me-2"
                        placeholder="Cari nama/alamat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataPenduduk as $index => $penduduk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $penduduk['nama'] }}</td>
                                    <td>{{ $penduduk['umur'] }}</td>
                                    <td>{{ $penduduk['alamat'] }}</td>
                                    <td>
                                        <a href="{{ url('penduduk/show/' . $penduduk['id']) }}"
                                            class="btn btn-sm btn-info me-1">Detail</a>
                                        <a href="{{ url('penduduk/edit/' . $penduduk['id']) }}"
                                            class="btn btn-sm btn-warning me-1">Edit</a>
                                        <a href="{{ url('penduduk/delete/' . $penduduk['id']) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data penduduk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination jika menggunakan data dari database --}}
                {{-- {{ $dataPenduduk->links() }} --}}
            </div>
        </div>
    </div>
</body>

</html>
