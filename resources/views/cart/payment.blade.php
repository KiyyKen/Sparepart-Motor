<x-layouts.app title="Pembayaran - MotoPart Garage">
    <div class="container py-5" style="max-width: 640px;">
        <h1 class="h3 mb-4">Pembayaran Pesanan</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5">Nomor Pesanan</dt>
                    <dd class="col-7">{{ $order->order_number }}</dd>
                    <dt class="col-5">Nama</dt>
                    <dd class="col-7">{{ $order->customer_name }}</dd>
                    <dt class="col-5">Total Tagihan</dt>
                    <dd class="col-7 fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                </dl>
            </div>
        </div>

        @if(! $clientKey)
            <div class="alert alert-warning">
                Payment gateway belum dikonfigurasi. Hubungi admin atau set <code>MIDTRANS_SERVER_KEY</code> dan <code>MIDTRANS_CLIENT_KEY</code> di file <code>.env</code>.
            </div>
        @else
            <button id="pay-button" class="btn btn-warning btn-lg w-100">Bayar Sekarang</button>
        @endif

        <a href="{{ route('orders.show', $order) }}" class="btn btn-link mt-3">Bayar nanti, lihat detail pesanan</a>
    </div>

    @if($clientKey)
        @push('scripts')
            <script
                src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
                data-client-key="{{ $clientKey }}"></script>
            <script>
                document.getElementById('pay-button').addEventListener('click', function () {
                    snap.pay(@json($order->snap_token), {
                        onSuccess: function () {
                            window.location.href = @json(route('orders.show', $order));
                        },
                        onPending: function () {
                            window.location.href = @json(route('orders.show', $order));
                        },
                        onError: function () {
                            alert('Pembayaran gagal, silakan coba lagi.');
                        }
                    });
                });
            </script>
        @endpush
    @endif
</x-layouts.app>
