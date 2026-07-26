<x-layouts.app :title="$product->name">
    <div class="container py-5">
        <a href="{{ route('catalog.index') }}" class="text-muted small d-inline-flex align-items-center gap-1 mb-3"><i class="bi bi-arrow-left"></i> Kembali ke katalog</a>

        <div class="row g-4">
            <div class="col-lg-6">
                <x-part-art :product="$product" class="rounded-4" :square="true" />
            </div>
            <div class="col-lg-6">
                @php($visual = $product->category->visual())
                <span class="pill pill--active"><i class="bi {{ $visual['icon'] }}"></i> {{ $product->category->name }}</span>
                <h1 class="mt-3">{{ $product->name }}</h1>
                <p class="text-muted mono small">SKU {{ $product->sku }} &middot; {{ $product->brand ?? 'Universal' }}</p>
                <p class="d-flex align-items-center gap-2">
                    <span class="stars text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($averageRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </span>
                    <span class="text-muted small mono">{{ $averageRating }}/5 ({{ $product->reviews->count() }} ulasan)</span>
                </p>
                <p>{{ $product->description }}</p>
                <h2 class="mono" style="color: var(--amber);">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>

                @if($product->stock === 0)
                    <p class="part-card__stock part-card__stock--out d-inline-block position-static">Stok Habis</p>
                @elseif($product->stock <= 5)
                    <p class="part-card__stock part-card__stock--low d-inline-block position-static">Sisa {{ $product->stock }} unit</p>
                @else
                    <p class="text-muted">Stok tersedia: {{ $product->stock }}</p>
                @endif

                @auth
                    @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.store', $product) }}" class="d-flex gap-2 mt-3">
                            @csrf
                            <input class="form-control w-25" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1">
                            <button class="btn btn-warning"><i class="bi bi-cart-plus"></i> Tambah ke Keranjang</button>
                        </form>
                    @endif
                @else
                    <a class="btn btn-warning mt-3" href="{{ route('login') }}">Login untuk membeli</a>
                @endauth
            </div>
        </div>

        <div class="hazard-divider my-5" aria-hidden="true"></div>

        <div class="row">
            <div class="col-lg-8">
                <h3 class="h5 mb-3">Ulasan Pembeli</h3>
                @forelse($product->reviews as $review)
                    <div class="border-bottom py-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-warning small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </span>
                        </div>
                        <div class="text-muted small">{{ $review->created_at->translatedFormat('d M Y') }}</div>
                        @if($review->comment)
                            <p class="mb-0 mt-1">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-muted">Belum ada ulasan untuk sparepart ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
