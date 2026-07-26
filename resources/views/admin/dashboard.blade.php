<x-layouts.admin title="Dashboard Admin">
    <h1>Dashboard Admin</h1>
    <div class="row g-3 my-3">
        @foreach([['Sparepart',$productCount],['Kategori',$categoryCount],['Pesanan',$orderCount],['Customer',$customerCount]] as [$label,$value])
            <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><p class="text-muted mb-1">{{ $label }}</p><h2>{{ $value }}</h2></div></div></div>
        @endforeach
        <div class="col-md-3"><div class="card shadow-sm"><div class="card-body"><p class="text-muted mb-1">Total Omzet</p><h2>Rp {{ number_format($revenueTotal, 0, ',', '.') }}</h2></div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header fw-bold">Omzet 14 Hari Terakhir</div>
                <div class="card-body"><canvas id="salesChart" height="110"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header fw-bold">Status Pesanan</div>
                <div class="card-body"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header fw-bold">5 Sparepart Terlaris</div>
                <div class="card-body"><canvas id="topProductsChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
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
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script>
            new Chart(document.getElementById('salesChart'), {
                type: 'line',
                data: {
                    labels: @json($salesChart->pluck('label')),
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: @json($salesChart->pluck('total')),
                        borderColor: '#ff6b00',
                        backgroundColor: 'rgba(255,107,0,0.15)',
                        tension: 0.3,
                        fill: true,
                    }],
                },
                options: { plugins: { legend: { display: false } } },
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($statusCounts->keys()->map(fn($s) => ucfirst($s))),
                    datasets: [{
                        data: @json($statusCounts->values()),
                        backgroundColor: ['#6b7280', '#0dcaf0', '#ffc107', '#198754', '#dc3545'],
                    }],
                },
            });

            new Chart(document.getElementById('topProductsChart'), {
                type: 'bar',
                data: {
                    labels: @json($topProducts->pluck('product_name')),
                    datasets: [{
                        label: 'Terjual (qty)',
                        data: @json($topProducts->pluck('total_qty')),
                        backgroundColor: '#101820',
                    }],
                },
                options: { indexAxis: 'y', plugins: { legend: { display: false } } },
            });
        </script>
    @endpush
</x-layouts.admin>
