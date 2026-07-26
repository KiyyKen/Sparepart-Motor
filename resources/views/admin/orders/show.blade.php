<x-layouts.admin :title="$order->order_number">
    <h1 class="mono d-flex align-items-center gap-2">{{ $order->order_number }} <x-status-badge :status="$order->status" /></h1>
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card"><div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between border-bottom py-2"><span>{{ $item->product_name }} x {{ $item->quantity }}</span><strong class="mono">Rp {{ number_format($item->subtotal,0,',','.') }}</strong></div>
                @endforeach
                <h2 class="h4 mt-3 mono">Total Rp {{ number_format($order->total_amount,0,',','.') }}</h2>
            </div></div>
        </div>
        <div class="col-lg-4">
            <form class="card card-body mb-3" method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf @method('PATCH')
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>HP:</strong> {{ $order->phone }}</p>
                <p><strong>Alamat:</strong><br>{{ $order->shipping_address }}</p>
                @if($order->payment_type)
                    <p><strong>Metode Bayar:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</p>
                @endif
                <label class="form-label">Status</label>
                <select class="form-select mb-3" name="status">@foreach(\App\Models\Order::STATUSES as $status)<option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
                <button class="btn btn-warning">Update Status</button>
            </form>

            <div class="card">
                <div class="card-header fw-bold">Riwayat Status</div>
                <ul class="list-group list-group-flush">
                    @forelse($order->statusHistories as $history)
                        <li class="list-group-item">
                            <x-status-badge :status="$history->status" class="mb-1" />
                            <div class="small text-muted">{{ $history->created_at->translatedFormat('d M Y H:i') }}</div>
                            @if($history->note)
                                <div class="small">{{ $history->note }}</div>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item text-muted small">Belum ada riwayat status.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-layouts.admin>
