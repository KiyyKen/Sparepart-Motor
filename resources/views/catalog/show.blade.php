<x-layouts.app :title="$product->name">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-6">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $product->name }}">
                @else
                    <div class="bg-dark rounded-4 p-5 text-center text-white">
                        <div class="display-1">MP</div>
                        <p class="mb-0">Foto produk belum diunggah.</p>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <span class="badge text-bg-warning">{{ $product->category->name }}</span>
                <h1 class="mt-3">{{ $product->name }}</h1>
                <p class="text-muted">SKU {{ $product->sku }} | {{ $product->brand ?? 'Universal' }}</p>
                <p>{{ $product->description }}</p>
                <h2 class="text-warning">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                <p>Stok tersedia: {{ $product->stock }}</p>
                @auth
                    <form method="POST" action="{{ route('cart.store', $product) }}" class="d-flex gap-2">
                        @csrf
                        <input class="form-control w-25" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1">
                        <button class="btn btn-warning">Tambah ke Keranjang</button>
                    </form>
                @else
                    <a class="btn btn-warning" href="{{ route('login') }}">Login untuk membeli</a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app>
