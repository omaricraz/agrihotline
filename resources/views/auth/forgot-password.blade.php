<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-page">
        <div class="glass-card login-card">
            <div class="text-center mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                <h1 style="font-size:1.15rem;">Reset Password</h1>
            </div>

            @if(session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}" class="forgot-link">Back to login</a>
                    <button type="submit" class="btn btn-login">SEND LINK</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
