<x-layouts.admin title="Pesanan Pelanggan">
    <h1>Pesanan Pelanggan</h1>
    <div class="card"><div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>No</th><th>Customer</th><th>Status</th><th>Total</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td><td>{{ $order->user->name }}</td><td>{{ $order->status }}</td><td>Rp {{ number_format($order->total_amount,0,',','.') }}</td><td>{{ $order->created_at->format('d M Y') }}</td>
                <td><a class="btn btn-sm btn-dark" href="{{ route('admin.orders.show', $order) }}">Detail</a></td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $orders->links() }}</div>
</x-layouts.admin>
