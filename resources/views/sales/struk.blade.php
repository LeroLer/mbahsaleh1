<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .struk {
            width: 105mm;
            height: 148mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .subtitle {
            font-size: 10px;
            color: #666;
            margin: 3px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #333;
        }
        .info-value {
            color: #666;
        }
        .divider {
            border-top: 1px dashed #ddd;
            margin: 10px 0;
        }
        .product-item {
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dotted #eee;
        }
        .product-name {
            font-weight: bold;
            font-size: 11px;
            color: #333;
            margin-bottom: 2px;
        }
        .product-details {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #666;
        }
        .total-section {
            border-top: 2px dashed #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 8px;
            color: #999;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
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
                size: A6;
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
            <p class="subtitle">Jl. Raya Ikan No. 123</p>
            <p class="subtitle">Telp: 0812-3456-7890</p>
        </div>

        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span class="info-value">{{ $sale_date->format('d/m/Y H:i') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Customer:</span>
            <span class="info-value">{{ $customer_name ?: 'Umum' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Items:</span>
            <span class="info-value">{{ $item_count }} produk</span>
        </div>

        <div class="divider"></div>

        @foreach($sales as $sale)
            <div class="product-item">
                <div class="product-name">{{ $sale->product->name }}</div>
                <div class="product-details">
                    <span>{{ $sale->quantity }} kg × Rp {{ number_format($sale->product->price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <div class="total-section">
            <div class="total-row">
                <span>Total Kuantitas:</span>
                <span>{{ $total_quantity }} kg</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p>{{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <div class="actions">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak
        </button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
