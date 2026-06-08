<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MotoPart Garage' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6f8; }
        .hero { background: linear-gradient(135deg, #101820, #26313f); color: #fff; }
        .brand-accent { color: #ff6b00; }
        .card-product { transition: transform .15s ease, box-shadow .15s ease; }
        .card-product:hover { transform: translateY(-3px); box-shadow: 0 .75rem 2rem rgba(0,0,0,.12); }
        .admin-shell { min-height: calc(100vh - 56px); }
        .sidebar { background: #111827; }
        .sidebar a { color: #d1d5db; text-decoration: none; display: block; padding: .75rem 1rem; border-radius: .5rem; }
        .sidebar a:hover, .sidebar a.active { background: #ff6b00; color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('catalog.index') }}">Moto<span class="brand-accent">Part</span> Garage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('catalog.index') }}">Katalog</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Riwayat</a></li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                    @endif
                @endauth
            </ul>
            <div class="d-flex gap-2">
                @guest
                    <a class="btn btn-outline-light" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-warning" href="{{ route('register') }}">Register</a>
                @else
                    <span class="navbar-text text-white">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light">Logout</button></form>
                @endguest
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
@endif
@if($errors->any())
    <div class="container mt-3"><div class="alert alert-danger">{{ $errors->first() }}</div></div>
@endif

{{ $slot }}

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <span>MotoPart Garage - Bengkel dan penjualan sparepart motor.</span>
        <span>Modern, responsif, dan siap dikembangkan.</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
