<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pemancingan.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'permissions' => [], // Admin tidak perlu permissions karena otomatis punya semua akses
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@pemancingan.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'permissions' => [
                'view_dashboard',
                'view_sales',
                'create_sales',
                'print_struk',
                'view_products'
            ],
        ]);
    }
}
