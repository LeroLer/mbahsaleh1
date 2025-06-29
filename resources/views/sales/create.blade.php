@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Penjualan Baru</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Penjualan</h6>
                <button type="button" class="btn btn-success btn-sm" onclick="addProductRow()">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('sales.preview') }}" method="POST" id="salesForm">
                    @csrf

                    <!-- Dynamic Product Rows -->
                    <div id="productRows">
                        <div class="product-row border rounded p-3 mb-3" data-row="0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Produk</label>
                                        <select class="form-control product-select" name="products[0][product_id]" required>
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
                                        <input type="number" step="0.01" min="0.01" class="form-control product-quantity"
                                               name="products[0][quantity]" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Total Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control product-total" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-block" onclick="removeProductRow(this)" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Total Keseluruhan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" id="grandTotal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="sale_date" class="font-weight-bold">Tanggal Penjualan</label>
                        <input type="datetime-local" class="form-control @error('sale_date') is-invalid @enderror"
                               id="sale_date" name="sale_date"
                               value="{{ old('sale_date', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('sale_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customer_name" class="font-weight-bold">Nama Pelanggan</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let rowCounter = 1;

    $(document).ready(function() {
        calculateGrandTotal();

        // Event delegation for dynamic elements
        $(document).on('change keyup', '.product-select, .product-quantity', function() {
            calculateRowTotal($(this).closest('.product-row'));
            calculateGrandTotal();
        });
    });

    function addProductRow() {
        const newRow = `
            <div class="product-row border rounded p-3 mb-3" data-row="${rowCounter}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Produk</label>
                            <select class="form-control product-select" name="products[${rowCounter}][product_id]" required>
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
                            <input type="number" step="0.01" min="0.01" class="form-control product-quantity"
                                   name="products[${rowCounter}][quantity]" value="" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control product-total" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block" onclick="removeProductRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#productRows').append(newRow);
        rowCounter++;

        // Show remove button for first row if there are multiple rows
        if ($('.product-row').length > 1) {
            $('.product-row:first .btn-danger').show();
        }
    }

    function removeProductRow(button) {
        $(button).closest('.product-row').remove();
        calculateGrandTotal();

        // Hide remove button for first row if only one row remains
        if ($('.product-row').length === 1) {
            $('.product-row:first .btn-danger').hide();
        }
    }

    function calculateRowTotal(row) {
        const price = row.find('.product-select option:selected').data('price') || 0;
        const quantity = row.find('.product-quantity').val() || 0;
        const total = price * quantity;
        row.find('.product-total').val(total.toLocaleString('id-ID'));
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        $('.product-total').each(function() {
            const value = $(this).val().replace(/[^\d]/g, '') || 0;
            grandTotal += parseInt(value);
        });
        $('#grandTotal').val(grandTotal.toLocaleString('id-ID'));
    }

    function submitDirect() {
        // Ubah action form ke store langsung
        $('#salesForm').attr('action', '{{ route("sales.store") }}');
        $('#salesForm').submit();
    }
</script>
@endpush
