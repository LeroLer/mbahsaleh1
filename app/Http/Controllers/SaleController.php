<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->latest()->paginate(10);
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
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
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
        $sale = Sale::with('product')->findOrFail($id);
        return view('sales.struk', compact('sale'));
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
