@extends('layouts.app')

@section('title', 'Export Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Export Laporan Penjualan</h1>
        <a href="{{ route('sales.index') }}" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Form Filter -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('sales.export.page') }}" id="filterForm">
                        <div class="form-group mb-3">
                            <label for="start_date" class="font-weight-bold">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                   value="{{ $start_date }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_date" class="font-weight-bold">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                   value="{{ $end_date }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Tampilkan Data
                        </button>
                    </form>

                    @if($start_date && $end_date)
                        <hr>
                        <div class="text-center">
                            <h6 class="font-weight-bold text-success">Export Data</h6>
                            <div class="row">
                                <div class="col-6">
                                    <form method="POST" action="{{ route('sales.export') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{ $start_date }}">
                                        <input type="hidden" name="end_date" value="{{ $end_date }}">
                                        <input type="hidden" name="format" value="excel">
                                        <button type="submit" class="btn btn-success btn-sm btn-block mb-2">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form method="POST" action="{{ route('sales.export') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{ $start_date }}">
                                        <input type="hidden" name="end_date" value="{{ $end_date }}">
                                        <input type="hidden" name="format" value="pdf">
                                        <button type="submit" class="btn btn-danger btn-sm btn-block mb-2">
                                            <i class="fas fa-file-pdf"></i> Export PDF
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Info Export -->
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Excel:</strong> 3 sheet (Detail, Ringkasan Produk, Ringkasan Customer)<br>
                                    <strong>PDF:</strong> Laporan lengkap dengan header & footer
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Cards -->
            @if($start_date && $end_date)
                <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Transaksi
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_transactions) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Kuantitas
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($total_quantity, 2) }} kg
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-weight fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Pendapatan
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rp {{ number_format($total_amount, 0, ',', '.') }}
                                        </div>
                                        @if($total_transactions > 0)
                                            <div class="text-xs text-muted">
                                                Rata-rata: Rp {{ number_format($total_amount / $total_transactions, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Informasi Laporan
                                        </div>
                                        <div class="text-xs text-gray-800">
                                            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}<br>
                                            <strong>Durasi:</strong> {{ \Carbon\Carbon::parse($start_date)->diffInDays(\Carbon\Carbon::parse($end_date)) + 1 }} hari<br>
                                            <strong>Dibuat:</strong> {{ now()->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Preview Data -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Preview Data Penjualan
                        @if($start_date && $end_date)
                            <small class="text-muted">
                                ({{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }})
                            </small>
                        @endif
                    </h6>
                    @if($start_date && $end_date && $sales->count() > 0)
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <form method="POST" action="{{ route('sales.export') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="hidden" name="format" value="excel">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-file-excel text-success"></i> Export Excel
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('sales.export') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="hidden" name="format" value="pdf">
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-file-pdf text-danger"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if(!$start_date || !$end_date)
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-alt fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">Pilih Rentang Tanggal</h5>
                            <p class="text-gray-400">Silakan pilih tanggal mulai dan tanggal akhir untuk melihat preview data</p>
                        </div>
                    @elseif($sales->count() == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">Tidak Ada Data</h5>
                            <p class="text-gray-400">Tidak ada data penjualan untuk rentang tanggal yang dipilih</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered" id="previewTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Produk</th>
                                        <th>Kuantitas</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Customer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $index => $sale)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $sale->product ? $sale->product->name : '-' }}</td>
                                            <td>{{ number_format($sale->quantity, 2) }} kg</td>
                                            <td>Rp {{ number_format($sale->product ? $sale->product->price : 0, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                            <td>{{ $sale->customer_name ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <td colspan="3" class="text-right font-weight-bold">Total:</td>
                                        <td class="font-weight-bold">{{ number_format($total_quantity, 2) }} kg</td>
                                        <td></td>
                                        <td class="font-weight-bold">Rp {{ number_format($total_amount, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Additional Information -->
                        @if($sales->count() > 0)
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-left-success">
                                            <div class="card-body">
                                                <h6 class="card-title text-success">
                                                    <i class="fas fa-chart-pie"></i> Ringkasan per Produk
                                                </h6>
                                                @php
                                                    $productSummary = $sales->groupBy('product_id')->map(function($group) {
                                                        return [
                                                            'name' => $group->first()->product ? $group->first()->product->name : 'Unknown',
                                                            'quantity' => $group->sum('quantity'),
                                                            'revenue' => $group->sum('total_price'),
                                                            'transactions' => $group->count()
                                                        ];
                                                    });
                                                @endphp
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Produk</th>
                                                                <th>Qty</th>
                                                                <th>Pendapatan</th>
                                                                <th>%</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($productSummary as $product)
                                                                <tr>
                                                                    <td>{{ $product['name'] }}</td>
                                                                    <td>{{ number_format($product['quantity'], 2) }} kg</td>
                                                                    <td>Rp {{ number_format($product['revenue'], 0, ',', '.') }}</td>
                                                                    <td>{{ number_format(($product['revenue'] / $total_amount) * 100, 1) }}%</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-left-info">
                                            <div class="card-body">
                                                <h6 class="card-title text-info">
                                                    <i class="fas fa-users"></i> Ringkasan per Customer
                                                </h6>
                                                @php
                                                    $customerSummary = $sales->groupBy('customer_name')->map(function($group) {
                                                        return [
                                                            'name' => $group->first()->customer_name ?: 'Umum',
                                                            'quantity' => $group->sum('quantity'),
                                                            'revenue' => $group->sum('total_price'),
                                                            'transactions' => $group->count()
                                                        ];
                                                    });
                                                @endphp
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <th>Transaksi</th>
                                                                <th>Qty</th>
                                                                <th>Pendapatan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($customerSummary as $customer)
                                                                <tr>
                                                                    <td>{{ $customer['name'] }}</td>
                                                                    <td>{{ $customer['transactions'] }}</td>
                                                                    <td>{{ number_format($customer['quantity'], 2) }} kg</td>
                                                                    <td>Rp {{ number_format($customer['revenue'], 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-warning">
                                <i class="fas fa-info-circle"></i> Informasi Export
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Excel Export:</strong><br>
                                        • 3 worksheet (Detail, Ringkasan Produk, Ringkasan Customer)<br>
                                        • Header perusahaan dan styling otomatis<br>
                                        • Format .xlsx (Excel 2007+)<br>
                                        • Nama file: laporan-penjualan-[tanggal].xlsx
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>PDF Export:</strong><br>
                                        • Laporan lengkap dengan header & footer<br>
                                        • Ukuran A4 portrait<br>
                                        • Font DejaVu Sans (support Indonesia)<br>
                                        • Nama file: laporan-penjualan-[tanggal].pdf
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="text-muted">
                                <small>
                                    <strong>Dibuat oleh:</strong> {{ auth()->user()->name ?? 'System' }}<br>
                                    <strong>Tanggal:</strong> {{ now()->format('d/m/Y H:i:s') }}<br>
                                    <strong>Versi:</strong> 2.0 - Enhanced Export
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .table th {
        background-color: #f8f9fc;
        border-color: #e3e6f0;
        font-weight: 600;
    }
    .table td {
        border-color: #e3e6f0;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Set default dates (last 30 days)
        if (!$('#start_date').val()) {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(startDate.getDate() - 30);

            $('#end_date').val(endDate.toISOString().split('T')[0]);
            $('#start_date').val(startDate.toISOString().split('T')[0]);
        }

        // Validate date range
        $('#filterForm').on('submit', function(e) {
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($('#end_date').val());

            if (startDate > endDate) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return false;
            }
        });

        // Initialize DataTable for preview
        if ($('#previewTable').length) {
            $('#previewTable').DataTable({
                "pageLength": 25,
                "order": [[1, "desc"]], // Sort by date descending
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        }
    });
</script>
@endpush
