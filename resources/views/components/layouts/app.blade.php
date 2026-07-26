<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MotoPart Garage' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #12181f;
            --ink-soft: #232b34;
            --steel: #2b3542;
            --amber: #ff6a00;
            --amber-dark: #d65400;
            --paper: #eef1f4;
            --paper-card: #ffffff;
            --line: #dbe1e7;
            --ink-text: #1c232b;
            --muted: #67707a;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--paper);
            color: var(--ink-text);
            font-family: 'Inter', system-ui, sans-serif;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Oswald', system-ui, sans-serif;
            letter-spacing: .01em;
            text-transform: none;
        }

        .mono { font-family: 'JetBrains Mono', ui-monospace, monospace; }

        a { text-decoration: none; }

        /* Hazard strip signature accent */
        .hazard-strip {
            height: 6px;
            background: repeating-linear-gradient(135deg, var(--amber) 0 14px, var(--ink) 14px 28px);
        }

        .hazard-divider {
            height: 3px;
            background: repeating-linear-gradient(135deg, var(--amber) 0 10px, transparent 10px 20px);
            opacity: .55;
        }

        /* Navbar */
        .navbar-shop {
            background: var(--ink);
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .navbar-shop .navbar-brand {
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
        }

        .navbar-shop .brand-accent { color: var(--amber); }

        .navbar-shop .nav-link {
            color: rgba(255,255,255,.72);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .4rem;
            border-radius: .5rem;
            padding: .5rem .75rem !important;
        }

        .navbar-shop .nav-link:hover { color: #fff; }
        .navbar-shop .nav-link.active { color: #fff; background: rgba(255,106,0,.16); }

        .cart-badge {
            background: var(--amber);
            color: var(--ink);
            font-family: 'JetBrains Mono', monospace;
            font-size: .68rem;
            font-weight: 700;
            border-radius: 999px;
            padding: .05rem .4rem;
            margin-left: .15rem;
        }

        .btn-brand {
            background: var(--amber);
            border-color: var(--amber);
            color: var(--ink);
            font-weight: 600;
        }

        .btn-brand:hover { background: var(--amber-dark); border-color: var(--amber-dark); color: #fff; }

        .btn-outline-brand {
            border-color: rgba(255,255,255,.5);
            color: #fff;
        }

        .btn-outline-brand:hover { background: rgba(255,255,255,.12); color: #fff; }

        /* Hero */
        .hero-shop {
            position: relative;
            background: linear-gradient(160deg, var(--ink) 0%, var(--steel) 100%);
            color: #fff;
            overflow: hidden;
        }

        .hero-shop__grid {
            position: absolute;
            inset: 0;
            opacity: .08;
            background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px);
            background-size: 42px 42px;
            pointer-events: none;
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .8rem;
            font-weight: 700;
            color: var(--amber);
        }

        .hero-shop__title {
            font-size: clamp(1.9rem, 3.2vw, 2.9rem);
            font-weight: 700;
            line-height: 1.15;
        }

        .hero-shop__lead { color: rgba(255,255,255,.75); font-size: 1.05rem; }

        .hero-shop__stat {
            font-size: .9rem;
            color: rgba(255,255,255,.7);
        }

        .hero-shop__stat strong {
            font-family: 'JetBrains Mono', monospace;
            color: #fff;
            font-size: 1.1rem;
        }

        .search-panel {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.14);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(6px);
        }

        .search-panel__input {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #fff;
            border-radius: .6rem;
            padding: 0 .75rem;
        }

        .search-panel__input i { color: var(--muted); }
        .search-panel__input .form-control { border: none; box-shadow: none; padding: .7rem .25rem; }

        .hero-cta {
            background: var(--amber);
            color: var(--ink);
            font-weight: 700;
            border-radius: .6rem;
        }

        .hero-cta:hover { background: var(--amber-dark); color: #fff; }

        /* Category pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .9rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            color: var(--ink-text);
            font-size: .88rem;
            font-weight: 500;
            background: var(--paper-card);
        }

        .pill:hover { border-color: var(--amber); color: var(--ink-text); }
        .pill--active { background: var(--ink); border-color: var(--ink); color: #fff; }

        /* Product art / icon-image block */
        .part-art {
            aspect-ratio: 4 / 3;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(150deg, var(--from, #444) 0%, var(--to, #111) 100%);
            overflow: hidden;
        }

        .part-art--square { aspect-ratio: 1 / 1; }
        .part-art--thumb { width: 64px; height: 64px; aspect-ratio: 1 / 1; border-radius: .6rem; flex: 0 0 auto; }
        .part-art--thumb .part-art__icon { font-size: 1.4rem; }
        .part-art img { width: 100%; height: 100%; object-fit: cover; }
        .part-art__icon { font-size: 3.4rem; color: rgba(255,255,255,.92); filter: drop-shadow(0 6px 10px rgba(0,0,0,.25)); }

        .part-art__grid {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(135deg, rgba(255,255,255,.08) 0 2px, transparent 2px 18px);
        }

        /* Product card */
        .part-card {
            background: var(--paper-card);
            border-radius: .9rem;
            overflow: hidden;
            border: 1px solid var(--line);
            transition: transform .18s ease, box-shadow .18s ease;
            display: flex;
            flex-direction: column;
        }

        .part-card:hover { transform: translateY(-4px); box-shadow: 0 1rem 2rem rgba(18,24,31,.12); }
        .part-card__link { position: relative; display: block; }

        .part-card__ribbon {
            position: absolute;
            top: .6rem;
            left: .6rem;
            background: rgba(18,24,31,.78);
            color: #fff;
            font-size: .72rem;
            font-weight: 600;
            padding: .25rem .6rem;
            border-radius: 999px;
        }

        .part-card__stock {
            position: absolute;
            bottom: .6rem;
            right: .6rem;
            font-size: .7rem;
            font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 999px;
            font-family: 'JetBrains Mono', monospace;
        }

        .part-card__stock--low { background: #fff3cd; color: #7a5b00; }
        .part-card__stock--out { background: #f8d7da; color: #7a1418; }

        .part-card__body { padding: 1.1rem; display: flex; flex-direction: column; gap: .5rem; flex: 1; }

        .part-card__meta {
            display: flex;
            justify-content: space-between;
            font-size: .76rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .part-card__title { font-size: 1.05rem; margin: 0; font-family: 'Inter', sans-serif; font-weight: 600; }
        .part-card__title a { color: var(--ink-text); }
        .part-card__rating { font-size: .82rem; }
        .part-card__rating .stars { color: var(--amber); font-size: .78rem; margin-right: .35rem; }

        .part-card__footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: .5rem;
            border-top: 1px dashed var(--line);
        }

        .part-card__price { font-weight: 700; color: var(--ink-text); }
        .part-card__cta { background: var(--ink); color: #fff; border-radius: .5rem; font-weight: 600; }
        .part-card__cta:hover { background: var(--amber); color: var(--ink); }

        /* Admin shell */
        .admin-shell { min-height: calc(100vh - 62px); }

        .sidebar {
            background: var(--ink);
            min-height: calc(100vh - 62px);
        }

        .sidebar__brand {
            color: #fff;
            font-family: 'Oswald', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            font-size: .82rem;
            letter-spacing: .08em;
            color: rgba(255,255,255,.5);
        }

        .sidebar a {
            color: rgba(255,255,255,.75);
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .65rem .9rem;
            border-radius: .55rem;
            font-weight: 500;
            margin-bottom: .15rem;
        }

        .sidebar a i { font-size: 1.05rem; width: 1.2rem; text-align: center; }
        .sidebar a:hover { background: rgba(255,255,255,.08); color: #fff; }
        .sidebar a.active { background: var(--amber); color: var(--ink); font-weight: 600; }

        /* Generic card/button polish across app */
        .card { border-radius: .9rem; border-color: var(--line); }
        .btn { border-radius: .55rem; }
        .btn-warning { background: var(--amber); border-color: var(--amber); color: var(--ink); font-weight: 600; }
        .btn-warning:hover { background: var(--amber-dark); border-color: var(--amber-dark); color: #fff; }
        .table { --bs-table-border-color: var(--line); }
    </style>
</head>
<body>
<div class="hazard-strip"></div>
<nav class="navbar navbar-expand-lg navbar-shop sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('catalog.index') }}">Moto<span class="brand-accent">Part</span> Garage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}"><i class="bi bi-grid"></i> Katalog</a></li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i> Keranjang
                            @php($cartCount = auth()->user()->cart?->items()->sum('quantity') ?? 0)
                            @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}"><i class="bi bi-clock-history"></i> Riwayat</a></li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a></li>
                    @endif
                @endauth
            </ul>
            <div class="d-flex gap-2">
                @guest
                    <a class="btn btn-outline-brand" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-brand" href="{{ route('register') }}">Register</a>
                @else
                    <span class="navbar-text text-white-50 small d-none d-md-inline">Hai, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-brand">Logout</button></form>
                @endguest
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container mt-3"><div class="alert alert-success d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div></div>
@endif
@if($errors->any())
    <div class="container mt-3"><div class="alert alert-danger d-flex align-items-center gap-2"><i class="bi bi-exclamation-triangle-fill"></i>{{ $errors->first() }}</div></div>
@endif

{{ $slot }}

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <span class="brand-font">MotoPart Garage</span>
        <span class="text-white-50 small">Bengkel dan penjualan sparepart motor — modern, responsif, siap dikembangkan.</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
