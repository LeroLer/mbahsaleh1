<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        // Ambil semua penjualan dengan relasi product, diurutkan berdasarkan tanggal terbaru
        $allSales = Sale::with('product')
            ->orderBy('sale_date', 'desc')
            ->orderBy('customer_name')
            ->get();

        // Kelompokkan penjualan berdasarkan tanggal dan customer
        $groupedSales = $allSales->groupBy(function($sale) {
            return $sale->sale_date->format('Y-m-d H:i') . '|' . $sale->customer_name;
        });

        // Buat array untuk ditampilkan di view
        $sales = [];
        foreach ($groupedSales as $key => $salesGroup) {
            $firstSale = $salesGroup->first();
            $totalAmount = $salesGroup->sum('total_price');
            $totalQuantity = $salesGroup->sum('quantity');

            $sales[] = [
                'id' => $firstSale->id, // ID penjualan pertama sebagai representasi
                'sale_date' => $firstSale->sale_date,
                'customer_name' => $firstSale->customer_name,
                'products' => $salesGroup->map(function($sale) {
                    return [
                        'name' => $sale->product->name,
                        'quantity' => $sale->quantity,
                        'price_per_kg' => $sale->product->price,
                        'total_price' => $sale->total_price,
                    ];
                }),
                'total_quantity' => $totalQuantity,
                'total_amount' => $totalAmount,
                'item_count' => $salesGroup->count(),
                'all_sale_ids' => $salesGroup->pluck('id')->toArray(), // Semua ID untuk aksi
            ];
        }

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
        ]);

        $products = [];
        $grandTotal = 0;

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['product_id']);
            $total = $product->price * $productData['quantity'];
            $grandTotal += $total;

            $products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $productData['quantity'],
                'total' => $total,
            ];
        }

        return view('sales.preview', [
            'products' => $products,
            'grandTotal' => $grandTotal,
            'sale_date' => $request->sale_date,
            'customer_name' => $request->customer_name,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->products as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                $total_price = $product->price * $productData['quantity'];

                Sale::create([
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'total_price' => $total_price,
                    'sale_date' => $request->sale_date,
                    'customer_name' => $request->customer_name,
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Sale $sale)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('sales.index')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat mengedit penjualan.');
        }

        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('sales.index')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat mengupdate penjualan.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;

            $sale->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $total_price,
                'sale_date' => $request->sale_date,
                'customer_name' => $request->customer_name,
            ]);

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Sale $sale)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('sales.index')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat menghapus penjualan.');
        }

        try {
            $sale->delete();
            return redirect()->route('sales.index')
                ->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function printStruk($id)
    {
        // Ambil sale pertama untuk mendapatkan informasi transaksi
        $firstSale = Sale::with('product')->findOrFail($id);

        // Ambil semua sale dengan tanggal dan customer yang sama
        $allSales = Sale::with('product')
            ->where('sale_date', $firstSale->sale_date)
            ->where('customer_name', $firstSale->customer_name)
            ->get();

        // Hitung total
        $totalAmount = $allSales->sum('total_price');
        $totalQuantity = $allSales->sum('quantity');

        return view('sales.struk', [
            'sales' => $allSales,
            'sale_date' => $firstSale->sale_date,
            'customer_name' => $firstSale->customer_name,
            'total_amount' => $totalAmount,
            'total_quantity' => $totalQuantity,
            'item_count' => $allSales->count()
        ]);
    }

    public function exportPage()
    {
        // Tampilkan halaman/form export laporan penjualan
        return view('sales.export');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'format' => 'required|in:excel,pdf',
        ]);

        $sales = \App\Models\Sale::with('product')
            ->whereDate('sale_date', '>=', $request->start_date)
            ->whereDate('sale_date', '<=', $request->end_date)
            ->get();

        $data = $sales->map(function($sale) {
            return [
                'Tanggal' => $sale->sale_date,
                'Produk' => $sale->product ? $sale->product->name : '-',
                'Jumlah' => $sale->quantity,
                'Total Harga' => $sale->total_price,
                'Customer' => $sale->customer_name,
            ];
        });

        if ($request->format === 'excel') {
            $export = new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
                protected $data;
                public function __construct($data) { $this->data = $data; }
                public function collection() { return collect($this->data); }
                public function headings(): array { return ['Tanggal', 'Produk', 'Jumlah', 'Total Harga', 'Customer']; }
            };
            return Excel::download($export, 'laporan-penjualan.xlsx');
        } else {
            $pdf = Pdf::loadView('sales.export_pdf', ['data' => $data, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
            return $pdf->download('laporan-penjualan.pdf');
        }
    }

    public function show($id)
    {
        // Tidak ada detail penjualan, redirect ke index atau tampilkan pesan
        return redirect()->route('sales.index');
    }
}
