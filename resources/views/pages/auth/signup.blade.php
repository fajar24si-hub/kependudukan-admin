<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Register - Kependudukan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{ asset('asset-admin/img/favicon.ico') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('asset-admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset-admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-admin/css/login-custom.css') }}" rel="stylesheet">
</head>

<body>

    <div class="login-split-bg">
        <!-- Left: Logo and branding -->
        <div class="login-left">
            <div class="login-logo">
                <img src="{{ asset('asset-admin/img/logo.png') }}" alt="Logo" onerror="this.style.display='none'" />
                <h2>KEPENDUDUKAN</h2>
                <p>Data Akurat, Pelayanan Cepat</p>
            </div>
        </div>
        <!-- Right: Signup form -->
        <div class="login-right">
            <div class="login-form-box">
                <h3 class="text-center mb-4" style="color:#fff; font-weight:600;">Sign Up</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('signup') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
                </form>
                <p class="text-center mb-0" style="color:#b3c6e0;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:#fff; text-decoration:underline;">Login</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset-admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('asset-admin/js/main.js') }}"></script>
</body>

</html>
