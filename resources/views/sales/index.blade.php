@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penjualan</h1>
    <a href="{{ route('sales.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penjualan
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Kuantitas (kg)</th>
                                <th>Harga Per Kilogram</th>
                                <th>Total Harga</th>
                                <th>Nama Pelanggan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->sale_date->format('d/m/Y H:i') }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>Rp {{ number_format($sale->product->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $sale->customer_name }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('sales.struk', $sale->id) }}" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
