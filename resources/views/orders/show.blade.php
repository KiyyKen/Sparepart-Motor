<x-layouts.app :title="$order->order_number">
    <div class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h1 class="mb-0 mono">{{ $order->order_number }}</h1>
            <a class="btn btn-outline-dark btn-sm" href="{{ route('orders.invoice', $order) }}"><i class="bi bi-file-earmark-pdf"></i> Unduh Invoice</a>
        </div>

        <p>Status: <x-status-badge :status="$order->status" /></p>

        @if($order->status === 'pending')
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route('payment.show', $order) }}" class="btn btn-warning"><i class="bi bi-credit-card"></i> Lanjutkan Pembayaran</a>
                @if($order->snap_token)
                    <form method="POST" action="{{ route('payment.sync', $order) }}">
                        @csrf
                        <button class="btn btn-outline-dark"><i class="bi bi-arrow-clockwise"></i> Cek Status Pembayaran</button>
                    </form>
                @endif
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
                                <strong class="mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                            </div>

                            @if($order->status === 'completed')
                                @php $existingReview = $order->reviews->firstWhere('product_id', $item->product_id); @endphp
                                <div class="bg-light rounded p-3 my-2">
                                    @if($existingReview)
                                        <p class="mb-0 small text-muted">Kamu memberi rating {{ $existingReview->rating }}/5 untuk {{ $item->product_name }}.</p>
                                        @if($existingReview->comment)
                                            <p class="mb-0 small fst-italic">"{{ $existingReview->comment }}"</p>
                                        @endif
                                    @else
                                        <form method="POST" action="{{ route('reviews.store', $item->product_id) }}">
                                            @csrf
                                            <p class="mb-2 small fw-bold">Beri ulasan untuk {{ $item->product_name }}</p>
                                            <select name="rating" class="form-select form-select-sm mb-2" style="max-width: 160px;" required>
                                                <option value="">Rating</option>
                                                @for($i = 5; $i >= 1; $i--)
                                                    <option value="{{ $i }}">{{ $i }} Bintang</option>
                                                @endfor
                                            </select>
                                            <textarea name="comment" class="form-control form-control-sm mb-2" rows="2" placeholder="Komentar (opsional)"></textarea>
                                            <button class="btn btn-sm btn-warning">Kirim Ulasan</button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <h2 class="h4 mt-3 mono">Total Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
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
    </div>
</x-layouts.app>
