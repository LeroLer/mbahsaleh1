@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah User Baru</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-8 col-lg-8 mx-auto">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form User</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <label for="role" class="font-weight-bold">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Permissions Section -->
                    <div class="form-group" id="permissionsSection" style="display: none;">
                        <label class="font-weight-bold">Hak Akses</label>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Pilih hak akses yang akan diberikan kepada user ini.
                        </div>

                        <!-- Dashboard Permissions -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Dashboard</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="view_dashboard" id="view_dashboard" checked>
                                    <label class="form-check-label" for="view_dashboard">
                                        Lihat Dashboard
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Permissions -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Penjualan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="view_sales" id="view_sales" checked>
                                            <label class="form-check-label" for="view_sales">
                                                Lihat Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="create_sales" id="create_sales" checked>
                                            <label class="form-check-label" for="create_sales">
                                                Tambah Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_sales" id="edit_sales">
                                            <label class="form-check-label" for="edit_sales">
                                                Edit Penjualan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_sales" id="delete_sales">
                                            <label class="form-check-label" for="delete_sales">
                                                Hapus Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="print_struk" id="print_struk" checked>
                                            <label class="form-check-label" for="print_struk">
                                                Cetak Struk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="export_sales" id="export_sales">
                                            <label class="form-check-label" for="export_sales">
                                                Export Laporan Penjualan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Permissions -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Produk</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="view_products" id="view_products" checked>
                                            <label class="form-check-label" for="view_products">
                                                Lihat Produk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="create_products" id="create_products">
                                            <label class="form-check-label" for="create_products">
                                                Tambah Produk
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_products" id="edit_products">
                                            <label class="form-check-label" for="edit_products">
                                                Edit Produk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_products" id="delete_products">
                                            <label class="form-check-label" for="delete_products">
                                                Hapus Produk
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Users Permissions -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Manajemen User</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="manage_users" id="manage_users">
                                    <label class="form-check-label" for="manage_users">
                                        Kelola User
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
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
        $('#role').change(function() {
            const role = $(this).val();
            const permissionsSection = $('#permissionsSection');

            if (role === 'admin') {
                permissionsSection.hide();
                // Uncheck all permissions for admin (they have all permissions by default)
                $('input[name="permissions[]"]').prop('checked', false);
            } else if (role === 'kasir') {
                permissionsSection.show();
                // Set default permissions for kasir
                $('input[name="permissions[]"]').prop('checked', false);
                $('#view_dashboard, #view_sales, #create_sales, #print_struk, #view_products').prop('checked', true);
            } else {
                permissionsSection.hide();
                $('input[name="permissions[]"]').prop('checked', false);
            }
        });

        // Trigger change event on page load
        $('#role').trigger('change');
    });
</script>
@endpush
