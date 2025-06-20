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
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="product_id" class="font-weight-bold">Produk</label>
                        <select class="form-control @error('product_id') is-invalid @enderror"
                                id="product_id" name="product_id" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" step="0.01" min="0.01" class="form-control @error('quantity') is-invalid @enderror"
                               id="quantity" name="quantity" value="{{ old('quantity', $sale->quantity) }}" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="total_price" class="font-weight-bold">Total Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="total_price" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sale_date" class="font-weight-bold">Tanggal Penjualan</label>
                        <input type="datetime-local" class="form-control @error('sale_date') is-invalid @enderror"
                               id="sale_date" name="sale_date"
                               value="{{ old('sale_date', $sale->sale_date->format('Y-m-d\TH:i')) }}" required>
                        @error('sale_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customer_name" class="font-weight-bold">Nama Pelanggan</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}">
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function calculateTotal() {
            var price = $('#product_id option:selected').data('price') || 0;
            var quantity = $('#quantity').val() || 0;
            var total = price * quantity;
            $('#total_price').val(total.toLocaleString('id-ID'));
        }

        $('#product_id, #quantity').on('change keyup', calculateTotal);

        // Hitung total saat halaman dimuat
        calculateTotal();
    });
</script>
@endpush
