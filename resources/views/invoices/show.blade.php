<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #1f2937; }
        h1 { font-size: 20px; margin-bottom: 0; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
        .text-right { text-align: right; }
        .totals td { border: none; }
        .header { display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <h1>MotoPart Garage</h1>
    <p class="muted">Invoice Pesanan</p>

    <table class="totals" style="margin-top: 8px;">
        <tr>
            <td><strong>Nomor Pesanan</strong></td>
            <td>{{ $order->order_number }}</td>
            <td><strong>Tanggal</strong></td>
            <td>{{ $order->created_at->translatedFormat('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pelanggan</strong></td>
            <td>{{ $order->customer_name }}</td>
            <td><strong>Status</strong></td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>
        <tr>
            <td><strong>Telepon</strong></td>
            <td>{{ $order->phone }}</td>
            <td><strong>Alamat</strong></td>
            <td>{{ $order->shipping_address }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Sparepart</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals" style="margin-top: 8px;">
        <tr>
            <td class="text-right" style="width: 85%;"><strong>Total Tagihan</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <p class="muted" style="margin-top: 24px;">Terima kasih telah berbelanja di MotoPart Garage.</p>
</body>
</html>
