<x-layouts.admin title="Dashboard Admin">
    <h1>Dashboard Admin</h1>
    <div class="row g-3 my-3">
        @foreach([['Sparepart',$productCount],['Kategori',$categoryCount],['Pesanan',$orderCount],['Customer',$customerCount]] as [$label,$value])
            <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><p class="text-muted mb-1">{{ $label }}</p><h2>{{ $value }}</h2></div></div></div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-header fw-bold">Pesanan Terbaru</div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead><tr><th>No</th><th>Customer</th><th>Status</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($latestOrders as $order)
                    <tr><td>{{ $order->order_number }}</td><td>{{ $order->user->name }}</td><td>{{ $order->status }}</td><td>Rp {{ number_format($order->total_amount,0,',','.') }}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
