<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181c24;
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #f4f6f9;
        }

        .login-container {
            max-width: 380px;
            margin: 80px auto;
            background: #222736;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
            padding: 36px 32px 28px 32px;
        }

        h2 {
            text-align: center;
            color: #e74c3c;
            margin-bottom: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        label {
            font-weight: 500;
            color: #f4f6f9;
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 14px;
            border: 1px solid #2c3e50;
            border-radius: 6px;
            background: #181c24;
            color: #f4f6f9;
            font-size: 1em;
            transition: border 0.2s, background 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #e74c3c;
            outline: none;
            background: #222736;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px 0;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }

        button[type="submit"]:hover {
            background: #c0392b;
        }

        .error-message,
        .success-message {
            text-align: center;
            padding: 10px 0;
            border-radius: 5px;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .error-message {
            color: #e74c3c;
            background: #2c2323;
            border: 1px solid #e74c3c;
        }

        .success-message {
            color: #27ae60;
            background: #1e2b22;
            border: 1px solid #27ae60;
        }

        small {
            color: #e74c3c;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Form Login</h2>

        <!-- Tampilkan pesan error -->
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Tampilkan pesan sukses -->
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form action="/auth/login" method="POST">
            @csrf
            <label>Username:</label>
            <input type="text" name="username" value="{{ old('username') }}">
            @error('username')
                <small>{{ $message }}</small>
            @enderror

            <label>Password:</label>
            <input type="password" name="password">
            @error('password')
                <small>{{ $message }}</small>
            @enderror

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
