@extends('layouts.app')

@section('title', 'Identitas Pengembang')

@section('page-title', 'Identitas Pengembang')
@section('page-subtitle', 'Informasi lengkap tentang pengembang sistem')

@section('breadcrumbs')
    @php
        $breadcrumbs = [['name' => 'Dashboard', 'url' => route('dashboard')], ['name' => 'Identitas Pengembang']];
    @endphp
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 fade-in">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <!-- Foto Profil -->
                            <div class="mb-4">
                                <img src="asset-admin/img/Foto-Pengembang.jpeg"
                                    alt="Foto Pengembang"
                                    class="img-fluid rounded-circle border border-4 border-primary shadow-sm"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                            </div>

                            <!-- Media Sosial -->
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <a href="https://linkedin.com/in/FajarFarhan2010" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-linkedin"></i> LinkedIn
                                </a>
                                <a href="https://github.com/fajar24si-hub" target="_blank" class="btn btn-outline-dark btn-sm">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                                <a href="https://instagram.com/fajar_farhan20" target="_blank"
                                    class="btn btn-outline-danger btn-sm">
                                    <i class="fab fa-instagram"></i> Instagram
                                </a>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- Informasi Utama -->
                            <h3 class="text-primary mb-3">Informasi Pribadi</h3>
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Nama Lengkap</h6>
                                            <h4 class="card-title mb-0">Fajar Farhan</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">NIM</h6>
                                            <h4 class="card-title mb-0">2457301044</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Program Studi</h6>
                                            <h4 class="card-title mb-0">Sistem Informas - Politeknik Caltex Riau</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Informasi -->
                            <h3 class="text-primary mb-3">Detail Informasi</h3>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="30%" class="bg-light">Tempat, Tanggal Lahir</th>
                                            <td>Pekanbaru, 3 Januari 2003</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Email</th>
                                            <td>fajar24si@mahasiswa.pcr.ac.id</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">No. Telepon</th>
                                            <td>+62 851 7979 7880</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Alamat</th>
                                            <td>Jl. Sumbersari, No 180</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Semester</th>
                                            <td>3 (Tiga)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer bg-transparent border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Terakhir diperbarui: {{ date('d F Y') }}
                                    </small>
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tambahkan sedikit styling custom untuk halaman ini -->
                <style>
                    .card {
                        border-radius: 15px;
                        transition: transform 0.3s ease;
                    }

                    .card:hover {
                        transform: translateY(-5px);
                    }

                    .badge {
                        font-size: 14px;
                        font-weight: 500;
                        border-radius: 8px;
                    }

                    .table th {
                        font-weight: 600;
                    }

                    .fade-in {
                        animation: fadeIn 0.6s ease-out;
                    }

                    @keyframes fadeIn {
                        from {
                            opacity: 0;
                            transform: translateY(20px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                </style>
            @endsection
