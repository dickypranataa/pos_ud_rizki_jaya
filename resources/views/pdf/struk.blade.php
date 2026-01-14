<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0px;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            /* Beri sedikit padding agar teks tidak mepet pinggir kertas */
            margin: 5px;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 14px;
        }

        .meta {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 2px 0;
        }

        .text-right {
            text-align: right;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .total-section {
            margin-top: 5px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            /* Pastikan footer tidak terlalu jauh ke bawah */
            margin-bottom: 5px;
        }
    </style>
    <title>Struk #{{ $sale->invoice_number }}</title>
</head>

<body>

    <div class="header">
        <h2>UD RIZKI JAYA</h2>
        <p>Jl. Raya Pompa Air No. 123<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="meta">
        No: {{ $sale->invoice_number }}<br>
        Tgl: {{ date('d/m/Y H:i', strtotime($sale->created_at)) }}<br>
        Kasir: {{ $sale->user->name }}<br>
        @if($sale->customer_name)
        Plg: {{ $sale->customer_name }}
        @endif
    </div>

    <table>
        @foreach($sale->items as $item)
        <tr>
            <td colspan="3">{{ $item->product->name }}</td>
        </tr>
        <tr>
            <td>{{ $item->quantity }} x {{ number_format($item->price_at_sale, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table class="total-section">
        <tr>
            <td>Metode Pembayaran</td>
            <td class="text-right">{{ $sale->payment_method }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="text-right">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="text-right">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer" style="margin-top: 20px;">
        <p>Terima Kasih<br>Barang yang sudah dibeli<br>tidak dapat ditukar/dikembalikan</p>
    </div>

</body>

</html>