<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #181c24;
            margin: 0;
            padding: 0;
            color: #f4f6f9;
        }

        .dashboard-container {
            max-width: 600px;
            margin: 60px auto;
            background: #222736;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
            padding: 40px 32px;
            text-align: center;
        }

        h2 {
            color: #e74c3c;
            margin-bottom: 16px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        p {
            color: #aaa;
            font-size: 1.1em;
        }

        .success-message {
            color: #27ae60;
            background: #1e2b22;
            border: 1px solid #27ae60;
            padding: 12px 0;
            border-radius: 6px;
            margin-bottom: 18px;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            padding: 10px 28px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            margin-top: 18px;
        }

        .btn:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h2>Dashboard</h2>
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        <p>Selamat datang di halaman dashboard!</p>
        <a href="{{ url('/penduduk') }}" class="btn">Lihat Data Penduduk</a>
    </div>
</body>

</html>
