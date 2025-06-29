@extends('layouts.app')

@section('title', 'Preview Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Preview Penjualan</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-10 col-lg-10 mx-auto">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penjualan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!-- Products Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga per kg</th>
                                <th>Jumlah (kg)</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td class="text-right">Rp {{ number_format($product['total'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-info">
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Total Keseluruhan:</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Transaction Info -->
                <div class="row">
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
                            <tr>
                                <td class="font-weight-bold">Jumlah Produk:</td>
                                <td>{{ count($products) }} item</td>
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
                            @foreach($products as $index => $product)
                                <input type="hidden" name="products[{{ $index }}][product_id]" value="{{ $product['id'] }}">
                                <input type="hidden" name="products[{{ $index }}][quantity]" value="{{ $product['quantity'] }}">
                            @endforeach
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
