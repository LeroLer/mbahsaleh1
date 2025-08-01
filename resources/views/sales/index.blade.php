@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Penjualan</h1>
    <div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('sales.export.page') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm me-2">
            <i class="fas fa-file-export fa-sm text-white-50"></i> Export Laporan
        </a>
        @endif
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
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        ID bersifat konsisten dan tidak berubah saat filtering.
                        Urutkan berdasarkan tanggal untuk melihat data terbaru.
                    </small>
                </div>
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
                                <th title="ID konsisten dari database - tidak berubah saat filtering">ID <i class="fas fa-question-circle text-info"></i></th>
                                <th>Detail ID</th>
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
                                    <td class="id-column">{{ $sale['id'] }}</td>
                                    <td class="detail-id-column">
                                        @if($sale['item_count'] > 1)
                                            <span class="badge badge-info">{{ $sale['item_count'] }} items</span>
                                            <small class="text-muted d-block">Multi-produk</small>
                                        @else
                                            <span class="badge badge-success">Single</span>
                                            <small class="text-muted d-block">1 produk</small>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sale['sale_date'])->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($sale['item_count'] == 1)
                                            <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#productsModal{{ $sale['id'] }}">
                                                Detail Produk
                                            </button>
                                            <!-- Modal untuk single produk -->
                                            <div class="modal fade" id="productsModal{{ $sale['id'] }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Produk - ID: {{ $sale['id'] }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item"><strong>Nama Produk:</strong> {{ $sale['products'][0]['name'] }}</li>
                                                                <li class="list-group-item"><strong>Kuantitas:</strong> {{ $sale['products'][0]['quantity'] }} kg</li>
                                                                <li class="list-group-item"><strong>Harga/kg:</strong> Rp {{ number_format($sale['products'][0]['price_per_kg'], 0, ',', '.') }}</li>
                                                                <li class="list-group-item"><strong>Total Harga:</strong> Rp {{ number_format($sale['products'][0]['total_price'], 0, ',', '.') }}</li>
                                                                @if($sale['products'][0]['scale_photo'])
                                                                    <li class="list-group-item">
                                                                        <strong>Foto Timbangan:</strong><br>
                                                                        <img src="{{ asset('storage/' . $sale['products'][0]['scale_photo']) }}" alt="Foto Timbangan" style="max-width: 180px;" class="img-thumbnail mt-2">
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                    data-toggle="modal"
                                                    data-target="#productsModal{{ $sale['id'] }}">
                                                {{ $sale['item_count'] }} Produk
                                            </button>
                                            <!-- Modal untuk multi produk -->
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
                                                                            <th>Foto Timbangan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($sale['products'] as $product)
                                                                            <tr>
                                                                                <td>{{ $product['name'] }}</td>
                                                                                <td>{{ $product['quantity'] }} kg</td>
                                                                                <td>Rp {{ number_format($product['price_per_kg'], 0, ',', '.') }}</td>
                                                                                <td>Rp {{ number_format($product['total_price'], 0, ',', '.') }}</td>
                                                                                <td>
                                                                                    @if($product['scale_photo'])
                                                                                        <img src="{{ asset('storage/' . $product['scale_photo']) }}" alt="Foto Timbangan" style="max-width: 100px;" class="img-thumbnail">
                                                                                    @else
                                                                                        <span class="text-muted">-</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="table-info">
                                                                            <td colspan="4" class="text-right font-weight-bold">Total:</td>
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
                                            @if(auth()->user()->isAdmin())
                                            <a href="{{ route('sales.edit', $sale['id']) }}" class="btn btn-warning btn-sm" title="Edit Penjualan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteSales({{ json_encode($sale['all_sale_ids']) }})"
                                                    title="Hapus Penjualan">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Cetak Struk">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ route('sales.struk.select', $sale['id']) }}">
                                                        <i class="fas fa-cog fa-sm"></i> Pilih Ukuran Struk
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="{{ route('sales.struk', $sale['id']) }}" target="_blank">
                                                        <i class="fas fa-print fa-sm"></i> Struk A6 (Default)
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('sales.struk.thermal', $sale['id']) }}" target="_blank">
                                                        <i class="fas fa-receipt fa-sm"></i> Struk Thermal Coreless (40mm)
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('sales.struk.a4', $sale['id']) }}" target="_blank">
                                                        <i class="fas fa-file-alt fa-sm"></i> Struk A4 (Formal)
                                                    </a>
                                                </div>
                                            </div>
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
<style>
    .id-column {
        font-weight: bold;
        color: #007bff;
        text-align: center;
        background-color: #f8f9fa;
    }
    .id-column:hover {
        background-color: #e9ecef;
    }
    .detail-id-column {
        text-align: center;
    }
    .badge {
        font-size: 0.75em;
    }
    .fa-question-circle {
        font-size: 0.8em;
        cursor: help;
    }
    .table th {
        position: relative;
    }
    .table th[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 25,
            "order": [[2, "desc"]], // Urutkan berdasarkan tanggal (kolom 2) descending
            "columnDefs": [
                {
                    "targets": 0, // Kolom ID
                    "orderable": false, // Tidak bisa diurutkan
                    "searchable": false // Tidak bisa dicari
                },
                {
                    "targets": 1, // Kolom Detail ID
                    "orderable": false, // Tidak bisa diurutkan
                    "searchable": false // Tidak bisa dicari
                }
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "drawCallback": function(settings) {
                // Pastikan ID tetap konsisten setelah filtering
                var api = this.api();
                var rows = api.rows({page: 'current'}).nodes();
                var start = api.page.info().start;

                // ID tetap menggunakan data asli dari database
                $(rows).each(function(index) {
                    var data = api.row(this).data();
                    $(this).find('td:first').text(data[0]); // ID dari database
                });
            }
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
