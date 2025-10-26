<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" id="userDropdown"
       role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <img class="rounded-circle me-lg-2"
             src="{{ asset('asset-admin/img/user.jpg') }}" alt="User"
             style="width: 40px; height: 40px;">
        <span class="d-none d-lg-inline-flex">{{ Auth::user()->name ?? 'Admin' }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0"
        aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Log Out</button>
            </form>
        </li>
    </ul>
</div>
