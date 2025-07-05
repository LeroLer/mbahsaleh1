@extends('layouts.app')

@section('title', 'Pilih Ukuran Struk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pilih Ukuran Struk</h1>
        <a href="{{ route('sales.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> {{ $sale_date->format('d/m/Y H:i') }}</p>
                            <p><strong>Customer:</strong> {{ $customer_name ?: 'Umum' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Items:</strong> {{ $item_count }} produk</p>
                            <p><strong>Total Amount:</strong> Rp {{ number_format($total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Struk Size Options -->
    <div class="row">
        <!-- A6 Struk -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Struk A6 (Default)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Ukuran: 105mm × 148mm
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                <ul>
                                    <li>Ukuran standar struk</li>
                                    <li>Cocok untuk printer biasa</li>
                                    <li>Hemat kertas</li>
                                    <li>Mudah dibawa</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-print fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('sales.struk', $sale_id) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-print"></i> Cetak Struk A6
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thermal Struk -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Struk Thermal
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Ukuran: 40mm (Lebar Fleksibel)
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                <ul>
                                    <li>Untuk printer thermal</li>
                                    <li>Ukuran kasir standar</li>
                                    <li>Cetak cepat</li>
                                    <li>Hemat biaya</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('sales.struk.thermal', $sale_id) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-receipt"></i> Cetak Struk Thermal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- A4 Struk -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Struk A4 (Formal)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Ukuran: 210mm × 297mm
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                <ul>
                                    <li>Struk formal</li>
                                    <li>Informasi lengkap</li>
                                    <li>Cocok untuk arsip</li>
                                    <li>Profesional</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('sales.struk.a4', $sale_id) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-file-alt"></i> Cetak Struk A4
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Struk</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h6>A6 Preview</h6>
                            <div style="width: 105px; height: 148px; border: 2px solid #007bff; margin: 0 auto; background: #f8f9fa; position: relative;">
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 10px; text-align: center;">
                                    <strong>MBah Saleh</strong><br>
                                    <small>Pemancingan</small>
                                </div>
                            </div>
                            <small class="text-muted">105mm × 148mm</small>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6>Thermal Coreless Preview</h6>
                            <div style="width: 40px; height: 35px; border: 2px solid #28a745; margin: 0 auto; background: #f8f9fa; position: relative;">
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 6px; text-align: center;">
                                    <strong>MBah Saleh</strong><br>
                                    <small>Pemancingan</small>
                                </div>
                            </div>
                            <small class="text-muted">40mm (Lebar Fleksibel)</small>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6>A4 Preview</h6>
                            <div style="width: 210px; height: 297px; border: 2px solid #17a2b8; margin: 0 auto; background: #f8f9fa; position: relative; transform: scale(0.3); transform-origin: top center;">
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 20px; text-align: center;">
                                    <strong>MBah Saleh</strong><br>
                                    <small>Pemancingan Galatama</small>
                                </div>
                            </div>
                            <small class="text-muted">210mm × 297mm</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
