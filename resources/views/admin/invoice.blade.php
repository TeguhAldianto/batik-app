<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->number }}</title>
    <style>
        body { font-family: sans-serif; padding: 40px; color: #333; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .invoice-details { text-align: right; }
        .section { margin-bottom: 30px; }
        .section-title { font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #ccc; margin-bottom: 10px; padding-bottom: 5px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; border-bottom: none; }
        .print-btn { background: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <a href="#" onclick="window.print()" class="print-btn">🖨️ Cetak Invoice / Simpan PDF</a>

    <div class="header">
        <div class="logo">
            Batik Lasem<br>
            <span style="font-size: 12px; font-weight: normal;">Sekar Jagad Collection</span>
        </div>
        <div class="invoice-details">
            <strong>INVOICE</strong><br>
            #{{ $order->number }}<br>
            {{ $order->created_at->format('d F Y') }}<br>
            <span style="color: green; font-weight: bold; border: 1px solid green; padding: 2px 5px; border-radius: 4px;">LUNAS (PAID)</span>
        </div>
    </div>

    <div style="display: flex; gap: 40px; margin-bottom: 30px;">
        <div style="flex: 1;">
            <div class="section-title">Penerima</div>
            <strong>{{ $order->user->name }}</strong><br>
            {{ $order->user->phone }}<br>
            <div style="margin-top: 5px; color: #555;">
                {{ $order->shipping_address }}
            </div>
        </div>
        <div style="flex: 1;">
            <div class="section-title">Pengirim</div>
            <strong>Batik Tulis Lasem</strong><br>
            Jalan Raya Lasem No. 12<br>
            Rembang, Jawa Tengah<br>
            WA: 0812-3456-7890
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detail Item</div>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}<br>
                        <small style="color: #777;">Kategori: {{ str_replace('_', ' ', $item->product->category) }}</small>
                    </td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total Bayar</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #777;">
        Terima kasih telah berbelanja dan melestarikan budaya batik tulis Indonesia.
    </div>

</body>
</html>
