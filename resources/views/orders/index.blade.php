<x-layouts.app title="Riwayat Pesanan">
    <div class="container py-5">
        <h1>Riwayat Pesanan</h1>
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table mb-0">
                <thead><tr><th>No</th><th>Status</th><th>Total</th><th>Tanggal</th><th></th></tr></thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td><span class="badge text-bg-secondary">{{ $order->status }}</span></td>
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td><a class="btn btn-sm btn-dark" href="{{ route('orders.show', $order) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada pesanan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    </div>
</x-layouts.app>
