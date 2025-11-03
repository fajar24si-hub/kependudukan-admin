<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - Kependudukan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="{{ asset('asset-admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('asset-admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('asset-admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('asset-admin/css/style.css') }}" rel="stylesheet">
    <!-- Custom Login Stylesheet -->
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
        <!-- Right: Login form -->
        <div class="login-right">
            <div class="login-form-box">
                <h3 class="text-center mb-4" style="color:#fff; font-weight:600;">Sign In</h3>
                <!-- Alert Error -->
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Your email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="form-text" style="color:#b3c6e0; text-decoration:underline;">Recover password</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">SIGN IN</button>
                </form>
                <p class="text-center mb-0" style="color:#b3c6e0;">
                    Belum punya akun?
                    <a href="{{ route('signup') }}" style="color:#fff; text-decoration:underline;">Sign Up</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset-admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('asset-admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('asset-admin/js/main.js') }}"></script>
</body>

</html>
