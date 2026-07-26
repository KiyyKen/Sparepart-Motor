<x-layouts.app title="Katalog Sparepart">
    <section class="hero-shop">
        <div class="hero-shop__grid" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="row align-items-center g-5 py-5">
                <div class="col-lg-7">
                    <p class="eyebrow">Bengkel &amp; Toko Sparepart</p>
                    <h1 class="hero-shop__title">Rawat motor kesayangan pakai part yang tepat, bukan asal murah.</h1>
                    <p class="hero-shop__lead">Oli, kampas rem, kelistrikan, sampai variasi — dicek kualitasnya, dikirim cepat, checkout dua langkah.</p>
                    <div class="d-flex gap-4 flex-wrap mt-4">
                        <span class="hero-shop__stat"><strong>{{ $categories->count() }}</strong> kategori</span>
                        <span class="hero-shop__stat"><strong>{{ $products->total() }}</strong> sparepart siap kirim</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <form class="search-panel" method="GET">
                        <label class="form-label fw-semibold text-white-50 small text-uppercase mb-2">Cari sparepart</label>
                        <div class="search-panel__input">
                            <i class="bi bi-search"></i>
                            <input class="form-control" name="search" value="{{ request('search') }}" placeholder="Kampas rem, oli, busi...">
                        </div>
                        <button class="btn hero-cta w-100 mt-3">Cari Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="hazard-divider" aria-hidden="true"></div>

    <main class="container py-5">
        <div class="d-flex gap-2 flex-wrap mb-4">
            <a class="pill {{ request('category') ? '' : 'pill--active' }}" href="{{ route('catalog.index') }}">Semua</a>
            @foreach($categories as $category)
                @php($visual = $category->visual())
                <a class="pill {{ request('category') === $category->slug ? 'pill--active' : '' }}" href="{{ route('catalog.index', ['category' => $category->slug]) }}">
                    <i class="bi {{ $visual['icon'] }}"></i> {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Sparepart tidak ditemukan untuk pencarian ini.</div></div>
            @endforelse
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    </main>
</x-layouts.app>
