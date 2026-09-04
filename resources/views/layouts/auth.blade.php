<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SATRIA')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f7fb;
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .form-control {
            min-height: 46px;
            border-radius: 10px;
        }

        .btn {
            min-height: 46px;
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="auth-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>