<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kependudukan Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181c24;
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #f4f6f9;
        }

        .sidebar {
            width: 220px;
            background: #222736;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 24px 0 0 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar .logo {
            color: #e74c3c;
            font-size: 1.7em;
            font-weight: bold;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 32px;
        }

        .sidebar .profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #e74c3c;
            margin-bottom: 8px;
        }

        .sidebar .profile .name {
            font-weight: 600;
            color: #fff;
        }

        .sidebar .profile .role {
            font-size: 0.95em;
            color: #aaa;
        }

        .sidebar nav {
            width: 100%;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar nav ul li {
            margin-bottom: 8px;
        }

        .sidebar nav ul li a {
            display: block;
            padding: 12px 32px;
            color: #f4f6f9;
            text-decoration: none;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }

        .sidebar nav ul li a.active,
        .sidebar nav ul li a:hover {
            background: #181c24;
            border-left: 4px solid #e74c3c;
            color: #e74c3c;
        }

        .main-content {
            margin-left: 220px;
            padding: 32px 40px;
            min-height: 100vh;
            background: #181c24;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .topbar .search {
            background: #222736;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            color: #f4f6f9;
            width: 220px;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .topbar .user-info img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #e74c3c;
        }

        .cards {
            display: flex;
            gap: 24px;
            margin-bottom: 32px;
        }

        .card {
            background: #222736;
            border-radius: 10px;
            padding: 24px 32px;
            flex: 1;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card .icon {
            font-size: 2em;
            margin-bottom: 8px;
            color: #e74c3c;
        }

        .card .label {
            color: #aaa;
            font-size: 1em;
            margin-bottom: 6px;
        }

        .card .value {
            font-size: 1.4em;
            font-weight: bold;
            color: #fff;
        }

        .menu-title {
            color: #aaa;
            font-size: 1.1em;
            margin: 32px 0 12px 0;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .main-content {
                padding: 24px 10px;
            }

            .cards {
                flex-direction: column;
                gap: 16px;
            }
        }

        @media (max-width: 700px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">Kependudukan</div>
        <div class="profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=e74c3c&color=fff" alt="Admin">
            <div class="name">Admin</div>
            <div class="role">Administrator</div>
        </div>
        <nav>
            <ul>
                <li><a href="{{ url('/dashboard') }}" class="active">Dashboard</a></li>
                <li><a href="{{ url('/penduduk') }}">Data Penduduk</a></li>
                <li><a href="{{ url('/penduduk/create') }}">Tambah Data Penduduk</a></li>
                <li><a href="{{ url('/auth') }}">Login Admin</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <div class="topbar">
            <input type="text" class="search" placeholder="Search...">
            <div class="user-info">
                <span>Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=e74c3c&color=fff" alt="Admin">
            </div>
        </div>
        <div class="cards">
            <div class="card">
                <div class="icon">&#128202;</div>
                <div class="label">Total Penduduk</div>
                <div class="value">1234</div>
            </div>
            <div class="card">
                <div class="icon">&#128100;</div>
                <div class="label">Penduduk Baru</div>
                <div class="value">12</div>
            </div>
            <div class="card">
                <div class="icon">&#128221;</div>
                <div class="label">Data Tervalidasi</div>
                <div class="value">1200</div>
            </div>
        </div>
        <div class="menu-title">Fitur Utama</div>
        <ul class="menu-list" style="max-width:400px;margin:0;padding:0;list-style:none;">
            <li style="margin-bottom:10px;"><a href="{{ url('/dashboard') }}"
                    style="color:#e74c3c;text-decoration:none;">Dashboard</a>
            </li>
            <li style="margin-bottom:10px;"><a href="{{ url('/penduduk') }}"
                    style="color:#e74c3c;text-decoration:none;">Data
                    Penduduk</a></li>
            <li style="margin-bottom:10px;"><a href="{{ url('/penduduk/create') }}"
                    style="color:#e74c3c;text-decoration:none;">Tambah
                    Data Penduduk</a></li>
            <li style="margin-bottom:10px;"><a href="{{ url('/auth') }}"
                    style="color:#e74c3c;text-decoration:none;">Login
                    Admin</a></li>
        </ul>
        <div class="footer" style="margin-top:32px;color:#aaa;font-size:0.95em;">
            &copy; {{ date('Y') }} Kependudukan Admin. All rights reserved.
        </div>
    </div>
</body>

</html>
