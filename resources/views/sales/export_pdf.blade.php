<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan MBah Saleh</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
        }

        .company-desc {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .company-address {
            font-size: 12px;
            color: #888;
            margin: 3px 0;
        }

        /* Report Info */
        .report-info {
            margin-bottom: 20px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            color: #333;
        }

        .period-info {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }

        /* Summary Section */
        .summary-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }

        .summary-grid {
            display: flex;
            justify-content: space-between;
        }

        .summary-item {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }

        /* Table Styles */
        .table-container {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }

        /* Footer */
        .footer {
            margin-top: 30px;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
            font-size: 10px;
            color: #666;
        }

        .footer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .generated-info {
            text-align: center;
            font-style: italic;
        }

        /* Page Break */
        .page-break {
            page-break-before: always;
        }

        /* Product Summary */
        .product-summary {
            margin-top: 20px;
        }

        .product-summary h4 {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .product-table th {
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1 class="company-name">MBah Saleh</h1>
        <p class="company-desc">Pemancingan Galatama</p>
        <p class="company-address">Jl. Raya Ikan No. 123, Jakarta</p>
        <p class="company-address">Telp: 0812-3456-7890 | Email: info@mbahsaleh.com</p>
    </div>

    <!-- Report Info -->
    <div class="report-info">
        <h2 class="report-title">LAPORAN PENJUALAN</h2>
        <div class="period-info">
            Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">RINGKASAN LAPORAN</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Total Transaksi</div>
                <div class="summary-value">{{ number_format($data->count()) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Kuantitas</div>
                <div class="summary-value">{{ number_format($data->sum('Jumlah'), 2) }} kg</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value">Rp {{ number_format($data->sum('Total Harga'), 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Rata-rata per Transaksi</div>
                <div class="summary-value">Rp {{ number_format($data->count() > 0 ? $data->sum('Total Harga') / $data->count() : 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="table-container">
        <h4 style="margin-bottom: 10px; color: #333;">Detail Transaksi</h4>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Produk</th>
                    <th width="10%">Kuantitas</th>
                    <th width="15%">Harga Satuan</th>
                    <th width="15%">Total Harga</th>
                    <th width="15%">Customer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row['Tanggal'])->format('d/m/Y H:i') }}</td>
                    <td>{{ $row['Produk'] }}</td>
                    <td class="text-right">{{ number_format($row['Jumlah'], 2) }} kg</td>
                    <td class="text-right">Rp {{ number_format($row['Total Harga'] / $row['Jumlah'], 0, ',', '.') }}</td>
                    <td class="text-right text-bold">Rp {{ number_format($row['Total Harga'], 0, ',', '.') }}</td>
                    <td>{{ $row['Customer'] ?: 'Umum' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #e9ecef; font-weight: bold;">
                    <td colspan="3" class="text-right">TOTAL:</td>
                    <td class="text-right">{{ number_format($data->sum('Jumlah'), 2) }} kg</td>
                    <td></td>
                    <td class="text-right">Rp {{ number_format($data->sum('Total Harga'), 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Product Summary -->
    <div class="product-summary">
        <h4>Ringkasan per Produk</h4>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Total Kuantitas</th>
                    <th>Total Pendapatan</th>
                    <th>% dari Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $productSummary = $data->groupBy('Produk')->map(function($group) {
                        return [
                            'quantity' => $group->sum('Jumlah'),
                            'revenue' => $group->sum('Total Harga')
                        ];
                    });
                    $totalRevenue = $data->sum('Total Harga');
                @endphp

                @foreach($productSummary as $product => $summary)
                <tr>
                    <td>{{ $product }}</td>
                    <td class="text-right">{{ number_format($summary['quantity'], 2) }} kg</td>
                    <td class="text-right">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalRevenue > 0 ? ($summary['revenue'] / $totalRevenue) * 100 : 0, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Customer Summary -->
    <div class="product-summary">
        <h4>Ringkasan per Customer</h4>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Total Transaksi</th>
                    <th>Total Kuantitas</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $customerSummary = $data->groupBy('Customer')->map(function($group) {
                        return [
                            'transactions' => $group->count(),
                            'quantity' => $group->sum('Jumlah'),
                            'revenue' => $group->sum('Total Harga')
                        ];
                    });
                @endphp

                @foreach($customerSummary as $customer => $summary)
                <tr>
                    <td>{{ $customer ?: 'Umum' }}</td>
                    <td class="text-center">{{ $summary['transactions'] }}</td>
                    <td class="text-right">{{ number_format($summary['quantity'], 2) }} kg</td>
                    <td class="text-right">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-info">
            <div>
                <strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'System' }}<br>
                <strong>Tanggal cetak:</strong> {{ now()->format('d/m/Y H:i:s') }}
            </div>
            <div>
                <strong>Laporan ini dibuat otomatis oleh sistem</strong><br>
                <strong>MBah Saleh - Pemancingan Galatama</strong>
            </div>
        </div>
        <div class="generated-info">
            Laporan ini dibuat pada {{ now()->format('d/m/Y H:i:s') }} oleh sistem MBah Saleh
        </div>
    </div>
</body>
</html>
