@extends('layouts.app')

@section('title', 'Struk Penjualan')

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <div class="card shadow">
        <div class="card-body">
            <h5 class="text-center mb-3">Struk Penjualan</h5>
            <hr>
            <p><strong>Tanggal:</strong> {{ $sale->sale_date->format('d/m/Y H:i') }}</p>
            <p><strong>Produk:</strong> {{ $sale->product->name }}</p>
            <p><strong>Jumlah:</strong> {{ $sale->quantity }} kg</p>
            <p><strong>Harga/kg:</strong> Rp {{ number_format($sale->product->price, 0, ',', '.') }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $sale->customer_name ?? '-' }}</p>
            <p><strong>Total:</strong> <span class="h5">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span></p>
            <hr>
            <div class="text-center">
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
