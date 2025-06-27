<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2 { margin-bottom: 0; }
        .periode { margin-top: 0; font-size: 13px; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <div class="periode">Periode: {{ $start_date }} s/d {{ $end_date }}</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row['Tanggal'] }}</td>
                <td>{{ $row['Produk'] }}</td>
                <td>{{ $row['Jumlah'] }}</td>
                <td>Rp {{ number_format($row['Total Harga'],0,',','.') }}</td>
                <td>{{ $row['Customer'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
