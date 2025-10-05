<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Penduduk - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181c24;
            font-family: 'Roboto', Arial, sans-serif;
            color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 48px auto;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        h1 {
            color: #e74c3c;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0;
        }

        .btn-primary {
            background: #e74c3c;
            border: none;
            font-weight: 600;
            color: #fff;
            border-radius: 6px;
            padding: 10px 22px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #c0392b;
        }

        .card {
            background: #222736;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
            padding: 0;
            overflow: hidden;
        }

        .card-header {
            background: #181c24;
            border-bottom: 1px solid #2c3e50;
            padding: 20px 32px;
        }

        .card-title {
            margin-bottom: 0;
            color: #e74c3c;
            font-weight: 700;
            font-size: 1.4em;
        }

        .card-body {
            padding: 32px;
        }

        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
            gap: 8px;
        }

        .search-box {
            max-width: 300px;
            background: #181c24;
            color: #f4f6f9;
            border: 1px solid #2c3e50;
            border-radius: 6px;
            padding: 8px 12px;
            transition: border 0.2s, background 0.2s;
        }

        .search-box:focus {
            border-color: #e74c3c;
            background: #222736;
            color: #fff;
        }

        .btn-outline-secondary {
            color: #e74c3c;
            border: 1px solid #e74c3c;
            background: transparent;
            border-radius: 6px;
            padding: 8px 18px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .btn-outline-secondary:hover {
            background: #e74c3c;
            color: #fff;
        }

        .table-responsive {
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            background: #181c24;
            color: #f4f6f9;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            border-color: #2c3e50 !important;
            vertical-align: middle;
        }

        .table th {
            background: #222736;
            color: #e74c3c;
            font-weight: 600;
            border-bottom: 2px solid #e74c3c !important;
        }

        .table td {
            color: #f4f6f9;
        }

        .table tr {
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: #23293a;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.98em;
            border-radius: 5px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .btn-info {
            background: #2980b9;
            border: none;
            color: #fff;
        }

        .btn-info:hover {
            background: #1c5a86;
        }

        .btn-warning {
            background: #f39c12;
            border: none;
            color: #fff;
        }

        .btn-warning:hover {
            background: #b9770e;
        }

        .btn-danger {
            background: #c0392b;
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background: #922b21;
        }

        .text-center {
            color: #aaa;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        @media (max-width: 900px) {
            .container {
                padding: 0 8px;
            }

            .card-body {
                padding: 16px;
            }

            .card-header {
                padding: 14px 16px;
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 0 2px;
            }

            .card-body {
                padding: 6px;
            }

            .card-header {
                padding: 10px 8px;
            }

            .search-form {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="header-row">
            <h1>Daftar Penduduk</h1>
            <a href="{{ url('penduduk/create') }}" class="btn-primary">+ Tambah Penduduk</a>
        </div>
        <div class="card shadow">
            <div class="card-header">
                <span class="card-title">Data Penduduk</span>
            </div>
            <div class="card-body">
                <form class="search-form" method="GET" action="">
                    <input type="text" name="search" class="search-box" placeholder="Cari nama/alamat..."
                        value="{{ request('search') }}">
                    <button class="btn-outline-secondary" type="submit">Cari</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th style="width: 180px;">Aksi</th>
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
                                        <div class="action-buttons">
                                            <a href="{{ url('penduduk/show/' . $penduduk['id']) }}"
                                                class="btn-sm btn-info">Detail</a>
                                            <a href="{{ url('penduduk/edit/' . $penduduk['id']) }}"
                                                class="btn-sm btn-warning">Edit</a>
                                            <a href="{{ url('penduduk/delete/' . $penduduk['id']) }}"
                                                class="btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </div>
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
