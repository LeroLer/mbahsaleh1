<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        // Data untuk grafik bulanan
        $chartData = [
            'labels' => $monthlySales->pluck('date'),
            'transactions' => $monthlySales->pluck('total_transactions'),
            'revenue' => $monthlySales->pluck('total_revenue')
        ];

        // Data penjualan hari ini
        $today = Carbon::now()->toDateString();
        $dailyStats = [
            'total_sales' => Sale::whereDate('sale_date', $today)->count(),
            'total_revenue' => Sale::whereDate('sale_date', $today)->sum('total_price'),
        ];

        // Data grafik harian (1 bulan berjalan)
        $daysInMonth = Carbon::now()->daysInMonth;
        $dates = collect(range(1, $daysInMonth))->map(function ($day) use ($currentMonth, $currentYear) {
            return Carbon::createFromDate($currentYear, $currentMonth, $day)->format('Y-m-d');
        });
        $dailyChartData = [
            'labels' => $dates->map(fn($date) => Carbon::parse($date)->format('d'))->toArray(),
            'transactions' => $dates->map(fn($date) => Sale::whereDate('sale_date', $date)->count())->toArray(),
            'revenue' => $dates->map(fn($date) => Sale::whereDate('sale_date', $date)->sum('total_price'))->toArray(),
        ];

        return view('dashboard', compact(
            'monthlyStats',
            'chartData',
            'dailyStats',
            'dailyChartData'
        ));
    }
}
