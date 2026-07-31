<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Complaint Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-page">
        <div class="glass-card login-card">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            </div>

            @if(session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot your password?</a>
                    <button type="submit" class="btn btn-login">LOG IN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
