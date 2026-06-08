<x-layouts.app title="Katalog Sparepart">
    <section class="hero py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <p class="text-warning fw-semibold">Bengkel Motor Modern</p>
                    <h1 class="display-5 fw-bold">Sparepart motor terpercaya untuk servis harian sampai upgrade performa.</h1>
                    <p class="lead">Cari oli, kampas rem, busi, aki, dan komponen lainnya dengan checkout cepat.</p>
                </div>
                <div class="col-lg-5">
                    <form class="card card-body shadow" method="GET">
                        <label class="form-label fw-semibold">Cari sparepart</label>
                        <input class="form-control form-control-lg mb-3" name="search" value="{{ request('search') }}" placeholder="Contoh: kampas rem">
                        <button class="btn btn-warning btn-lg">Cari</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <main class="container py-5">
        <div class="d-flex gap-2 flex-wrap mb-4">
            <a class="btn btn-sm btn-dark" href="{{ route('catalog.index') }}">Semua</a>
            @foreach($categories as $category)
                <a class="btn btn-sm btn-outline-dark" href="{{ route('catalog.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
            @endforeach
        </div>
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-product h-100">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top object-fit-cover" alt="{{ $product->name }}" style="height: 190px">
                        @else
                            <div class="bg-dark text-white text-center py-5 rounded-top">
                                <div class="display-6 fw-bold">MP</div>
                                <small>Foto sparepart</small>
                            </div>
                        @endif
                        <div class="card-body">
                            <span class="badge text-bg-dark">{{ $product->category->name }}</span>
                            <h2 class="h5 mt-3">{{ $product->name }}</h2>
                            <p class="text-muted">{{ $product->brand ?? 'Universal' }} - Stok {{ $product->stock }}</p>
                            <p class="fw-bold text-warning fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a class="btn btn-outline-dark w-100" href="{{ route('catalog.show', $product) }}">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Sparepart tidak ditemukan.</div></div>
            @endforelse
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </main>
</x-layouts.app>
