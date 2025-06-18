<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data penjualan bulan ini
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        $monthlySales = Sale::select(
            DB::raw('DATE(sale_date) as date'),
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(total_price) as total_revenue')
        )
        ->whereMonth('sale_date', $currentMonth)
        ->whereYear('sale_date', $currentYear)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Data penjualan per produk
        $topProducts = Sale::select(
            'products.name',
            DB::raw('SUM(sales.quantity) as total_quantity'),
            DB::raw('SUM(sales.total_price) as total_revenue')
        )
        ->join('products', 'products.id', '=', 'sales.product_id')
        ->whereMonth('sale_date', $currentMonth)
        ->whereYear('sale_date', $currentYear)
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_revenue')
        ->limit(5)
        ->get();

        // Statistik bulanan
        $monthlyStats = [
            'total_sales' => Sale::whereMonth('sale_date', $currentMonth)
                                ->whereYear('sale_date', $currentYear)
                                ->count(),
            'total_revenue' => Sale::whereMonth('sale_date', $currentMonth)
                                ->whereYear('sale_date', $currentYear)
                                ->sum('total_price'),
            'average_transaction' => Sale::whereMonth('sale_date', $currentMonth)
                                        ->whereYear('sale_date', $currentYear)
                                        ->avg('total_price'),
            'total_products' => Product::count()
        ];

        // Data untuk grafik
        $chartData = [
            'labels' => $monthlySales->pluck('date'),
            'transactions' => $monthlySales->pluck('total_transactions'),
            'revenue' => $monthlySales->pluck('total_revenue')
        ];

        return view('dashboard', compact(
            'monthlyStats',
            'topProducts',
            'chartData'
        ));
    }
}
