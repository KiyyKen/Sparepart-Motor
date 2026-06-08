<x-layouts.admin :title="$order->order_number">
    <h1>Pesanan {{ $order->order_number }}</h1>
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card"><div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between border-bottom py-2"><span>{{ $item->product_name }} x {{ $item->quantity }}</span><strong>Rp {{ number_format($item->subtotal,0,',','.') }}</strong></div>
                @endforeach
                <h2 class="h4 mt-3">Total Rp {{ number_format($order->total_amount,0,',','.') }}</h2>
            </div></div>
        </div>
        <div class="col-lg-4">
            <form class="card card-body" method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf @method('PATCH')
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>HP:</strong> {{ $order->phone }}</p>
                <p><strong>Alamat:</strong><br>{{ $order->shipping_address }}</p>
                <label class="form-label">Status</label>
                <select class="form-select mb-3" name="status">@foreach(\App\Models\Order::STATUSES as $status)<option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
                <button class="btn btn-warning">Update Status</button>
            </form>
        </div>
    </div>
</x-layouts.admin>
