<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;

            $sale = Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $total_price,
                'sale_date' => $request->sale_date
            ]);

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
            'sale_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $total_price = $product->price * $request->quantity;

            $sale->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $total_price,
                'sale_date' => $request->sale_date
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
}
