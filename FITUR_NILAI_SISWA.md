# Fitur Nilai Siswa untuk Guru

## Overview
Fitur ini memungkinkan guru untuk melihat, memantau, dan menganalisis nilai siswa dari kuis yang telah dibuat.

## ✅ Fitur yang Ditambahkan

### 1. Menu Sidebar Baru
- **Lokasi**: Sidebar Guru
- **Icon**: `ti-report-analytics`
- **Label**: "Nilai Siswa"
- **Route**: `/guru/nilai`

### 2. Halaman Utama Nilai (`/guru/nilai`)

#### Tab 1: Per Siswa
Menampilkan daftar semua siswa dengan informasi:
- Nama Siswa
- NIS
- Kelas
- Jumlah Percobaan Kuis
- Rata-rata Nilai
- Tombol Detail untuk melihat riwayat lengkap

**Fitur**:
- ✅ DataTables (search, sort, pagination)
- ✅ Badge warna untuk nilai (hijau ≥70, merah <70)
- ✅ Responsive design

#### Tab 2: Per Kuis
Menampilkan daftar semua kuis dengan informasi:
- Judul Kuis
- Tingkat Kesulitan
- Jumlah Percobaan
- Rata-rata Nilai Kelas
- Tombol Detail untuk analisis per kuis

**Fitur**:
- ✅ DataTables (search, sort, pagination)
- ✅ Badge warna untuk tingkat kesulitan
- ✅ Statistik nilai kelas

### 3. Detail Nilai Per Siswa (`/guru/nilai/siswa/{id}`)

**Informasi Siswa**:
- Nama, NIS, Kelas, Email

**Statistik**:
- Total Percobaan
- Rata-rata Nilai
- Nilai Tertinggi
- Jumlah Lulus

**Tabel Riwayat Kuis**:
- Nama Kuis
- Tanggal Pengerjaan
- Nilai
- Jumlah Benar/Salah
- Status Lulus/Tidak Lulus
- Tombol Detail Jawaban

**Fitur**:
- ✅ Cards statistik dengan warna berbeda
- ✅ DataTables untuk riwayat
- ✅ Sort by tanggal (terbaru dulu)

### 4. Detail Nilai Per Kuis (`/guru/nilai/kuis/{id}`)

**Informasi Kuis**:
- Judul, Tingkat Kesulitan, Durasi, Nilai Minimal
- Materi Terkait (jika ada)

**Statistik Kelas**:
- Total Siswa yang Mengerjakan
- Rata-rata Nilai Kelas
- Nilai Tertinggi
- Tingkat Kelulusan (%)

**Tabel Nilai Per Siswa**:
- Nama Siswa, NIS, Kelas
- Jumlah Percobaan
- Rata-rata Nilai
- Nilai Tertinggi
- Jumlah Lulus
- Tombol Detail Siswa

**Fitur**:
- ✅ Analisis performa kelas
- ✅ Identifikasi siswa yang perlu bantuan
- ✅ DataTables dengan sort by rata-rata

### 5. Detail Percobaan Kuis (`/guru/nilai/percobaan/{id}`)

**Header**:
- Nama Kuis
- Nama Siswa & NIS
- Tanggal Pengerjaan

**Ringkasan Nilai**:
- Nilai Total (dengan warna)
- Jumlah Benar
- Jumlah Salah
- Status Lulus/Tidak Lulus

**Detail Jawaban Per Soal**:
- Pertanyaan
- Gambar/Audio (jika ada)
- Pilihan Jawaban dengan indikator:
  - ✅ Jawaban Benar (hijau)
  - ❌ Jawaban Salah yang dipilih siswa (merah)
  - ← Jawaban yang dipilih siswa
- Poin soal
- Status benar/salah

**Fitur**:
- ✅ Review lengkap setiap jawaban
- ✅ Visual indicator yang jelas
- ✅ Mendukung semua jenis soal (pilihan ganda, benar/salah, isian)

## 📁 File yang Ditambahkan

### Controller
```
app/Http/Controllers/Guru/NilaiController.php
```

**Methods**:
- `index()` - Halaman utama (per siswa & per kuis)
- `show($siswaId)` - Detail nilai per siswa
- `perKuis($kuisId)` - Detail nilai per kuis
- `detailPercobaan($percobaanId)` - Detail jawaban percobaan

### Routes
```php
// Nilai Siswa
Route::get('/nilai', [GuruNilai::class, 'index'])->name('nilai.index');
Route::get('/nilai/siswa/{siswaId}', [GuruNilai::class, 'show'])->name('nilai.siswa');
Route::get('/nilai/kuis/{kuisId}', [GuruNilai::class, 'perKuis'])->name('nilai.kuis');
Route::get('/nilai/percobaan/{percobaanId}', [GuruNilai::class, 'detailPercobaan'])->name('nilai.percobaan');
```

### Views
```
resources/views/guru/nilai/
├── index.blade.php       # Halaman utama (tab per siswa & per kuis)
├── show.blade.php        # Detail nilai per siswa
├── per-kuis.blade.php    # Detail nilai per kuis
└── detail.blade.php      # Detail percobaan (jawaban lengkap)
```

### Sidebar
```
resources/views/partials/sidebar.blade.php
```
Ditambahkan menu "Nilai Siswa" di section Guru.

## 🎯 Use Cases

### 1. Monitoring Performa Siswa
Guru dapat:
- Melihat siswa mana yang perlu bantuan tambahan
- Mengidentifikasi siswa dengan nilai rendah
- Memantau progress siswa dari waktu ke waktu

### 2. Analisis Kuis
Guru dapat:
- Melihat tingkat kesulitan kuis (dari rata-rata nilai)
- Mengidentifikasi soal yang sulit (dari detail jawaban)
- Mengevaluasi efektivitas kuis

### 3. Evaluasi Pembelajaran
Guru dapat:
- Melihat materi mana yang perlu dijelaskan ulang
- Mengidentifikasi pola kesalahan siswa
- Menyesuaikan strategi pembelajaran

### 4. Laporan Nilai
Guru dapat:
- Export data nilai (dengan DataTables export feature)
- Print laporan nilai
- Dokumentasi progress siswa

## 📊 Statistik yang Tersedia

### Per Siswa
- Total percobaan kuis
- Rata-rata nilai keseluruhan
- Nilai tertinggi yang pernah dicapai
- Nilai terendah
- Jumlah kuis yang lulus
- Tingkat kelulusan (%)

### Per Kuis
- Total siswa yang mengerjakan
- Rata-rata nilai kelas
- Nilai tertinggi di kelas
- Nilai terendah di kelas
- Tingkat kelulusan kelas (%)
- Distribusi nilai

### Per Percobaan
- Nilai total
- Jumlah jawaban benar
- Jumlah jawaban salah
- Poin yang didapat
- Status lulus/tidak lulus
- Detail setiap jawaban

## 🎨 UI/UX Features

### Color Coding
- **Hijau**: Nilai ≥70 (Lulus)
- **Merah**: Nilai <70 (Tidak Lulus)
- **Biru**: Informasi netral
- **Kuning**: Warning/perhatian

### Badges
- Tingkat kesulitan kuis
- Status lulus/tidak lulus
- Nilai dengan warna
- Jenis soal

### Cards
- Statistik dengan background warna
- Informasi siswa/kuis
- Ringkasan nilai

### DataTables
- Search global
- Sort per kolom
- Pagination
- Responsive
- Bahasa Indonesia

## 🔒 Security

### Authorization
- Guru hanya bisa melihat nilai dari kuis yang dibuatnya sendiri
- Middleware `role:guru` melindungi semua route
- Validasi ownership di setiap method controller

### Data Privacy
- Guru tidak bisa melihat nilai kuis guru lain
- Siswa tidak bisa mengakses halaman nilai guru

## 📱 Responsive Design

Semua halaman responsive dan mobile-friendly:
- ✅ Desktop (1920px+)
- ✅ Laptop (1366px)
- ✅ Tablet (768px)
- ✅ Mobile (375px)

DataTables otomatis menyembunyikan kolom di layar kecil dengan fitur expand.

## 🚀 Future Enhancements

### Possible Additions:
1. **Export to Excel/PDF**
   - Export nilai per siswa
   - Export nilai per kuis
   - Export laporan lengkap

2. **Grafik & Chart**
   - Line chart progress siswa
   - Bar chart perbandingan nilai
   - Pie chart distribusi nilai

3. **Filter & Advanced Search**
   - Filter by kelas
   - Filter by tanggal
   - Filter by status lulus

4. **Notifikasi**
   - Alert untuk nilai rendah
   - Reminder untuk siswa yang belum mengerjakan

5. **Komentar Guru**
   - Guru bisa memberikan feedback
   - Catatan untuk siswa

6. **Perbandingan**
   - Compare nilai antar siswa
   - Compare performa antar kuis

## 📖 Cara Penggunaan

### Melihat Nilai Semua Siswa
1. Login sebagai Guru
2. Klik menu "Nilai Siswa" di sidebar
3. Tab "Per Siswa" menampilkan daftar siswa
4. Gunakan search untuk mencari siswa tertentu
5. Klik "Detail" untuk melihat riwayat lengkap

### Melihat Nilai Per Kuis
1. Di halaman Nilai Siswa
2. Klik tab "Per Kuis"
3. Pilih kuis yang ingin dilihat
4. Klik "Detail" untuk analisis lengkap

### Melihat Detail Jawaban
1. Dari detail siswa atau detail kuis
2. Klik "Detail" pada percobaan tertentu
3. Review setiap jawaban siswa
4. Lihat mana yang benar/salah

## 🐛 Troubleshooting

### Nilai tidak muncul?
- Pastikan siswa sudah menyelesaikan kuis
- Cek status percobaan (harus "selesai")
- Pastikan kuis dibuat oleh guru yang login

### DataTables tidak berfungsi?
- Clear browser cache
- Pastikan jQuery loaded
- Check console untuk error

### Statistik tidak akurat?
- Refresh halaman
- Pastikan data percobaan lengkap
- Check database untuk data corrupt

---

**Status**: ✅ IMPLEMENTED & READY TO USE
**Version**: 1.0.0
**Date**: 2025-11-15
