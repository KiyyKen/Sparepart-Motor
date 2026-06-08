<x-layouts.app title="Checkout">
    <div class="container py-5">
        <h1>Checkout Pesanan</h1>
        <form method="POST" action="{{ route('checkout.store') }}" class="card card-body">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama penerima</label><input class="form-control" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">No. HP</label><input class="form-control" name="phone" value="{{ old('phone') }}" required></div>
                <div class="col-12"><label class="form-label">Alamat</label><textarea class="form-control" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea></div>
                <div class="col-12"><label class="form-label">Catatan</label><textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea></div>
            </div>
            <button class="btn btn-warning mt-4">Buat Pesanan</button>
        </form>
    </div>
</x-layouts.app>
