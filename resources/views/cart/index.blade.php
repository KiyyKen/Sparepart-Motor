<x-layouts.app title="Keranjang">
    <div class="container py-5">
        <h1 class="d-flex align-items-center gap-2"><i class="bi bi-cart3"></i> Keranjang</h1>
        <div class="card">
            <div class="card-body">
                @php($total = 0)
                @forelse($cart->items as $item)
                    @php($subtotal = $item->quantity * $item->product->price)
                    @php($total += $subtotal)
                    <div class="row align-items-center border-bottom py-3 g-3">
                        <div class="col-md-5 d-flex align-items-center gap-3">
                            <x-part-art :product="$item->product" class="part-art--thumb" />
                            <div>
                                <strong>{{ $item->product->name }}</strong><br>
                                <span class="text-muted mono small">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <form method="POST" action="{{ route('cart.update', $item->product) }}" class="d-flex gap-2">
                                @csrf @method('PATCH')
                                <input class="form-control" type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}">
                                <button class="btn btn-sm btn-dark">Update</button>
                            </form>
                        </div>
                        <div class="col-md-3 fw-bold mono">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                        <div class="col-md-1">
                            <form method="POST" action="{{ route('cart.destroy', $item->product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button></form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x display-4 text-muted"></i>
                        <p class="mb-3 mt-2">Keranjang masih kosong.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-warning">Mulai Belanja</a>
                    </div>
                @endforelse

                @if($cart->items->isNotEmpty())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <h2 class="h4 mono mb-0">Total: Rp {{ number_format($total, 0, ',', '.') }}</h2>
                        <a class="btn btn-warning" href="{{ route('checkout.create') }}">Lanjut ke Checkout <i class="bi bi-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
