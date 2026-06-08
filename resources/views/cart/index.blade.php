<x-layouts.app title="Keranjang">
    <div class="container py-5">
        <h1>Keranjang</h1>
        <div class="card">
            <div class="card-body">
                @php($total = 0)
                @forelse($cart->items as $item)
                    @php($subtotal = $item->quantity * $item->product->price)
                    @php($total += $subtotal)
                    <div class="row align-items-center border-bottom py-3">
                        <div class="col-md-5"><strong>{{ $item->product->name }}</strong><br><span class="text-muted">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span></div>
                        <div class="col-md-3">
                            <form method="POST" action="{{ route('cart.update', $item->product) }}" class="d-flex gap-2">
                                @csrf @method('PATCH')
                                <input class="form-control" type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}">
                                <button class="btn btn-sm btn-dark">Update</button>
                            </form>
                        </div>
                        <div class="col-md-3 fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                        <div class="col-md-1">
                            <form method="POST" action="{{ route('cart.destroy', $item->product) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                        </div>
                    </div>
                @empty
                    <p class="mb-0">Keranjang masih kosong.</p>
                @endforelse
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h2 class="h4">Total: Rp {{ number_format($total, 0, ',', '.') }}</h2>
                    <a class="btn btn-warning {{ $cart->items->isEmpty() ? 'disabled' : '' }}" href="{{ route('checkout.create') }}">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
