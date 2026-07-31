<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaint Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-page">
        <div class="glass-card">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h1>Complaint Management System</h1>
            <p class="subtitle">Ministry of Agriculture, Republic of Somaliland</p>
            <a href="{{ route('login') }}" class="btn btn-staff-login">Staff Login</a>
        </div>
    </div>
</body>
</html>
