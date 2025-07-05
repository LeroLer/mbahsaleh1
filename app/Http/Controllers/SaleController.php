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

        // Ambil semua sale dengan tanggal dan customer yang sama
        $allSales = Sale::with('product')
            ->where('sale_date', $sale->sale_date)
            ->where('customer_name', $sale->customer_name)
            ->get();

        $products = Product::all();
        return view('sales.edit', compact('sale', 'allSales', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('sales.index')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat mengupdate penjualan.');
        }

        $request->validate([
            'sales' => 'required|array|min:1',
            'sales.*.id' => 'required|exists:sales,id',
            'sales.*.product_id' => 'required|exists:products,id',
            'sales.*.quantity' => 'required|numeric|min:0.01',
            'sale_date' => 'required|date',
            'customer_name' => 'nullable|string|max:255',
            'new_products' => 'nullable|array',
            'new_products.*.product_id' => 'nullable|exists:products,id',
            'new_products.*.quantity' => 'nullable|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            // Update existing sales
            foreach ($request->sales as $saleData) {
                $existingSale = Sale::findOrFail($saleData['id']);
                $product = Product::findOrFail($saleData['product_id']);
                $total_price = $product->price * $saleData['quantity'];

                $existingSale->update([
                    'product_id' => $saleData['product_id'],
                    'quantity' => $saleData['quantity'],
                    'total_price' => $total_price,
                    'sale_date' => $request->sale_date,
                    'customer_name' => $request->customer_name,
                ]);
            }

            // Add new products if any
            if ($request->has('new_products')) {
                foreach ($request->new_products as $newProduct) {
                    if (!empty($newProduct['product_id']) && !empty($newProduct['quantity'])) {
                        $product = Product::findOrFail($newProduct['product_id']);
                        $total_price = $product->price * $newProduct['quantity'];

                        Sale::create([
                            'product_id' => $newProduct['product_id'],
                            'quantity' => $newProduct['quantity'],
                            'total_price' => $total_price,
                            'sale_date' => $request->sale_date,
                            'customer_name' => $request->customer_name,
                        ]);
                    }
                }
            }

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

    public function printStruk($id, $size = 'a6')
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

        $data = [
            'sales' => $allSales,
            'sale_date' => $firstSale->sale_date,
            'customer_name' => $firstSale->customer_name,
            'total_amount' => $totalAmount,
            'total_quantity' => $totalQuantity,
            'item_count' => $allSales->count()
        ];

        // Pilih template berdasarkan ukuran
        switch ($size) {
            case 'thermal':
                return view('sales.struk_thermal', $data);
            case 'a4':
                return view('sales.struk_a4', $data);
            case 'a6':
            default:
                return view('sales.struk', $data);
        }
    }

    public function printStrukThermal($id)
    {
        return $this->printStruk($id, 'thermal');
    }

    public function printStrukA4($id)
    {
        return $this->printStruk($id, 'a4');
    }

    public function strukSelector($id)
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

        return view('sales.struk_selector', [
            'sale_id' => $id,
            'sale_date' => $firstSale->sale_date,
            'customer_name' => $firstSale->customer_name,
            'total_amount' => $totalAmount,
            'total_quantity' => $totalQuantity,
            'item_count' => $allSales->count()
        ]);
    }

    public function exportPage(Request $request)
    {
        $sales = collect();
        $start_date = null;
        $end_date = null;
        $total_amount = 0;
        $total_quantity = 0;
        $total_transactions = 0;

        // Jika ada parameter tanggal, ambil data sesuai filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $sales = Sale::with('product')
                ->whereDate('sale_date', '>=', $start_date)
                ->whereDate('sale_date', '<=', $end_date)
                ->orderBy('sale_date', 'desc')
                ->get();

            $total_amount = $sales->sum('total_price');
            $total_quantity = $sales->sum('quantity');
            $total_transactions = $sales->count();
        }

        return view('sales.export', compact('sales', 'start_date', 'end_date', 'total_amount', 'total_quantity', 'total_transactions'));
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
            ->orderBy('sale_date', 'desc')
            ->get();

        $data = $sales->map(function($sale) {
            return [
                'Tanggal' => $sale->sale_date,
                'Produk' => $sale->product ? $sale->product->name : '-',
                'Jumlah' => $sale->quantity,
                'Harga Satuan' => $sale->product ? $sale->product->price : 0,
                'Total Harga' => $sale->total_price,
                'Customer' => $sale->customer_name,
            ];
        });

        if ($request->format === 'excel') {
            $export = new class($data, $request->start_date, $request->end_date) implements
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings,
                \Maatwebsite\Excel\Concerns\WithStyles,
                \Maatwebsite\Excel\Concerns\WithEvents,
                \Maatwebsite\Excel\Concerns\WithTitle,
                \Maatwebsite\Excel\Concerns\WithMultipleSheets {

                protected $data;
                protected $start_date;
                protected $end_date;

                public function __construct($data, $start_date, $end_date) {
                    $this->data = $data;
                    $this->start_date = $start_date;
                    $this->end_date = $end_date;
                }

                public function collection() {
                    return collect($this->data);
                }

                                public function headings(): array {
                    return ['Tanggal', 'Produk', 'Kuantitas (kg)', 'Harga Satuan', 'Total Harga', 'Customer'];
                }

                public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
                {
                    return [
                        // Header styling
                        1 => [
                            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => '007BFF']],
                            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                        ],
                        // Data rows
                        'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
                        'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT]],
                        'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT], 'font' => ['bold' => true]],
                    ];
                }

                public function registerEvents(): array
                {
                    return [
                        \Maatwebsite\Excel\Events\BeforeSheet::class => function(\Maatwebsite\Excel\Events\BeforeSheet $event) {
                            $sheet = $event->sheet;

                                                        // Add company header
                            $sheet->setCellValue('A1', 'MBah Saleh - Pemancingan Galatama');
                            $sheet->mergeCells('A1:F1');
                            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                            // Add report title
                            $sheet->setCellValue('A2', 'LAPORAN PENJUALAN');
                            $sheet->mergeCells('A2:F2');
                            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                            $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                            // Add period
                            $sheet->setCellValue('A3', 'Periode: ' . \Carbon\Carbon::parse($this->start_date)->format('d/m/Y') . ' s/d ' . \Carbon\Carbon::parse($this->end_date)->format('d/m/Y'));
                            $sheet->mergeCells('A3:F3');
                            $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                            // Add summary
                            $sheet->setCellValue('A4', 'Total Transaksi: ' . $this->data->count());
                            $sheet->setCellValue('B4', 'Total Kuantitas: ' . number_format($this->data->sum('Jumlah'), 2) . ' kg');
                            $sheet->setCellValue('C4', 'Total Pendapatan: Rp ' . number_format($this->data->sum('Total Harga'), 0, ',', '.'));
                            $sheet->mergeCells('C4:F4');

                            // Add empty row
                            $sheet->setCellValue('A5', '');

                            // Move data down by 5 rows
                            $sheet->insertNewRowBefore(6, 5);
                        },
                    ];
                }

                public function title(): string
                {
                    return 'Detail Transaksi';
                }

                public function sheets(): array
                {
                    return [
                        'Detail Transaksi' => $this,
                        'Ringkasan Produk' => new class($this->data) implements
                            \Maatwebsite\Excel\Concerns\FromCollection,
                            \Maatwebsite\Excel\Concerns\WithHeadings,
                            \Maatwebsite\Excel\Concerns\WithTitle {

                            protected $data;

                            public function __construct($data) {
                                $this->data = $data;
                            }

                            public function collection() {
                                $productSummary = $this->data->groupBy('Produk')->map(function($group) {
                                    return [
                                        'Produk' => $group->first()['Produk'],
                                        'Total Kuantitas' => $group->sum('Jumlah'),
                                        'Total Pendapatan' => $group->sum('Total Harga'),
                                        'Persentase' => number_format(($group->sum('Total Harga') / $this->data->sum('Total Harga')) * 100, 1) . '%'
                                    ];
                                });
                                return $productSummary->values();
                            }

                            public function headings(): array {
                                return ['Produk', 'Total Kuantitas (kg)', 'Total Pendapatan', 'Persentase'];
                            }

                            public function title(): string
                            {
                                return 'Ringkasan Produk';
                            }
                        },
                        'Ringkasan Customer' => new class($this->data) implements
                            \Maatwebsite\Excel\Concerns\FromCollection,
                            \Maatwebsite\Excel\Concerns\WithHeadings,
                            \Maatwebsite\Excel\Concerns\WithTitle {

                            protected $data;

                            public function __construct($data) {
                                $this->data = $data;
                            }

                            public function collection() {
                                $customerSummary = $this->data->groupBy('Customer')->map(function($group) {
                                    return [
                                        'Customer' => $group->first()['Customer'] ?: 'Umum',
                                        'Total Transaksi' => $group->count(),
                                        'Total Kuantitas' => $group->sum('Jumlah'),
                                        'Total Pendapatan' => $group->sum('Total Harga')
                                    ];
                                });
                                return $customerSummary->values();
                            }

                            public function headings(): array {
                                return ['Customer', 'Total Transaksi', 'Total Kuantitas (kg)', 'Total Pendapatan'];
                            }

                            public function title(): string
                            {
                                return 'Ringkasan Customer';
                            }
                        }
                    ];
                }
            };

            return Excel::download($export, 'laporan-penjualan-' . $request->start_date . '-sampai-' . $request->end_date . '.xlsx');
        } else {
            $pdf = Pdf::loadView('sales.export_pdf', ['data' => $data, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
            return $pdf->download('laporan-penjualan-' . $request->start_date . '-sampai-' . $request->end_date . '.pdf');
        }
    }

    public function show($id)
    {
        // Tidak ada detail penjualan, redirect ke index atau tampilkan pesan
        return redirect()->route('sales.index');
    }
}
