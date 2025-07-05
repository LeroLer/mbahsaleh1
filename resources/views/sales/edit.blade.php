@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Penjualan</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Penjualan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Transaksi -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sale_date" class="font-weight-bold">Tanggal Penjualan</label>
                                <input type="datetime-local" class="form-control @error('sale_date') is-invalid @enderror"
                                       id="sale_date" name="sale_date"
                                       value="{{ old('sale_date', $sale->sale_date->format('Y-m-d\TH:i')) }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name" class="font-weight-bold">Nama Pelanggan</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{ old('customer_name', $sale->customer_name) }}">
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Produk yang Ada -->
                    <h6 class="font-weight-bold text-primary mb-3">Produk yang Ada</h6>
                    <div id="existingProducts">
                                                @foreach($allSales as $index => $existingSale)
                            <div class="product-row border rounded p-3 mb-3" data-sale-id="{{ $existingSale->id }}" data-index="{{ $index }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Produk</label>
                                            <select class="form-control product-select"
                                                    name="sales[{{ $index }}][product_id]"
                                                    data-index="{{ $index }}" required>
                                                <option value="">Pilih Produk</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                            data-price="{{ $product->price }}"
                                                            {{ $existingSale->product_id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="sales[{{ $index }}][id]" value="{{ $existingSale->id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jumlah (kg)</label>
                                            <input type="number" step="0.01" min="0.01"
                                                   class="form-control quantity-input"
                                                   name="sales[{{ $index }}][quantity]"
                                                   value="{{ $existingSale->quantity }}"
                                                   data-index="{{ $index }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Harga</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control total-price"
                                                       data-index="{{ $index }}" readonly
                                                       value="{{ number_format($existingSale->total_price, 0, ',', '.') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-block remove-product"
                                                    data-sale-id="{{ $existingSale->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tombol Tambah Produk -->
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-success" id="addProduct">
                            <i class="fas fa-plus"></i> Tambah Produk Baru
                        </button>
                    </div>

                    <!-- Produk Baru -->
                    <div id="newProducts" style="display: none;">
                        <h6 class="font-weight-bold text-success mb-3">Produk Baru</h6>
                        <div id="newProductsContainer"></div>
                    </div>

                    <!-- Total Keseluruhan -->
                    <hr>
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="font-weight-bold">Total Keseluruhan</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Kuantitas:</strong>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span id="grandTotalQuantity">0</span> kg
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Total Harga:</strong>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span id="grandTotalPrice">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus produk ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let newProductIndex = 0;
        let productToDelete = null;

                        // Hitung total untuk setiap produk
        function calculateProductTotal(index) {
            const productRow = $(`.product-row[data-index="${index}"], .new-product-row[data-index="${index}"]`);
            const select = productRow.find('.product-select');
            const quantity = productRow.find('.quantity-input');
            const totalPrice = productRow.find('.total-price');

            const price = select.find('option:selected').data('price') || 0;
            const qty = quantity.val() || 0;
            const total = price * qty;

            totalPrice.val(total.toLocaleString('id-ID'));

            calculateGrandTotal();
        }

        // Hitung total keseluruhan
        function calculateGrandTotal() {
            let totalQuantity = 0;
            let totalPrice = 0;

            $('.quantity-input').each(function() {
                totalQuantity += parseFloat($(this).val()) || 0;
            });

            $('.total-price').each(function() {
                const price = $(this).val().replace(/[^\d]/g, '');
                totalPrice += parseFloat(price) || 0;
            });

            $('#grandTotalQuantity').text(totalQuantity.toFixed(2));
            $('#grandTotalPrice').text('Rp ' + totalPrice.toLocaleString('id-ID'));
        }

        // Event listener untuk perubahan produk dan kuantitas
        $(document).on('change keyup', '.product-select, .quantity-input', function() {
            const index = $(this).data('index');
            calculateProductTotal(index);
        });

        // Tambah produk baru
        $('#addProduct').click(function() {
            const newProductHtml = `
                <div class="new-product-row border rounded p-3 mb-3" data-index="new_${newProductIndex}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Produk</label>
                                <select class="form-control product-select"
                                        name="new_products[${newProductIndex}][product_id]"
                                        data-index="new_${newProductIndex}">
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Jumlah (kg)</label>
                                <input type="number" step="0.01" min="0.01"
                                       class="form-control quantity-input"
                                       name="new_products[${newProductIndex}][quantity]"
                                       data-index="new_${newProductIndex}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total Harga</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control total-price"
                                           data-index="new_${newProductIndex}" readonly value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-warning btn-block remove-new-product"
                                        data-index="new_${newProductIndex}">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#newProductsContainer').append(newProductHtml);
            $('#newProducts').show();
            newProductIndex++;
        });

        // Hapus produk baru
        $(document).on('click', '.remove-new-product', function() {
            $(this).closest('.new-product-row').remove();
            if ($('#newProductsContainer').children().length === 0) {
                $('#newProducts').hide();
            }
            calculateGrandTotal();
        });

        // Hapus produk yang ada
        $(document).on('click', '.remove-product', function() {
            productToDelete = $(this).data('sale-id');
            $('#deleteModal').modal('show');
        });

        // Konfirmasi hapus
        $('#confirmDelete').click(function() {
            if (productToDelete) {
                // Kirim request DELETE untuk menghapus produk
                $.ajax({
                    url: `/sales/${productToDelete}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        $(`.product-row[data-sale-id="${productToDelete}"]`).remove();
                        $('#deleteModal').modal('hide');
                        calculateGrandTotal();
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus produk');
                    }
                });
            }
        });

        // Hitung total saat halaman dimuat
        calculateGrandTotal();
    });
</script>
@endpush
