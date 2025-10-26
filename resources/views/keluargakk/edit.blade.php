
@extends('index')

@section('content')
<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                </a>
                <div class="navbar-nav w-100">
                    <a href="{{ route('keluargakk.index') }}" class="nav-item nav-link">
                        <i class="fa fa-table me-2"></i>Data KK
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <span class="navbar-text text-white ms-3">Edit Data Keluarga KK</span>
            </nav>
            <!-- Navbar End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Form Edit Keluarga KK</h6>
                            <form action="{{ route('keluargakk.update', $keluarga->kk_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nomor KK</label>
                                    <input type="text" class="form-control" name="kk_nomor"
                                        value="{{ old('kk_nomor', $keluarga->kk_nomor) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ID Kepala Keluarga</label>
                                    <input type="number" class="form-control" name="kepala_keluarga_warga_id"
                                        value="{{ old('kepala_keluarga_warga_id', $keluarga->kepala_keluarga_warga_id) }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">RT</label>
                                        <input type="text" class="form-control" name="rt" maxlength="5"
                                            value="{{ old('rt', $keluarga->rt) }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">RW</label>
                                        <input type="text" class="form-control" name="rw" maxlength="5"
                                            value="{{ old('rw', $keluarga->rw) }}" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('keluargakk.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset-admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset-admin/js/main.js') }}"></script>
</body>

