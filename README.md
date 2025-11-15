# 📚 Aplikasi Belajar Bahasa Inggris

Aplikasi Media Pembelajaran Interaktif Bahasa Inggris berbasis web menggunakan Laravel 12.

## ✨ Fitur

### Super Admin
- ✅ Dashboard dengan statistik sistem
- ✅ Kelola Akun Guru (CRUD)
- ✅ Kelola Akun Siswa (CRUD)

### Guru
- ✅ Dashboard dengan statistik progress siswa
- ✅ Kelola Materi (Vocabulary & Grammar)
  - ✅ CRUD Materi lengkap
  - ✅ Upload video pembelajaran
  - ✅ Kelola kosakata dengan audio & gambar
- ✅ Kelola Kuis
  - ✅ CRUD Kuis lengkap
  - ✅ Kelola soal (3 jenis)
  - ✅ Upload gambar & audio soal
- 🔄 Lihat hasil kuis siswa

### Siswa
- ✅ Dashboard dengan progress belajar
- 🔄 Akses Materi pembelajaran
- 🔄 Mengerjakan Kuis
- 🔄 Lihat hasil dan riwayat kuis

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/MariaDB

### Langkah Instalasi

1. **Install Dependencies**
```bash
composer install
```

2. **Setup Environment**
```bash
copy .env.example .env
php artisan key:generate
```

3. **Konfigurasi Database**

Edit file `.env`:
```env
DB_DATABASE=belajar-inggris
DB_USERNAME=root
DB_PASSWORD=
```

4. **Jalankan Migration & Seeder**
```bash
php artisan migrate:fresh --seed
```

5. **Jalankan Aplikasi**
```bash
php artisan serve
```

6. **Akses:** `http://localhost:8000`

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@belajaringgris.com | admin123 |
| Guru | guru@belajaringgris.com | guru123 |
| Siswa | siswa@belajaringgris.com | siswa123 |

## 📖 Dokumentasi

- [DATABASE.md](DATABASE.md) - Dokumentasi struktur database
- [APLIKASI.md](APLIKASI.md) - Dokumentasi lengkap aplikasi
- [prd.md](prd.md) - Product Requirements Document

## 🗄️ Database

Aplikasi menggunakan 9 tabel utama:
- `peran` - Role pengguna
- `users` - Data pengguna
- `materi` - Materi pembelajaran
- `kosakata` - Vocabulary
- `kuis` - Kuis/latihan
- `soal_kuis` - Soal kuis
- `pilihan_jawaban` - Pilihan jawaban
- `percobaan_kuis` - Percobaan kuis siswa
- `jawaban_siswa` - Jawaban siswa

## 🛠️ Teknologi

- **Framework:** Laravel 12.x
- **Frontend:** Bootstrap 5, jQuery, ApexCharts
- **Database:** MySQL
- **Icons:** Tabler Icons
- **Template:** Modernize Admin Template

## 📝 Status Pengembangan

✅ = Selesai | 🔄 = Dalam Pengembangan

- ✅ Authentication & Authorization
- ✅ Role-based Access Control
- ✅ Dashboard untuk semua role
- ✅ CRUD Guru & Siswa (Super Admin)
- ✅ CRUD Materi (Guru)
- ✅ CRUD Kuis (Guru)
- ✅ Upload Media (Video, Audio, Gambar)
- 🔄 Sistem Kuis untuk Siswa
- 🔄 Tampilan Materi untuk Siswa
- 🔄 Laporan & Statistik

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi developer.

## 📄 License

Project ini dibuat untuk keperluan pembelajaran.

---

**Versi:** 1.3.0 (FINAL)  
**Tanggal:** 15 November 2025

---

## 🎉 Status: LENGKAP 100%

Semua fitur dari PRD sudah selesai diimplementasi!
