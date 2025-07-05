# Panduan Export Laporan Penjualan

## Fitur Export yang Tersedia

Aplikasi MBah Saleh menyediakan fitur export laporan penjualan yang informatif dengan dua format:

### 1. Export PDF
- **Template yang Lengkap**: Header perusahaan, footer, dan informasi detail
- **Ringkasan Laporan**: Total transaksi, kuantitas, pendapatan, dan rata-rata
- **Detail Transaksi**: Tabel lengkap dengan nomor urut, tanggal, produk, kuantitas, harga satuan, total harga, dan customer
- **Ringkasan per Produk**: Analisis performa produk dengan persentase kontribusi
- **Ringkasan per Customer**: Analisis customer dengan total transaksi dan pendapatan
- **Informasi Cetak**: Tanggal cetak, user yang mencetak, dan watermark

### 2. Export Excel
- **Multiple Sheets**: 3 worksheet dalam satu file
  - **Detail Transaksi**: Data lengkap semua transaksi
  - **Ringkasan Produk**: Analisis per produk
  - **Ringkasan Customer**: Analisis per customer
- **Header Perusahaan**: Informasi MBah Saleh di bagian atas
- **Styling Otomatis**: Warna, alignment, dan format yang rapi
- **Summary**: Total transaksi, kuantitas, dan pendapatan

## Sistem ID Konsisten

### Halaman Penjualan
- **ID Konsisten**: Menggunakan ID dari database yang tidak berubah saat filtering
- **Tidak Berurutan**: ID tidak selalu berurutan (1, 2, 3) karena menggunakan ID asli dari database
- **Stabil**: ID tetap sama meskipun data diurutkan atau difilter
- **Detail ID**: Menampilkan informasi jumlah produk dalam transaksi

### Keunggulan Sistem ID Konsisten
- ✅ **Referensi Stabil**: ID tidak berubah saat filtering atau sorting
- ✅ **Tracking Mudah**: Mudah melacak transaksi berdasarkan ID
- ✅ **Konsistensi Data**: ID tetap sama di semua fitur (edit, delete, struk)
- ✅ **Tidak Membingungkan**: User tidak bingung dengan nomor yang berubah-ubah

## Cara Menggunakan

### 1. Akses Halaman Export
```
Menu: Sales → Export Laporan
URL: /sales/export
```

### 2. Filter Data
- **Tanggal Mulai**: Pilih tanggal awal periode laporan
- **Tanggal Akhir**: Pilih tanggal akhir periode laporan
- **Format**: Pilih PDF atau Excel

### 3. Preview Data
- Data akan ditampilkan dalam tabel dengan DataTable
- Summary cards menampilkan total transaksi, kuantitas, dan pendapatan
- Data dapat diurutkan dan dicari

### 4. Export
- Klik tombol "Export Excel" atau "Export PDF"
- File akan otomatis terdownload dengan nama yang sesuai periode

## Informasi yang Ditampilkan

### Header Laporan
```
MBah Saleh
Pemancingan Galatama
Jl. Raya Ikan No. 123, Jakarta
Telp: 0812-3456-7890 | Email: info@mbahsaleh.com
```

### Ringkasan Laporan
- **Total Transaksi**: Jumlah transaksi dalam periode
- **Total Kuantitas**: Total berat ikan terjual (kg)
- **Total Pendapatan**: Total pendapatan dalam rupiah
- **Rata-rata per Transaksi**: Pendapatan rata-rata per transaksi

### Detail Transaksi
| Kolom | Deskripsi |
|-------|-----------|
| Tanggal | Tanggal dan waktu transaksi |
| Produk | Nama produk ikan |
| Kuantitas | Berat ikan dalam kg |
| Harga Satuan | Harga per kg |
| Total Harga | Total harga transaksi |
| Customer | Nama customer (Umum jika kosong) |

### Ringkasan per Produk
- **Produk**: Nama produk ikan
- **Total Kuantitas**: Total berat terjual per produk
- **Total Pendapatan**: Total pendapatan per produk
- **Persentase**: Kontribusi produk terhadap total pendapatan

### Ringkasan per Customer
- **Customer**: Nama customer
- **Total Transaksi**: Jumlah transaksi per customer
- **Total Kuantitas**: Total berat ikan yang dibeli
- **Total Pendapatan**: Total pendapatan dari customer

## Format File

### PDF
- **Nama File**: `laporan-penjualan-YYYY-MM-DD-sampai-YYYY-MM-DD.pdf`
- **Ukuran**: A4 portrait
- **Font**: DejaVu Sans (support karakter Indonesia)
- **Warna**: Biru (#007bff) untuk header, hijau (#28a745) untuk summary

### Excel
- **Nama File**: `laporan-penjualan-YYYY-MM-DD-sampai-YYYY-MM-DD.xlsx`
- **Format**: .xlsx (Excel 2007+)
- **Sheets**: 3 worksheet
- **Styling**: Header biru, data dengan alternating row colors

## Fitur Tambahan

### 1. Sorting dan Searching
- Data dapat diurutkan berdasarkan kolom apapun
- Pencarian global di semua kolom
- Pagination untuk data yang banyak

### 2. Responsive Design
- Tabel responsive untuk mobile
- Summary cards yang adaptif
- Form filter yang user-friendly

### 3. Error Handling
- Validasi tanggal (tanggal akhir tidak boleh sebelum tanggal mulai)
- Pesan error yang informatif
- Fallback untuk data kosong

## Contoh Output

### PDF Preview
```
┌─────────────────────────────────────────────────────────────┐
│                    MBah Saleh                              │
│                Pemancingan Galatama                        │
│                                                             │
│                  LAPORAN PENJUALAN                         │
│            Periode: 01/01/2024 s/d 31/01/2024             │
│                                                             │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │                RINGKASAN LAPORAN                        │ │
│ │  Total Transaksi: 150  │  Total Kuantitas: 1,250.50 kg │ │
│ │  Total Pendapatan: Rp 15,750,000  │  Rata-rata: Rp 105,000 │ │
│ └─────────────────────────────────────────────────────────┘ │
│                                                             │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │                    DETAIL TRANSAKSI                     │ │
│ │ Tanggal │ Produk │ Kuantitas │ Harga │ Total │ Customer │ │
│ │ 01/01   │ Ikan   │ 10.50 kg  │ 12k   │ 126k  │ John     │ │
│ └─────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### Excel Structure
```
Sheet 1: Detail Transaksi
- Header perusahaan (A1:F1)
- Judul laporan (A2:F2)
- Periode (A3:F3)
- Summary (A4:F4)
- Data transaksi (A6:F...)

Sheet 2: Ringkasan Produk
- Tabel ringkasan per produk
- Persentase kontribusi

Sheet 3: Ringkasan Customer
- Tabel ringkasan per customer
- Total transaksi dan pendapatan
```

## Tips Penggunaan

1. **Periode Optimal**: Gunakan periode maksimal 1 bulan untuk performa terbaik
2. **Format Pilihan**: PDF untuk cetak, Excel untuk analisis lanjutan
3. **Data Kosong**: Jika tidak ada data, laporan akan tetap dibuat dengan ringkasan kosong
4. **File Naming**: Nama file otomatis sesuai periode untuk memudahkan organisasi
5. **Backup**: Simpan file laporan sebagai backup data historis
6. **ID Konsisten**: Gunakan ID untuk referensi transaksi yang stabil

## Troubleshooting

### Masalah Umum
1. **File tidak terdownload**: Cek popup blocker browser
2. **Data kosong**: Pastikan periode yang dipilih memiliki data
3. **Error PDF**: Pastikan font DejaVu Sans terinstall
4. **File Excel rusak**: Coba download ulang atau gunakan format PDF
5. **ID berubah**: Pastikan menggunakan sistem ID konsisten, bukan nomor urut

### Support
Untuk masalah teknis, hubungi administrator sistem atau cek log error di `storage/logs/laravel.log`.
