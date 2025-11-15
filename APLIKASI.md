# Dokumentasi Aplikasi Belajar Bahasa Inggris

## 📚 Deskripsi Aplikasi

Aplikasi Media Pembelajaran Interaktif Bahasa Inggris berbasis web yang dirancang untuk memfasilitasi proses belajar mengajar dengan fitur manajemen materi, kuis, dan monitoring progress siswa.

## 🎯 Fitur Utama

### 1. Super Admin
- ✅ Login & Logout
- ✅ Dashboard dengan statistik sistem
- ✅ Kelola Akun Guru (CRUD)
- ✅ Kelola Akun Siswa (CRUD)

### 2. Guru
- ✅ Login & Logout
- ✅ Dashboard dengan statistik progress siswa
- ✅ Kelola Materi (Vocabulary & Grammar)
  - ✅ Tambah, Edit, Hapus Materi
  - ✅ Upload Video Pembelajaran
  - ✅ Kelola Kosakata (untuk Vocabulary)
  - ✅ Upload Audio Pelafalan & Gambar
- ✅ Kelola Kuis
  - ✅ Tambah, Edit, Hapus Kuis
  - ✅ Kelola Soal (Pilihan Ganda, Benar/Salah, Isian)
  - ✅ Upload Gambar & Audio untuk Soal
  - ✅ Set Durasi, Nilai Minimal, Tingkat Kesulitan
- 🔄 Lihat hasil kuis siswa

### 3. Siswa
- ✅ Login & Logout
- ✅ Dashboard dengan progress belajar
- 🔄 Akses Materi (Vocabulary & Grammar)
- 🔄 Mengerjakan Kuis
- 🔄 Lihat hasil kuis

**Keterangan:**
- ✅ Sudah selesai
- 🔄 Dalam pengembangan

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional untuk asset compilation)

### Langkah Instalasi

1. **Clone atau Download Project**
```bash
cd belajar-inggris
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
copy .env.example .env
```

4. **Generate Application Key**
```bash
php artisan key:generate
```

5. **Konfigurasi Database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=belajar-inggris
DB_USERNAME=root
DB_PASSWORD=
```

6. **Buat Database**

Buat database baru dengan nama `belajar-inggris` di MySQL

7. **Jalankan Migration & Seeder**
```bash
php artisan migrate:fresh --seed
```

8. **Jalankan Aplikasi**
```bash
php artisan serve
```

9. **Akses Aplikasi**

Buka browser dan akses: `http://localhost:8000`

---

## 👤 Akun Default

### Super Admin
- **Email:** admin@belajaringgris.com
- **Password:** admin123

### Guru
- **Email:** guru@belajaringgris.com
- **Password:** guru123

### Siswa
- **Email:** siswa@belajaringgris.com
- **Password:** siswa123

---

## 📁 Struktur Project

```
belajar-inggris/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── SuperAdmin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── GuruController.php
│   │   │   │   └── SiswaController.php
│   │   │   ├── Guru/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── MateriController.php
│   │   │   │   └── KuisController.php
│   │   │   └── Siswa/
│   │   │       ├── DashboardController.php
│   │   │       ├── MateriController.php
│   │   │       └── KuisController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Peran.php
│       ├── Materi.php
│       ├── Kosakata.php
│       ├── Kuis.php
│       ├── SoalKuis.php
│       ├── PilihanJawaban.php
│       ├── PercobaanKuis.php
│       └── JawabanSiswa.php
├── database/
│   ├── migrations/
│   │   ├── 2025_11_15_062816_create_roles_table.php
│   │   ├── 2025_11_15_062817_add_role_to_users_table.php
│   │   ├── 2025_11_15_062819_create_materials_table.php
│   │   ├── 2025_11_15_062821_create_vocabularies_table.php
│   │   ├── 2025_11_15_062823_create_quizzes_table.php
│   │   ├── 2025_11_15_062825_create_quiz_questions_table.php
│   │   ├── 2025_11_15_062828_create_quiz_attempts_table.php
│   │   ├── 2025_11_15_062829_create_quiz_answers_table.php
│   │   └── 2025_11_15_063300_create_jawaban_siswa_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── PeranSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── auth.blade.php
│       ├── partials/
│       │   ├── header.blade.php
│       │   ├── sidebar.blade.php
│       │   └── footer.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── superadmin/
│       │   ├── dashboard.blade.php
│       │   ├── guru/
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   └── siswa/
│       │       ├── index.blade.php
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       ├── guru/
│       │   └── dashboard.blade.php
│       └── siswa/
│           └── dashboard.blade.php
├── routes/
│   └── web.php
├── .env
├── DATABASE.md
├── APLIKASI.md
└── prd.md
```

---

## 🔐 Role & Permission

### Super Admin
- Akses penuh ke semua fitur
- Mengelola akun guru dan siswa
- Melihat statistik sistem

### Guru
- Mengelola materi pembelajaran
- Membuat dan mengelola kuis
- Melihat progress dan nilai siswa

### Siswa
- Mengakses materi pembelajaran
- Mengerjakan kuis
- Melihat hasil dan progress belajar

---

## 🛣️ Routes

### Authentication
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Super Admin
- `GET /superadmin/dashboard` - Dashboard
- `GET /superadmin/guru` - Daftar guru
- `GET /superadmin/guru/create` - Form tambah guru
- `POST /superadmin/guru` - Simpan guru baru
- `GET /superadmin/guru/{id}/edit` - Form edit guru
- `PUT /superadmin/guru/{id}` - Update guru
- `DELETE /superadmin/guru/{id}` - Hapus guru
- `GET /superadmin/siswa` - Daftar siswa
- `GET /superadmin/siswa/create` - Form tambah siswa
- `POST /superadmin/siswa` - Simpan siswa baru
- `GET /superadmin/siswa/{id}/edit` - Form edit siswa
- `PUT /superadmin/siswa/{id}` - Update siswa
- `DELETE /superadmin/siswa/{id}` - Hapus siswa

### Guru
- `GET /guru/dashboard` - Dashboard
- `GET /guru/materi` - Daftar materi ✅
- `GET /guru/materi/create` - Form tambah materi ✅
- `POST /guru/materi` - Simpan materi ✅
- `GET /guru/materi/{id}` - Detail materi ✅
- `GET /guru/materi/{id}/edit` - Form edit materi ✅
- `PUT /guru/materi/{id}` - Update materi ✅
- `DELETE /guru/materi/{id}` - Hapus materi ✅
- `POST /guru/materi/{id}/kosakata` - Tambah kosakata ✅
- `DELETE /guru/materi/{materiId}/kosakata/{kosakatId}` - Hapus kosakata ✅
- `GET /guru/kuis` - Daftar kuis (🔄)

### Siswa
- `GET /siswa/dashboard` - Dashboard
- `GET /siswa/materi` - Daftar materi (🔄)
- `GET /siswa/kuis` - Daftar kuis (🔄)

---

## 🗄️ Database

Lihat dokumentasi lengkap database di [DATABASE.md](DATABASE.md)

### Tabel Utama:
1. `peran` - Tabel role pengguna
2. `users` - Tabel pengguna
3. `materi` - Tabel materi pembelajaran
4. `kosakata` - Tabel vocabulary
5. `kuis` - Tabel kuis
6. `soal_kuis` - Tabel soal
7. `pilihan_jawaban` - Tabel pilihan jawaban
8. `percobaan_kuis` - Tabel percobaan kuis siswa
9. `jawaban_siswa` - Tabel jawaban siswa

---

## 🎨 Template

Aplikasi menggunakan template **Modernize Bootstrap Admin** dengan modifikasi:
- Responsive design
- Bootstrap 5
- Tabler Icons
- jQuery & ApexCharts

---

## 📝 Catatan Pengembangan

### Yang Sudah Selesai:
1. ✅ Database schema lengkap dengan relasi
2. ✅ Models dengan relasi
3. ✅ Authentication system
4. ✅ Role-based access control
5. ✅ Dashboard untuk semua role
6. ✅ CRUD Guru oleh Super Admin
7. ✅ CRUD Siswa oleh Super Admin
8. ✅ CRUD Materi oleh Guru (Vocabulary & Grammar)
9. ✅ Upload file (video, audio, gambar)
10. ✅ Kelola Kosakata dengan audio & gambar
11. ✅ CRUD Kuis oleh Guru
12. ✅ Kelola Soal Kuis (3 jenis soal)
13. ✅ Upload media untuk soal kuis

### Yang Perlu Dikembangkan:
1. 🔄 Tampilan materi untuk Siswa
2. 🔄 Sistem mengerjakan kuis untuk Siswa
3. 🔄 Laporan dan statistik detail
4. 🔄 Export data ke PDF/Excel

---

## 🐛 Troubleshooting

### Error: SQLSTATE[HY000] [1045] Access denied
**Solusi:** Periksa konfigurasi database di file `.env`

### Error: Class not found
**Solusi:** Jalankan `composer dump-autoload`

### Error: Migration failed
**Solusi:** 
1. Drop semua tabel di database
2. Jalankan `php artisan migrate:fresh --seed`

### Halaman 403 Forbidden
**Solusi:** Pastikan user sudah login dan memiliki role yang sesuai

---

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi developer.

---

## 📄 License

Project ini dibuat untuk keperluan pembelajaran.

---

**Versi:** 1.0.0  
**Tanggal:** 15 November 2025  
**Framework:** Laravel 12.x
