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

## 🎉 APLIKASI LENGKAP 100%

Semua fitur dari PRD sudah terimplementasi:
- ✅ Super Admin: Kelola Guru & Siswa
- ✅ Guru: Kelola Materi & Kuis
- ✅ Siswa: Akses Materi & Kerjakan Kuis
- ✅ Upload Media (Video, Audio, Gambar)
- ✅ Sistem Kuis Interaktif dengan Timer
- ✅ Seeder Lengkap untuk Testing
