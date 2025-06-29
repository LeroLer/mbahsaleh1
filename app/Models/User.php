<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is kasir
     */
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true; // Admin has all permissions
        }

        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return !empty(array_intersect($permissions, $this->permissions ?? []));
    }

    /**
     * Get available permissions
     */
    public static function getAvailablePermissions(): array
    {
        return [
            'view_dashboard' => 'Lihat Dashboard',
            'view_sales' => 'Lihat Penjualan',
            'create_sales' => 'Tambah Penjualan',
            'edit_sales' => 'Edit Penjualan',
            'delete_sales' => 'Hapus Penjualan',
            'print_struk' => 'Cetak Struk',
            'export_sales' => 'Export Laporan Penjualan',
            'view_products' => 'Lihat Produk',
            'create_products' => 'Tambah Produk',
            'edit_products' => 'Edit Produk',
            'delete_products' => 'Hapus Produk',
            'manage_users' => 'Kelola User',
        ];
    }
}
