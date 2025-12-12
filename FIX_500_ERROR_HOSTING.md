# 🔧 Fix: 500 Server Error - Kelola Guru & Siswa di Hosting

## 🐛 Problem

Saat mengakses halaman "Kelola Guru" dan "Kelola Siswa" di server hosting, muncul error **500 Server Error**.

## 🔍 Root Cause

Tabel `guru` dan `siswa` **belum dibuat di database hosting** karena migration belum dijalankan.

Migration yang diperlukan:
- `2025_11_30_000001_create_siswa_table.php`
- `2025_11_30_000002_create_guru_table.php`

## ✅ Solution

### Langkah 1: SSH ke Server Hosting

```bash
ssh user@your-server.com
cd /path/to/your/laravel/project
```

### Langkah 2: Jalankan Migration

```bash
php artisan migrate
```

Atau jika ingin melihat status migration terlebih dahulu:

```bash
# Cek status migration
php artisan migrate:status

# Jalankan migration yang pending
php artisan migrate
```

### Langkah 3: Verifikasi Tabel

```bash
php artisan tinker
>>> Schema::hasTable('guru')
>>> Schema::hasTable('siswa')
```

Kedua perintah harus mengembalikan `true`.

## 📋 Migration yang Diperlukan

### 1. `2025_11_30_000001_create_siswa_table.php`

```php
Schema::create('siswa', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('nis')->unique();
    $table->string('kelas');
    $table->string('nama_lengkap');
    $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
    $table->string('tempat_lahir')->nullable();
    $table->date('tanggal_lahir')->nullable();
    $table->text('alamat')->nullable();
    $table->string('no_telepon')->nullable();
    $table->string('nama_orang_tua')->nullable();
    $table->string('no_telepon_orang_tua')->nullable();
    $table->timestamps();
});
```

### 2. `2025_11_30_000002_create_guru_table.php`

```php
Schema::create('guru', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('nip')->unique();
    $table->string('nama_lengkap');
    $table->string('kelas_mengajar')->nullable();
    $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
    $table->string('tempat_lahir')->nullable();
    $table->date('tanggal_lahir')->nullable();
    $table->text('alamat')->nullable();
    $table->string('no_telepon')->nullable();
    $table->string('pendidikan_terakhir')->nullable();
    $table->string('bidang_studi')->nullable();
    $table->timestamps();
});
```

## 🚀 Quick Fix Commands

### Untuk cPanel/Shared Hosting (via Terminal)

```bash
cd ~/public_html  # atau path ke project Laravel
php artisan migrate --force
```

### Untuk VPS/Dedicated Server

```bash
cd /var/www/html/your-project
php artisan migrate --force
```

### Jika Tidak Ada Akses SSH

1. Buka phpMyAdmin
2. Pilih database aplikasi
3. Jalankan SQL berikut:

```sql
-- Tabel Siswa
CREATE TABLE `siswa` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned NOT NULL,
    `nis` varchar(255) NOT NULL,
    `kelas` varchar(255) NOT NULL,
    `nama_lengkap` varchar(255) NOT NULL,
    `jenis_kelamin` enum('L','P') DEFAULT NULL,
    `tempat_lahir` varchar(255) DEFAULT NULL,
    `tanggal_lahir` date DEFAULT NULL,
    `alamat` text,
    `no_telepon` varchar(255) DEFAULT NULL,
    `nama_orang_tua` varchar(255) DEFAULT NULL,
    `no_telepon_orang_tua` varchar(255) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `siswa_nis_unique` (`nis`),
    KEY `siswa_user_id_foreign` (`user_id`),
    CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Guru
CREATE TABLE `guru` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint unsigned NOT NULL,
    `nip` varchar(255) NOT NULL,
    `nama_lengkap` varchar(255) NOT NULL,
    `kelas_mengajar` varchar(255) DEFAULT NULL,
    `jenis_kelamin` enum('L','P') DEFAULT NULL,
    `tempat_lahir` varchar(255) DEFAULT NULL,
    `tanggal_lahir` date DEFAULT NULL,
    `alamat` text,
    `no_telepon` varchar(255) DEFAULT NULL,
    `pendidikan_terakhir` varchar(255) DEFAULT NULL,
    `bidang_studi` varchar(255) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `guru_nip_unique` (`nip`),
    KEY `guru_user_id_foreign` (`user_id`),
    CONSTRAINT `guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Update migration table
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2025_11_30_000001_create_siswa_table', (SELECT MAX(batch) + 1 FROM (SELECT batch FROM migrations) AS m)),
('2025_11_30_000002_create_guru_table', (SELECT MAX(batch) + 1 FROM (SELECT batch FROM migrations) AS m2));
```

## 🔍 Troubleshooting

### Error: "Access denied for user"
```bash
# Cek konfigurasi database di .env
cat .env | grep DB_
```

### Error: "Migration table not found"
```bash
php artisan migrate:install
php artisan migrate
```

### Error: "Table already exists"
```bash
# Cek apakah tabel sudah ada
php artisan tinker
>>> Schema::hasTable('guru')
>>> Schema::hasTable('siswa')
```

### Masih Error 500?
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cek log error
tail -f storage/logs/laravel.log
```

## ✅ Verification

Setelah menjalankan migration, test dengan:

1. Login sebagai Super Admin
2. Buka menu "Kelola Guru" → Harus tampil tanpa error
3. Buka menu "Kelola Siswa" → Harus tampil tanpa error
4. Coba tambah data guru baru
5. Coba tambah data siswa baru

## 📝 Notes

### Struktur Database

Aplikasi menggunakan 2 tabel terpisah untuk data detail:
- `users` - Data login (email, password, peran_id)
- `guru` - Data detail guru (NIP, kelas_mengajar, dll)
- `siswa` - Data detail siswa (NIS, kelas, dll)

### Relasi
- `users.id` → `guru.user_id` (1:1)
- `users.id` → `siswa.user_id` (1:1)

### Accessor di Model User
```php
// Mendapatkan kelas siswa
$user->kelas // dari $user->siswa->kelas

// Mendapatkan kelas mengajar guru
$user->kelas_mengajar // dari $user->guru->kelas_mengajar
```

---

**Issue Date**: 2025-11-20  
**Status**: ✅ SOLUTION PROVIDED  
**Root Cause**: Missing migration on hosting server
