<!-- Footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <!-- Logo Kecil di Footer -->
                    <img src="{{ asset('asset-admin/img/LogoPanjang.png') }}"
                         alt="DesaKu"
                         style="height: 25px; margin-right: 10px; filter: brightness(0) saturate(100%) invert(32%) sepia(91%) saturate(747%) hue-rotate(197deg) brightness(93%) contrast(93%);"
                         onerror="this.style.display='none';">
                    <p class="mb-0">
                        &copy; {{ date('Y') }}
                        <a href="{{ route('dashboard') }}">DesaKu Management System</a>.
                        All rights reserved.
                    </p>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0">
                    <span class="me-3">v1.0.0</span>
                    <span class="text-muted">Last Updated: {{ date('d M Y') }}</span>
                </p>
            </div>
        </div>
    </div>
</footer>
