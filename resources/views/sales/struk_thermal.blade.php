<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan - Thermal</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 5px;
            background-color: #f8f9fa;
        }
        .struk {
            width: 40mm;
            min-height: 25mm;
            margin: 0 auto;
            background: white;
            padding: 1.5mm;
            border-radius: 1px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 4px;
            margin-bottom: 4px;
        }
        .title {
            font-size: 9px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .subtitle {
            font-size: 6px;
            color: #666;
            margin: 1px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 6px;
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
            margin: 3px 0;
        }
        .product-item {
            margin-bottom: 3px;
            padding-bottom: 2px;
            border-bottom: 1px dotted #eee;
        }
        .product-name {
            font-weight: bold;
            font-size: 7px;
            color: #333;
            margin-bottom: 1px;
        }
        .product-details {
            display: flex;
            justify-content: space-between;
            font-size: 5px;
            color: #666;
        }
        .total-section {
            border-top: 1px dashed #ddd;
            padding-top: 3px;
            margin-top: 3px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 7px;
            margin-bottom: 2px;
        }
        .grand-total {
            font-size: 8px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 4px;
            font-size: 4px;
            color: #999;
        }
        .actions {
            text-align: center;
            margin-top: 15px;
        }
        .btn {
            padding: 6px 12px;
            margin: 0 3px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 10px;
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
                size: 40mm auto;
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
