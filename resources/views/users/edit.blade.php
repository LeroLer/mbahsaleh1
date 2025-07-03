@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-8 col-lg-8 mx-auto">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit User</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="change_password" name="change_password">
                            <label class="form-check-label" for="change_password">
                                Ubah Password
                            </label>
                        </div>
                        <div id="password_fields" style="display: none;">
                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role" class="font-weight-bold">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
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
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="view_dashboard" id="view_dashboard"
                                           {{ in_array('view_dashboard', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="view_sales" id="view_sales"
                                                   {{ in_array('view_sales', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="view_sales">
                                                Lihat Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="create_sales" id="create_sales"
                                                   {{ in_array('create_sales', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="create_sales">
                                                Tambah Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_sales" id="edit_sales"
                                                   {{ in_array('edit_sales', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="edit_sales">
                                                Edit Penjualan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_sales" id="delete_sales"
                                                   {{ in_array('delete_sales', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="delete_sales">
                                                Hapus Penjualan
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="print_struk" id="print_struk"
                                                   {{ in_array('print_struk', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="print_struk">
                                                Cetak Struk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="export_sales" id="export_sales"
                                                   {{ in_array('export_sales', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="view_products" id="view_products"
                                                   {{ in_array('view_products', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="view_products">
                                                Lihat Produk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="create_products" id="create_products"
                                                   {{ in_array('create_products', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="create_products">
                                                Tambah Produk
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="edit_products" id="edit_products"
                                                   {{ in_array('edit_products', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="edit_products">
                                                Edit Produk
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="delete_products" id="delete_products"
                                                   {{ in_array('delete_products', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
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
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="manage_users" id="manage_users"
                                           {{ in_array('manage_users', old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
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
                            <i class="fas fa-save"></i> Update
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
        // Role change handler
        $('#role').change(function() {
            const role = $(this).val();
            const permissionsSection = $('#permissionsSection');

            if (role === 'admin') {
                permissionsSection.hide();
                // Uncheck all permissions for admin (they have all permissions by default)
                $('input[name="permissions[]"]').prop('checked', false);
            } else if (role === 'kasir') {
                permissionsSection.show();
            } else {
                permissionsSection.hide();
                $('input[name="permissions[]"]').prop('checked', false);
            }
        });

        // Password change handler
        $('#change_password').change(function() {
            const passwordFields = $('#password_fields');
            const passwordInput = $('#password');
            const passwordConfirmationInput = $('#password_confirmation');

            if ($(this).is(':checked')) {
                passwordFields.show();
                passwordInput.prop('required', true);
                passwordConfirmationInput.prop('required', true);
            } else {
                passwordFields.hide();
                passwordInput.prop('required', false);
                passwordConfirmationInput.prop('required', false);
                // Clear password fields when unchecked
                passwordInput.val('');
                passwordConfirmationInput.val('');
            }
        });

        // Trigger change events on page load
        $('#role').trigger('change');
        $('#change_password').trigger('change');
    });
</script>
@endpush
