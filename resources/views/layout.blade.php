<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AVATAR Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top left, #1e293b, #020617);
            min-height: 100vh;
            color: #0f172a;
        }

        .main-container {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .app-card {
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.35);
        }

        .brand-pill {
            font-size: 0.8rem;
            letter-spacing: 0.12em;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
            🛒 AVATAR Shop
        </a>

        <div class="ms-auto d-flex align-items-center">
            @auth
                <span class="navbar-text text-white me-3">
                    {{ auth()->user()->name }}
                </span>
                <a href="{{ route('do_logout') }}" class="btn btn-outline-light btn-sm">
                    Log out
                </a>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Sign up
                </a>
            @endguest
        </div>
    </div>
</nav>

<div class="container main-container">
    @yield('content')
</div>

</body>
</html>
