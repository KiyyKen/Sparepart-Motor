<x-layouts.app title="Checkout">
    <div class="container py-5">
        <h1 class="d-flex align-items-center gap-2"><i class="bi bi-bag-check"></i> Checkout Pesanan</h1>
        <div class="row g-4">
            <div class="col-lg-7">
                <form method="POST" action="{{ route('checkout.store') }}" class="card card-body">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama penerima</label><input class="form-control" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required></div>
                        <div class="col-md-6"><label class="form-label">No. HP</label><input class="form-control" name="phone" value="{{ old('phone') }}" required></div>
                        <div class="col-12"><label class="form-label">Alamat</label><textarea class="form-control" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea></div>
                        <div class="col-12"><label class="form-label">Catatan</label><textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea></div>
                    </div>
                    <button class="btn btn-warning mt-4"><i class="bi bi-credit-card"></i> Buat Pesanan &amp; Lanjut Bayar</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header fw-bold">Ringkasan Pesanan</div>
                    <div class="card-body">
                        @php($total = 0)
                        @foreach($cart->items as $item)
                            @php($total += $item->quantity * $item->product->price)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom small">
                                <span>{{ $item->product->name }} <span class="text-muted">x{{ $item->quantity }}</span></span>
                                <span class="mono">Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between align-items-center pt-3">
                            <strong>Total</strong>
                            <strong class="mono" style="color: var(--amber);">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
