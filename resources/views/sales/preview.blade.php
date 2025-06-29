@extends('layouts.app')

@section('title', 'Preview Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Preview Penjualan</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-8 col-lg-8 mx-auto">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penjualan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold">Produk:</td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Harga per kg:</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Jumlah:</td>
                                <td>{{ $quantity }} kg</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Total Harga:</td>
                                <td class="text-primary font-weight-bold">Rp {{ number_format($total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="font-weight-bold">Tanggal Penjualan:</td>
                                <td>{{ \Carbon\Carbon::parse($sale_date)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Nama Pelanggan:</td>
                                <td>{{ $customer_name ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Perhatian:</strong> Pastikan semua data di atas sudah benar sebelum menyimpan ke database.
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('sales.create') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali & Edit
                    </a>
                    <div>
                        <form action="{{ route('sales.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            <input type="hidden" name="sale_date" value="{{ $sale_date }}">
                            <input type="hidden" name="customer_name" value="{{ $customer_name }}">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Konfirmasi & Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
