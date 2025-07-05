# Panduan Struk MBah Saleh

## Overview
Sistem MBah Saleh sekarang mendukung berbagai ukuran kertas struk untuk memenuhi kebutuhan yang berbeda. Setiap ukuran memiliki karakteristik dan kegunaan yang spesifik.

## Ukuran Struk yang Tersedia

### 1. Struk A6 (Default)
- **Ukuran**: 105mm × 148mm
- **Kegunaan**: Struk standar untuk printer biasa
- **Keunggulan**:
  - Hemat kertas
  - Mudah dibawa
  - Cocok untuk printer inkjet/laser biasa
  - Ukuran yang seimbang antara informasi dan efisiensi

### 2. Struk Thermal Coreless (40mm)
- **Ukuran**: 40mm lebar (panjang fleksibel)
- **Kegunaan**: Untuk printer thermal/kasir
- **Keunggulan**:
  - Cetak cepat
  - Hemat biaya operasional
  - Ukuran coreless (tanpa inti)
  - Tidak memerlukan tinta
  - Panjang menyesuaikan konten
  - Lebih compact dan efisien

### 3. Struk A4 (Formal)
- **Ukuran**: 210mm × 297mm
- **Kegunaan**: Struk formal untuk arsip
- **Keunggulan**:
  - Informasi lengkap dan detail
  - Tampilan profesional
  - Cocok untuk arsip perusahaan
  - Layout yang lebih luas

## Cara Menggunakan

### Metode 1: Dropdown Menu (Cepat)
1. Buka halaman **Daftar Penjualan**
2. Klik tombol **Cetak Struk** (ikon printer) pada baris penjualan
3. Pilih ukuran struk dari dropdown menu:
   - **Pilih Ukuran Struk**: Buka halaman pemilihan
   - **Struk A6 (Default)**: Cetak langsung ukuran A6
   - **Struk Thermal (80mm)**: Cetak langsung ukuran thermal
   - **Struk A4 (Formal)**: Cetak langsung ukuran A4

### Metode 2: Halaman Pemilihan (Detail)
1. Buka halaman **Daftar Penjualan**
2. Klik tombol **Cetak Struk** → **Pilih Ukuran Struk**
3. Halaman akan menampilkan:
   - Informasi transaksi
   - 3 opsi ukuran struk dengan preview
   - Penjelasan keunggulan masing-masing ukuran
4. Pilih ukuran yang diinginkan dan klik tombol cetak

## URL Akses Langsung

Anda juga dapat mengakses struk langsung melalui URL:

```
/sales/{id}/struk              # Struk A6 (Default)
/sales/{id}/struk/thermal      # Struk Thermal
/sales/{id}/struk/a4           # Struk A4
/sales/{id}/struk/select       # Halaman pemilihan
```

## Tips Penggunaan

### Untuk Printer Biasa
- Gunakan **Struk A6** untuk hasil terbaik
- Pastikan printer mendukung ukuran A6
- Gunakan kertas HVS 80gsm atau lebih tebal

### Untuk Printer Thermal
- Gunakan **Struk Thermal Coreless (40mm)**
- Pastikan roll kertas thermal coreless 40mm tersedia
- Periksa pengaturan printer thermal

### Untuk Arsip Formal
- Gunakan **Struk A4**
- Cetak di kertas HVS 80gsm atau kertas khusus
- Cocok untuk laporan keuangan atau arsip perusahaan

## Pengaturan Printer

### Struk A6
```
Paper Size: A6
Orientation: Portrait
Margins: Default
```

### Struk Thermal Coreless
```
Paper Width: 40mm
Orientation: Portrait
Margins: Minimal
```

### Struk A4
```
Paper Size: A4
Orientation: Portrait
Margins: Default
```

## Troubleshooting

### Struk Tidak Muat di Kertas
- Periksa pengaturan ukuran kertas di printer
- Pastikan margin printer tidak terlalu besar
- Coba cetak preview terlebih dahulu

### Font Terlalu Kecil/Besar
- Setiap ukuran struk sudah dioptimalkan untuk font size yang sesuai
- Jika masih bermasalah, gunakan browser zoom untuk menyesuaikan

### Printer Thermal Tidak Terdeteksi
- Pastikan driver printer thermal terinstall
- Periksa koneksi USB/Network
- Restart printer thermal

## Fitur Tambahan

### Preview Struk
- Setiap halaman pemilihan menampilkan preview ukuran
- Preview membantu visualisasi hasil cetak

### Informasi Transaksi
- Tanggal dan waktu transaksi
- Nama customer
- Jumlah item dan total pembayaran
- Nomor struk otomatis

### Responsive Design
- Struk dapat dicetak dari berbagai perangkat
- Mendukung mobile printing
- Optimized untuk berbagai browser

## Update Terbaru

### v2.0 - Multi Size Support
- ✅ 3 ukuran struk (A6, Thermal, A4)
- ✅ Halaman pemilihan ukuran
- ✅ Preview visual
- ✅ Dropdown menu cepat
- ✅ URL akses langsung
- ✅ Optimized CSS untuk setiap ukuran

### v1.0 - Basic Struk
- ✅ Struk A6 standar
- ✅ Informasi transaksi lengkap
- ✅ Print-friendly design

## Support

Jika mengalami masalah dengan fitur struk, silakan:
1. Periksa pengaturan printer
2. Pastikan browser mendukung printing
3. Coba refresh halaman
4. Hubungi administrator sistem 
