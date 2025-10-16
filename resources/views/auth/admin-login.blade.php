<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flory Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #FAF7F3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 400px;
        }
        .login-logo {
            width: 100px;
            margin: 0 auto 10px;
            display: block;
        }
        .btn-flory {
            background-color: #819067b4;
            border: none;
            color: #fff;
            transition: 0.3s;
        }
        .btn-flory:hover {
            background-color: #819067;
        }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <img src="{{ asset('assets/flory-logo.jpg') }}" alt="Flory Logo" class="login-logo">
        <h6 class="fw-bold text-secondary mb-4">Flory Admin Dashboard</h6>

        @if ($errors->any())
            <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="Admin Email" required>
                <label for="email">Admin Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn btn-flory w-100 py-2">Login</button>
        </form>

        <p class="mt-4 text-muted small mb-0">© {{ date('Y') }} Flory Dashboard</p>
    </div>
</body>
</html>
