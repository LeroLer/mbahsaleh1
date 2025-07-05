<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan - A4</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .struk {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 20mm;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #007bff;
        }
        .subtitle {
            font-size: 16px;
            color: #666;
            margin: 8px 0;
        }
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
        .info-value {
            color: #666;
        }
        .divider {
            border-top: 2px solid #ddd;
            margin: 25px 0;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .products-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
            color: #333;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #666;
        }
        .product-name {
            font-weight: bold;
            color: #333;
        }
        .total-section {
            border-top: 3px solid #007bff;
            padding-top: 20px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            border-top: 2px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .actions {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            margin: 0 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }
            .actions { display: none; }
            .struk {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="struk">
        <div class="header">
            <h1 class="title">MBah Saleh</h1>
            <p class="subtitle">Pemancingan Galatama</p>
            <p class="subtitle">Jl. Raya Ikan No. 123, Jakarta</p>
            <p class="subtitle">Telp: 0812-3456-7890 | Email: info@mbahsaleh.com</p>
        </div>

        <div class="info-section">
            <div>
                <div class="info-row">
                    <span class="info-label">Tanggal Transaksi:</span>
                    <span class="info-value">{{ $sale_date->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">{{ $customer_name ?: 'Umum' }}</span>
                </div>
            </div>
            <div>
                <div class="info-row">
                    <span class="info-label">Jumlah Items:</span>
                    <span class="info-value">{{ $item_count }} produk</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Struk:</span>
                    <span class="info-value">#{{ $sale_date->format('YmdHis') }}</span>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <table class="products-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td class="product-name">{{ $sale->product->name }}</td>
                        <td>{{ $sale->quantity }} kg</td>
                        <td>Rp {{ number_format($sale->product->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Total Kuantitas:</span>
                <span>{{ $total_quantity }} kg</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL PEMBAYARAN:</span>
                <span>Rp {{ number_format($total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p><strong>Terima kasih telah berbelanja di MBah Saleh</strong></p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada kerusakan</p>
            <p>Struk ini adalah bukti pembayaran yang sah</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <div class="actions">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</body>
</html>
