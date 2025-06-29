@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penjualan</h1>
    <div>
        <a href="{{ route('sales.export.page') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm me-2">
            <i class="fas fa-file-export fa-sm text-white-50"></i> Export Laporan
        </a>
        <a href="{{ route('sales.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penjualan
        </a>
    </div>
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
                                <th>ID Penjualan</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Total Kuantitas</th>
                                <th>Total Harga</th>
                                <th>Nama Pelanggan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $sale['id'] }}</span>
                                        @if($sale['item_count'] > 1)
                                            <span class="badge badge-info">{{ $sale['item_count'] }} items</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sale['sale_date'])->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($sale['item_count'] == 1)
                                            {{ $sale['products'][0]['name'] }}
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                    data-toggle="modal"
                                                    data-target="#productsModal{{ $sale['id'] }}">
                                                {{ $sale['item_count'] }} Produk
                                            </button>

                                            <!-- Modal untuk menampilkan detail produk -->
                                            <div class="modal fade" id="productsModal{{ $sale['id'] }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Produk - ID: {{ $sale['id'] }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Produk</th>
                                                                            <th>Kuantitas</th>
                                                                            <th>Harga/kg</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($sale['products'] as $product)
                                                                            <tr>
                                                                                <td>{{ $product['name'] }}</td>
                                                                                <td>{{ $product['quantity'] }} kg</td>
                                                                                <td>Rp {{ number_format($product['price_per_kg'], 0, ',', '.') }}</td>
                                                                                <td>Rp {{ number_format($product['total_price'], 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="table-info">
                                                                            <td colspan="3" class="text-right font-weight-bold">Total:</td>
                                                                            <td class="font-weight-bold">Rp {{ number_format($sale['total_amount'], 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $sale['total_quantity'] }} kg</td>
                                    <td>Rp {{ number_format($sale['total_amount'], 0, ',', '.') }}</td>
                                    <td>{{ $sale['customer_name'] ?: '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('sales.edit', $sale['id']) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('sales.struk', $sale['id']) }}" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteSales({{ json_encode($sale['all_sale_ids']) }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Form untuk delete multiple sales -->
                <form id="deleteForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
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
        $('#dataTable').DataTable({
            "pageLength": 25,
            "order": [[2, "desc"]] // Urutkan berdasarkan tanggal (kolom 2) descending
        });
    });

    function deleteSales(saleIds) {
        if (confirm('Apakah Anda yakin ingin menghapus penjualan ini?')) {
            // Hapus satu per satu karena mungkin ada multiple sales
            let deletedCount = 0;
            const totalCount = saleIds.length;

            saleIds.forEach(function(saleId) {
                fetch(`/sales/${saleId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    deletedCount++;
                    if (deletedCount === totalCount) {
                        // Semua berhasil dihapus, reload halaman
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error deleting sale:', error);
                    alert('Terjadi kesalahan saat menghapus penjualan');
                });
            });
        }
    }
</script>
@endpush
