<x-layouts.app :title="$order->order_number">
    <div class="container py-5">
        <h1>Pesanan {{ $order->order_number }}</h1>
        <p>Status: <span class="badge text-bg-secondary">{{ $order->status }}</span></p>
        <div class="card"><div class="card-body">
            @foreach($order->items as $item)
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
                    <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                </div>
            @endforeach
            <h2 class="h4 mt-3">Total Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h2>
        </div></div>
    </div>
</x-layouts.app>
