# Changelog

## [1.3.0] - 2025-11-15 (FINAL RELEASE) 🎉

### ✅ Fitur Baru - Sistem Lengkap untuk Siswa

#### Fitur yang Ditambahkan:
1. **Tampilan Materi untuk Siswa**
   - Daftar materi dengan grid card
   - Detail materi Grammar (konten + video)
   - Detail materi Vocabulary (kosakata + audio + gambar)
   - Modal zoom untuk gambar
   - Audio player untuk pelafalan

2. **Sistem Kuis Interaktif**
   - Daftar kuis dengan info percobaan
   - Detail kuis dengan riwayat
   - Mengerjakan kuis dengan timer real-time
   - Auto-submit saat waktu habis
   - Support 3 jenis soal
   - Hasil kuis dengan pembahasan
   - Highlight jawaban benar/salah

3. **Seeder Lengkap**
   - 6 materi (3 Grammar + 3 Vocabulary)
   - 30 kosakata dengan contoh
   - 4 kuis dengan berbagai tingkat
   - 13 soal dengan 48 pilihan jawaban
   - Data siap pakai untuk testing

#### File yang Ditambahkan:
- `app/Http/Controllers/Siswa/MateriController.php`
- `app/Http/Controllers/Siswa/KuisController.php`
- `resources/views/siswa/materi/index.blade.php`
- `resources/views/siswa/materi/show.blade.php`
- `resources/views/siswa/kuis/index.blade.php`
- `resources/views/siswa/kuis/show.blade.php`
- `resources/views/siswa/kuis/mengerjakan.blade.php`
- `resources/views/siswa/kuis/hasil.blade.php`
- `database/seeders/MateriSeeder.php`
- `database/seeders/KuisSeeder.php`
- `SEEDER.md`

---

## [1.2.0] - 2025-11-15

### ✅ Fitur Baru - CRUD Kuis untuk Guru

#### Fitur yang Ditambahkan:
1. **Kelola Kuis**
   - Tambah kuis baru
   - Edit kuis
   - Hapus kuis
   - Lihat detail kuis
   - Hubungkan dengan materi
   - Set durasi, nilai minimal, tingkat kesulitan
   - Opsi acak soal & tampilkan jawaban

2. **Kelola Soal Kuis**
   - Tambah soal dengan modal
   - 3 jenis soal: Pilihan Ganda, Benar/Salah, Isian
   - Upload gambar soal (max 2MB)
   - Upload audio soal (max 5MB)
   - Set poin per soal
   - Hapus soal
   - Tampilan jawaban benar

#### File yang Ditambahkan:
- `app/Http/Controllers/Guru/KuisController.php`
- `resources/views/guru/kuis/index.blade.php`
- `resources/views/guru/kuis/create.blade.php`
- `resources/views/guru/kuis/edit.blade.php`
- `resources/views/guru/kuis/show.blade.php`

#### Routes yang Ditambahkan:
- `GET /guru/kuis` - Daftar kuis
- `GET /guru/kuis/create` - Form tambah kuis
- `POST /guru/kuis` - Simpan kuis baru
- `GET /guru/kuis/{id}` - Detail kuis & kelola soal
- `GET /guru/kuis/{id}/edit` - Form edit kuis
- `PUT /guru/kuis/{id}` - Update kuis
- `DELETE /guru/kuis/{id}` - Hapus kuis
- `POST /guru/kuis/{id}/soal` - Tambah soal
- `DELETE /guru/kuis/{kuisId}/soal/{soalId}` - Hapus soal

---

## [1.1.0] - 2025-11-15

### ✅ Fitur Baru - CRUD Materi untuk Guru

#### Fitur yang Ditambahkan:
1. **Kelola Materi**
   - Tambah materi baru (Vocabulary & Grammar)
   - Edit materi
   - Hapus materi
   - Lihat detail materi
   - Upload video pembelajaran
   - Set urutan dan status aktif/nonaktif

2. **Kelola Kosakata (untuk Vocabulary)**
   - Tambah kosakata dengan modal
   - Upload audio pelafalan
   - Upload gambar ilustrasi
   - Hapus kosakata
   - Contoh kalimat
   - Jenis kata (noun, verb, adjective, dll)

#### File yang Ditambahkan:
- `app/Http/Controllers/Guru/MateriController.php`
- `resources/views/guru/materi/index.blade.php`
- `resources/views/guru/materi/create.blade.php`
- `resources/views/guru/materi/edit.blade.php`
- `resources/views/guru/materi/show.blade.php`

#### Routes yang Ditambahkan:
- `GET /guru/materi` - Daftar materi
- `GET /guru/materi/create` - Form tambah materi
- `POST /guru/materi` - Simpan materi baru
- `GET /guru/materi/{id}` - Detail materi
- `GET /guru/materi/{id}/edit` - Form edit materi
- `PUT /guru/materi/{id}` - Update materi
- `DELETE /guru/materi/{id}` - Hapus materi
- `POST /guru/materi/{id}/kosakata` - Tambah kosakata
- `DELETE /guru/materi/{materiId}/kosakata/{kosakatId}` - Hapus kosakata

#### Fitur Upload:
- Video pembelajaran (mp4, avi, mov - max 50MB)
- Audio pelafalan (mp3, wav - max 5MB)
- Gambar ilustrasi (jpg, png - max 2MB)
- Storage link sudah dikonfigurasi

---

## [1.0.0] - 2025-11-15

### ✅ Rilis Awal

#### Database:
- 9 tabel dengan relasi lengkap
- Migrations dengan field berbahasa Indonesia
- Seeder untuk data awal (3 role + 3 user)

#### Authentication:
- Login/Logout system
- Role-based access control
- Middleware CheckRole

#### Super Admin:
- Dashboard dengan statistik
- CRUD Guru (index, create, edit, delete)
- CRUD Siswa (index, create, edit, delete)

#### Guru:
- Dashboard dengan statistik materi & kuis
- Statistik progress siswa

#### Siswa:
- Dashboard dengan progress belajar
- Riwayat kuis
- Materi terbaru

#### UI/UX:
- Template Modernize Bootstrap
- Responsive design
- Sidebar dinamis berdasarkan role
- Alert notifications

#### Dokumentasi:
- README.md
- DATABASE.md
- APLIKASI.md
- prd.md

---

## 🔄 Roadmap

### [1.2.0] - Released ✅
- ✅ CRUD Kuis untuk Guru
- ✅ Tambah soal kuis (3 jenis)
- ✅ Pilihan jawaban
- ✅ Pengaturan kuis (durasi, nilai minimal, dll)
- ✅ Upload media untuk soal

### [1.3.0] - Planned
- Tampilan materi untuk Siswa
- Akses vocabulary dengan audio
- Akses grammar dengan video
- Pencarian materi

### [1.4.0] - Planned
- Sistem mengerjakan kuis untuk Siswa
- Timer kuis
- Submit jawaban
- Lihat hasil dan pembahasan

### [1.5.0] - Planned
- Laporan dan statistik detail
- Export data ke PDF/Excel
- Grafik progress siswa
- Analisis hasil kuis

---

## 📝 Catatan Teknis

### Perubahan Database:
- Tidak ada perubahan struktur database

### Breaking Changes:
- Tidak ada

### Bug Fixes:
- Tidak ada

### Dependencies:
- Laravel 12.x
- PHP 8.2+
- MySQL/MariaDB

---

**Versi Saat Ini:** 1.3.1 (FINAL)  
**Tanggal Update:** 15 November 2025

---

## [1.3.1] - 2025-11-15 (Enhancement)

### ✅ Rich Text Editor (Trix Editor via Rich Text Laravel)

#### Fitur yang Ditambahkan:
1. **Rich Text Laravel Package**
   - Package: tonysm/rich-text-laravel
   - Trix Editor integration
   - Rich text editor untuk konten materi
   - Rich text editor untuk deskripsi kuis
   - Toolbar: bold, italic, heading, lists, links, quotes, code
   - File attachments support
   - Auto-save dan preview

2. **Custom CSS untuk Konten HTML**
   - Styling untuk heading, paragraf, lists
   - Styling untuk links, images, tables
   - Styling untuk code blocks dan blockquotes
   - Responsive dan mobile-friendly

#### Package Installed:
```bash
composer require tonysm/rich-text-laravel
php artisan richtext:install
php artisan migrate
```

#### File yang Dimodifikasi:
- `resources/views/layouts/app.blade.php` - Rich Text styles
- `resources/views/guru/materi/create.blade.php` - Trix input
- `resources/views/guru/materi/edit.blade.php` - Trix input
- `resources/views/guru/materi/show.blade.php` - Render HTML
- `resources/views/guru/kuis/create.blade.php` - Trix input
- `resources/views/guru/kuis/edit.blade.php` - Trix input
- `resources/views/siswa/materi/show.blade.php` - Render HTML

#### File yang Ditambahkan:
- `public/assets/css/custom.css` - Custom styling
- `database/migrations/2025_11_15_105605_create_rich_texts_table.php` - Rich texts table

---

---

## [1.3.2] - 2025-11-20 (Sistem Kelas & Seeder Lengkap) 🎓

### ✅ Sistem Kelas 7 & 8

#### Fitur yang Ditambahkan:
1. **Sistem Kelas Terintegrasi**
   - Guru memiliki `kelas_mengajar` (7 atau 8)
   - Siswa memiliki `kelas` (7 atau 8)
   - Materi memiliki `kelas_target` (7 atau 8)
   - Kuis memiliki `kelas_target` (7 atau 8)
   - Auto-filter data berdasarkan kelas
   - Isolasi data antar kelas

2. **Seeder Lengkap & Realistis**
   - **GuruSeeder**: 4 guru (2 kelas 7, 2 kelas 8)
   - **SiswaSeeder**: 10 siswa (5 kelas 7, 5 kelas 8)
   - **MateriSeeder**: 10 materi + 50 kosakata
     - Kelas 7: 6 materi (Simple Present, Present Continuous, Simple Past, Daily Activities, Family Members, Colors)
     - Kelas 8: 4 materi (Present Perfect, Passive Voice, Technology, Environment)
   - **KuisSeeder**: 7 kuis + 19 soal + 70 pilihan jawaban
     - Kelas 7: 4 kuis (Simple Present, Daily Activities, Family Members, Mixed Grammar)
     - Kelas 8: 3 kuis (Present Perfect, Technology, Passive Voice)
   - **PercobaanKuisSeeder** ⭐ **BARU**: 26 percobaan + 96 jawaban
     - Status: Selesai, Sedang Dikerjakan, Waktu Habis
     - Nilai otomatis dihitung
     - Timestamp realistis

#### File yang Ditambahkan:
- `database/seeders/PercobaanKuisSeeder.php` - Seeder percobaan kuis ⭐ **BARU**
- `SEEDER_LENGKAP.md` - Dokumentasi lengkap seeder
- `SEEDER_GURU_SISWA.md` - Dokumentasi guru & siswa seeder

#### File yang Dimodifikasi:
- `database/seeders/DatabaseSeeder.php` - Tambah semua seeder
- `database/seeders/MateriSeeder.php` - Support kelas 7 & 8
- `database/seeders/KuisSeeder.php` - Support kelas 7 & 8
- `database/seeders/GuruSeeder.php` - Tambah kelas_mengajar
- `database/seeders/SiswaSeeder.php` - Tambah kelas

#### Migration:
- `2025_11_20_005615_add_kelas_to_users_and_content_tables.php`
  - Tambah `kelas_mengajar` ke users (untuk guru)
  - Tambah `kelas_target` ke materi
  - Tambah `kelas_target` ke kuis

#### Data Seeder:
- **17 Users**: 3 admin + 4 guru + 10 siswa
- **10 Materi**: 6 kelas 7 + 4 kelas 8
- **50 Kosakata**: 30 kelas 7 + 20 kelas 8
- **7 Kuis**: 4 kelas 7 + 3 kelas 8
- **19 Soal**: 13 kelas 7 + 6 kelas 8
- **70 Pilihan Jawaban**: 48 kelas 7 + 22 kelas 8
- **26 Percobaan Kuis**: ~15 kelas 7 + ~11 kelas 8
- **96 Jawaban Siswa**: Data lengkap untuk testing

#### Login Credentials:
**Guru Kelas 7:**
- `budi.guru@example.com` / `password123`
- `siti.guru@example.com` / `password123`

**Guru Kelas 8:**
- `ahmad.guru@example.com` / `password123`
- `dewi.guru@example.com` / `password123`

**Siswa Kelas 7:**
- `andi.siswa@example.com` / `password123`
- `bella.siswa@example.com` / `password123`
- (dan 3 lainnya)

**Siswa Kelas 8:**
- `farah.siswa@example.com` / `password123`
- `gilang.siswa@example.com` / `password123`
- (dan 3 lainnya)

---

## 🎉 APLIKASI LENGKAP 100%

Semua fitur dari PRD sudah terimplementasi:
- ✅ Super Admin: Kelola Guru & Siswa
- ✅ Guru: Kelola Materi & Kuis
- ✅ Siswa: Akses Materi & Kerjakan Kuis
- ✅ Upload Media (Video, Audio, Gambar)
- ✅ Sistem Kuis Interaktif dengan Timer
- ✅ Sistem Kelas 7 & 8 Terintegrasi ⭐ **BARU**
- ✅ Seeder Lengkap untuk Testing (17 users, 10 materi, 7 kuis, 26 percobaan) ⭐ **BARU**
